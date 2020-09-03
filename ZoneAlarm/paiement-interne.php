<?php
session_start();

//ngma4782_azYnote
//ngma4782_zaYnote
//;Gt8.)hq24m5

class Ynote_Orangemoney{

    protected $urlAPI="https://apiw.orange.cm/";
    protected $bearerOM = "Z3FQcmdYdzZKV1BvWlNHa3RpZDhiaXI4dk9JYTpZNGZudHMwOG56cXBYZ2FoNDBWdmtjb01qMnNh";
    
    private $api_username="YNOTEPREPROD";
    private $api_password="YNOTEPREPROD2020";

    private $channelUserMsisdn="694849648";
    private $pinNumber="2222";

    public $b64Auth="";
    public $token="";
    public $payToken="";

    public function getToken(){
      
        $request_headers = array();
        $request_headers[] = 'Authorization: Basic '.$this->bearerOM;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->urlAPI."token");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $request_headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $response = explode(',',$response);
        $access_token = str_replace('"','',explode(':',$response[0])[1]);
        $returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $information = curl_getinfo($ch);
        curl_close($ch);
        $this->token=$access_token;
        return $access_token;
    }

    public function getMpInit(){
        
        $this->b64Auth= base64_encode($this->api_username.":".$this->api_password);
        $request_headers = array();
        $request_headers[] = 'Authorization: Bearer '.$this->token;
        array_push($request_headers,"X-AUTH-TOKEN: ".$this->b64Auth);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->urlAPI."omcoreapis/1.0.2/mp/init");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $request_headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        $payToken = json_decode($response,true);
        $this->payToken = $payToken["data"]["payToken"];
        return $this->payToken;
    }

    public function payAction(){
        $request_headers[] = 'Authorization: Bearer '.$this->token;
        array_push($request_headers,"X-AUTH-TOKEN: ".$this->b64Auth);
        
        $mysqli = new mysqli("109.234.164.131", "ngma4782_zaYnote", ";Gt8.)hq24m5", "ngma4782_azYnote");
        $notification = "http://az.y-note.cm/paiement-notification.php";

        $result = $mysqli->query("INSERT INTO `Orders` (`nomClient`, `prenomClient`, `telClient`,`channelUserMsisdn`,`amount`,`notifUrl`,`payToken`) VALUES ('nom', 'prenom', '123','".$this->channelUserMsisdn."','15000','".$notification."','".$this->payToken."');");
        var_dump($result);

        $this->_post= array(
          "channelUserMsisdn" => $this->channelUserMsisdn,
          "pin" => $this->pinNumber,
          "subscriberMsisdn" => "693600164",
          "orderId" => "1234",
          "amount" => "15000",
          "notifUrl" => $notification,
          "description" => "Achat Zone Alarm ",
          "payToken" => $this->payToken,
        );

        $data_string = json_encode($this->_post);
        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->urlAPI."omcoreapis/1.0.2/mp/pay");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $request_headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        */

        //$response = curl_exec($ch);
        //$payResponse = json_decode($response,true);
        //var_dump($payResponse);
        
    }

}

$om = new Ynote_Orangemoney();
$om->getToken();
//echo "<strong>Token : </strong>".$om->token."<br/>";
$om->getMpInit();
//echo "<strong>Pay Token : </strong>".$om->payToken;
$om->payAction();