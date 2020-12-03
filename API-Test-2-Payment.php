<?php

define('OM_PROTOCOL', 'https');
define('OM_HOST', 'api.orange.com');
define('OM_CONTEXT_ACCESSTOKEN', 'oauth/v2/token');
define('OM_CONTEXT_REQUESTWP', 'orange-money-webpay/cm/v1/webpayment');
define('OM_URL_AT', OM_PROTOCOL . '://' . OM_HOST . '/' . OM_CONTEXT_ACCESSTOKEN);
define('OM_URL_WP', OM_PROTOCOL . '://' . OM_HOST . '/' . OM_CONTEXT_REQUESTWP);

$currency="XAF";
//$currency="OUV";

$price = 10000;
$this->_post= array(
  "merchant_key" => $this->merchant_key,
  "currency" => $currency,
  "order_id" => "123457",
  "amount" => $price,
  "return_url" => "http://www.y-note.cm/return",
  "cancel_url" => "http://www.y-note.cm/cancel",
  "notif_url" => "http://www.y-note.cm/notification",
  "lang" => "fr",
  "reference" => "Y-Note",
);

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


//Check if there are no errors ie httpresponse == 200 -OK
if ($returnCode == 201) {
    //This line declares the Link to pay for this transaction
    $paylink = $response_decode->payment_url;
    $notif_token = $response_decode->notif_token;
    echo 'Payment URL: '.$paylink;
    echo '<br/><strong>Redirection vers la <a href="'.$paylink.'">plateforme de paiement OrangeMoney </a></strong>';
    //return $paylink;
} else {
    //Get return Error Code, If there was an error during call
    //
    switch($returnCode){
        default:
            echo 'Payment Error : '.$returnCode.'<br/>';
            echo 'Payment Message : '.$response_decode->message.'<br/>';
            $result = 'HTTP ERROR -> ' . $returnCode.'<br/>';
            $result.= 'Message : '.$response_decode->message.'<br/>';
            break;
    }
    echo $result;
}