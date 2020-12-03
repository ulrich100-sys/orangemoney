<?php
set_time_limit(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('./lib/stripe-php-7.61.0/init.php');

class Ynote_Stripe{

    private $sessionIdYup="";
    public $dbUrl;
    public $dbUser;
    public $dbPassword;
    public $dbBase;
    public $config = "";

    public function __construct() {
        $this->config = parse_ini_file('./config.ini');
        $this->dbUrl=$this->config['dbUrl'];
        $this->dbUser=$this->config['dbUser'];
        $this->dbPassword=$this->config['dbPassword'];
        $this->dbBase=$this->config['dbBase'];
        \Stripe\Stripe::setApiKey($this->config['stripe_secret_key']);  
    }

    public function sessionIdStripe($numberInvoice,$amount,$email,$purchaseref){
        
        $domain_url = $this->config['domain'];

        // Create new Checkout Session for the order
        // Other optional params include:
        // [billing_address_collection] - to display billing address details on the page
        // [customer] - if you have an existing Stripe Customer ID
        // [customer_email] - lets you prefill the email input in the form
        // For full details see https://stripe.com/docs/api/checkout/sessions/create

        // ?session_id={CHECKOUT_SESSION_ID} means the redirect will have the session ID set as a query param

        $product = \Stripe\Product::create([
          'name' => 'Y-Note Product :'.$numberInvoice,
        ]);
        $montant = intval($amount/655.957*100);

        $price_invoice = \Stripe\Price::create([
              'product' => $product["id"],
              'unit_amount' => $montant,
              'currency' => 'eur',
            ]);

        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $email,
            'success_url' => $domain_url . 'yup-confirmation.php?id='.$purchaseref,
            'cancel_url' => $domain_url . 'yup-cancel.php?id='.$purchaseref,
            'mode' => 'payment',
            'line_items' => [[
              'price' => $price_invoice['id'],
              'quantity' => 1,
            ]]
          ]);
        return $checkout_session;
    }
    public function payAction($numberInvoice,$purchaseref,$amount,$nom,$email){
        $mysqli = new mysqli($this->dbUrl, $this->dbUser, $this->dbPassword, $this->dbBase);
        
        
        $nom = $mysqli->real_escape_string($nom);
        $numberInvoice = $mysqli->real_escape_string($numberInvoice);
        $amount = $mysqli->real_escape_string($amount);
        $email = $mysqli->real_escape_string($email);
        $tel = '';
        if ($amount<(0.5*655.957)) {
            echo json_encode(['error' => "Le montant que vous essayé est trop petit pour être payé par carte bancaire" ]);
        }else{
            $sessionIdStripe = $this->sessionIdStripe($numberInvoice,$amount,$email,$purchaseref);


            if ($mysqli->connect_errno) {
                echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }

            $request = "INSERT INTO Orders (nomClient, numberInvoice,telClient,channelUserMsisdn,amount,payToken,method) VALUES ('".$nom."', '".$purchaseref."', '".$tel."','".$this->config['stripe_publishable_key']."','".$amount."','".$sessionIdStripe['id']."','Stripe');";

            if($mysqli->query($request)){
                $latest_id =  mysqli_insert_id($mysqli);
            }
            mysqli_close($mysqli);          
            echo json_encode(['id' => $sessionIdStripe['id']]);
        }

    }

    public function payCheck($idSession){
        $stripe = new \Stripe\StripeClient(
          $this->config['stripe_secret_key']
        );
        $sessionStripe=$stripe->checkout->sessions->retrieve(
          $idSession,
          []
        );
        return $sessionStripe["payment_status"];
    }

    public function confirmPaymentAction($amount,$status,$purchaseref,$error){
        $mysqli = new mysqli($this->dbUrl, $this->dbUser, $this->dbPassword, $this->dbBase);
        $amount = $mysqli->real_escape_string($amount);
        $status = $mysqli->real_escape_string($status);
        $purchaseref = $mysqli->real_escape_string($purchaseref);

        $request="";
        $requestInvoice="";
        $requestGetLicense="";

        $refExplode = explode('-',$purchaseref);

        if($status=="OK"){
            $status="SUCCESSFULL";
            $requestInvoice = "UPDATE Invoice SET idOrder = '".$refExplode[1]."' WHERE `codeInvoice` = '".$refExplode[0]."';";
            $requestGetInvoice = "select * from Invoice where codeInvoice='".$refExplode[0]."' limit 0,1";
            $request = "UPDATE Orders SET status = '".$status."' WHERE `amount` = ".$amount." and numberInvoice='".$refExplode[0]."' and idOrders='".$refExplode[1]."';";

        }

        if($status=='NOK'){
            $status=$mysqli->real_escape_string($error);
            $request = "UPDATE Orders SET status = '".$status."' WHERE numberInvoice='".$refExplode[0]."' and idOrders='".$refExplode[1]."';";

        }

        if ($mysqli->connect_errno) {
            echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        

        if($request!=''){
            $mysqli->query($request);
            var_dump($request);            
        }
        if((isset($requestInvoice))&&($requestInvoice!='')){
            $mysqli->query($requestInvoice);
            var_dump($requestGetInvoice);
        }
        $myfileOK = fopen("paiement-log-YUP-Nofif.txt", "a+");
        fwrite($myfileOK, 'request: '.$request."\n");
        if((isset($requestInvoice))&&($requestInvoice!='')){
            fwrite($myfileOK, 'requestInvoice: '.$requestInvoice."\n");
        }
        fclose($myfileOK);

        if((isset($requestGetInvoice))&&($requestGetInvoice!='')){
            $requestGetInvoice = $mysqli->query($requestGetInvoice);
            while($rowInvoice = $requestGetInvoice->fetch_assoc()) {
                $this->sendEmail($rowInvoice);   
            }
        }
        mysqli_close($mysqli);

    }

    function sendEmail($invoice) {
        $apiKey = 'f6eec11df75c2197debc2f059a267ed1';
        $secretKey = '553fa701c2e95f56e1f34775c099557b';
        $mj = new Mailjet($apiKey, $secretKey);

        $message = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR .'email/SolidPurple/index-confirm.html'); 
        $message=str_replace('{{userName}}', $invoice['nomClient'], $message);
        $message=str_replace('{{invoiceNumber}}', $invoice['invoiceNumber'], $message);
        $message=str_replace('{{montant}}', number_format ($invoice['montant'], 0, ',', ' '), $message);
        $message=str_replace('{{methodPaiement}}', "YUP", $message);
        $params = array(
            "method" => "POST",
            "from" => "hosting@y-note.cm",
            "to" => $invoice['emailClient'],
            "subject" => "Paiement de votre Facture Broadband :".$invoice['invoiceNumber'],
            "cc" => array("sales@y-note.cm","contact@broadband.cm"),
            "html" => $message
        );
        $result = $mj->sendEmail($params);
        if ($mj->_response_code == 200) {
            echo "success - email sent";
        } elseif ($mj->_response_code == 400) {
            echo "error - " . $mj->_response_code;
        } elseif ($mj->_response_code == 401) {
            echo "error - " . $mj->_response_code;
        } elseif ($mj->_response_code == 404) {
            echo "error - " . $mj->_response_code;
        } elseif ($mj->_response_code == 405) {
            echo "error - " . $mj->_response_code;
        }
    }

}