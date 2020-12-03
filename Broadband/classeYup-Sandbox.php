<?php
set_time_limit(0);

class Ynote_Yup{

    private $tagPayUrl="33026";
    private $merchantid="2237199951774207";

    private $sessionIdYup="";

    public $dbUrl="109.234.164.131";
    public $dbUser="ngma4782_broadband_paiement";
    public $dbPassword="fjH#YJ8QZg0&";
    public $dbBase="ngma4782_broadband_paiement";

    public function __construct() {
       
    }

    public function getSessionId(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://".$this->tagPayUrl.".tagpay.fr/api/online?merchantid=".$this->merchantid,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = explode(":",$response);
        return $response[1];
    }


    public function payAction($nom,$numberInvoice,$tel,$amount){
        $mysqli = new mysqli($this->dbUrl, $this->dbUser, $this->dbPassword, $this->dbBase);
        $notification = "https://broadband.cm/facture/paiement-notificationYUP.php";
        $telClient=$tel;

        $sessionIdYup = $this->getSessionId();

        $nom = $mysqli->real_escape_string($nom);
        $numberInvoice = $mysqli->real_escape_string($numberInvoice);
        $tel = $mysqli->real_escape_string($tel);
        $amount = $mysqli->real_escape_string($amount);

        if ($mysqli->connect_errno) {
            echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $request = "INSERT INTO Orders (nomClient, numberInvoice,telClient,channelUserMsisdn,amount,notifUrl,payToken,method) VALUES ('".$nom."', '".$numberInvoice."', '".$telClient."','".$this->merchantid."','".$amount."','".$notification."','".$sessionIdYup."','Yup');";

        if($mysqli->query($request)){
            $latest_id =  mysqli_insert_id($mysqli);
        }

        $payResponse=[];
        $payResponse["merchantid"]=$this->merchantid;
        $payResponse["session"]=$sessionIdYup;
        $payResponse["tagPayUrl"]=$this->tagPayUrl;
        $payResponse["refYup"]=$numberInvoice;
        $payResponse["refid"]=$latest_id;
        
        
        $mysqli->query($request);
        mysqli_close($mysqli);
        echo json_encode($payResponse);
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
            "subject" => "Réglement de votre Facture Broadband :".$invoice['invoiceNumber'],
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