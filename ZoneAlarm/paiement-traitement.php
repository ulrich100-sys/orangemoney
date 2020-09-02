<?php
session_start();
define('OM_PROTOCOL', 'https');
define('OM_HOST', 'api.orange.com');
define('OM_CONTEXT_ACCESSTOKEN', 'oauth/v2/token');
define('OM_CONTEXT_REQUESTWP', 'orange-money-webpay/cm/v1/webpayment');
define('OM_URL_AT', OM_PROTOCOL . '://' . OM_HOST . '/' . OM_CONTEXT_ACCESSTOKEN);
define('OM_URL_WP', OM_PROTOCOL . '://' . OM_HOST . '/' . OM_CONTEXT_REQUESTWP);

class Ynote_Orangemoney{

    protected $_responseUcollect = null;
    protected $_invoice = null;
    protected $_invoiceFlag = false;
    protected $_order = null;
    protected $_post = null;
    protected $_refNumber = null;
    public $access_token_response = "";

    public $authorizationHeader = "WUU2bWFnbjdjM2Q4YURvd0FBY0ZnVUk0TFlySDgyVm06WDlIV2NMazVvcnBxbFFHQg==";
    public $merchant_key = "07ae116c";

    public function redirectAction($formprice,$formreference,$formOrder){

        $request_headers = array();
        $request_headers[] = 'Authorization: Basic '.$this->authorizationHeader;

        $this->_postAK = array(
            "grant_type" => "client_credentials"
        );

        $currency="XAF";
        /*if(Mage::getStoreConfig('payment/orangemoney/develop_mode')==0){
            $currency="CM";
        }*/

        $price = $formprice;
        $this->_post= array(
          "merchant_key" => $this->merchant_key,
          "currency" => $currency,
          "order_id" => $_POST['exampleInputAP'],
          "amount" => $price,
          "return_url" => "http://www.idocta.africa/paiement-interne.php",
          "cancel_url" => "http://www.idocta.africa/paiement-interne.php",
          "notif_url" => "http://www.idocta.africa/paiement-notification.php",
          "lang" => "fr",
          "reference" => "iDocta",
        );

        /*** Construction de la première requête de gestion des Access Token */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, OM_URL_AT);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $request_headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $response = explode(',',$response);
        $access_token = explode(':',$response[1]);
        $returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $information = curl_getinfo($ch);
        curl_close($ch);

        $this->access_token_response=trim(str_replace("\"","",$access_token[1]));

        /*echo '<h1>----------Access Token------------</h1>';
        echo '<strong>ReturnCode:</strong> '. $returnCode.'<br/>';
        echo '<strong>Response:</strong> <br/>';
        var_dump($response);
        echo '<br/><strong>Access Token:</strong> '.$this->access_token_response.'<br/>';
        echo "<br/><strong> Request Header </strong>: <br/>";
        var_dump($information);
        echo '<br/>----------Access Token------------'.'<br/><br/>';
        */

        $chpay = curl_init();

        $data_string = json_encode($this->_post);
        curl_setopt($chpay, CURLOPT_URL, OM_URL_WP);
        curl_setopt($chpay, CURLOPT_POST, true);
        curl_setopt($chpay, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($chpay, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($chpay, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($chpay, CURLINFO_HEADER_OUT, true);
        curl_setopt($chpay, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->access_token_response,
            'Accept: application/json'));
        curl_setopt($chpay, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($chpay);
        $response_decode=json_decode($response);
        $informationPay = curl_getinfo($chpay);

        if(isset($response_decode->code)){
            $returnCode = $response_decode->code;
        }else{
            $returnCode = $response_decode->status;
        }

        /*echo '<h1>----------Payment ------------</h1>';
        echo '<strong>Post :</strong>';
        var_dump($data_string);
        echo '<strong>ReturnCode:</strong> '. $returnCode.'<br/>';
        echo '<strong>Response:</strong> <br/>';
        var_dump($response_decode);
        echo "<br/><strong> Request Header </strong>: <br/>";
        var_dump($informationPay);
        echo '<br/>----------Access Token------------'.'<br/><br/>';
*/

       
        //Check if there are no errors ie httpresponse == 200 -OK
        if ($returnCode == 201) {
            //This line declares the Link to pay for this transaction
            $paylink = $response_decode->payment_url;
            $notif_token = $response_decode->notif_token;
            //echo 'Payment URL: '.$paylink;
            return $paylink;
        } else {
            //Get return Error Code, If there was an error during call
            //
            switch($returnCode){
                default:
                    echo 'Payment Error : '.$returnCode.'<br/>';
                    echo 'Payment Message : '.$response_decode->message.'<br/>';
                    $result = 'HTTP ERROR -> ' . $returnCode.'<br/>';
                    $result.= 'Message : '.$response_decode->message.'<br/>';
                    $_SESSION["PaymentError"] = $returnCode;
                    $_SESSION["PaymentMessage"] = $response_decode->message;                  
                    break;
            }
            header('Location:  ./paiement-interne.php');
            echo $result;


        }
        
    }

}

$_SESSION["exampleInputNom"] = $_POST['exampleInputNom'];
$_SESSION["exampleInputAP"] = $_POST['exampleInputAP'];
$_SESSION["exampleInputMontant"] = $_POST['exampleInputMontant'];

$om = new Ynote_Orangemoney();
$redirectLink = $om->redirectAction($_POST['exampleInputMontant'],$_POST['exampleInputAP'],$_POST['exampleInputNom']+" - "+$_POST['exampleInputAP']);

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Redirection iDocta</title>
  </head>
  <body>
    <div class="container">
      <br/>
      <strong>Redirection vers la <a href="<?php echo $redirectLink; ?>">plateforme de paiement OrangeMoney </a></strong>
    </div>
  <script>
    window.location.replace("<?php echo $redirectLink; ?>");
  </script>
</body>
