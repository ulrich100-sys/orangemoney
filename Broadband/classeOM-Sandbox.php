<?php
set_time_limit(0);

class Ynote_Orangemoney{

    private $urlAPI="https://apiw.orange.cm/";
    private $bearerOM = "ck1mQWtaREVQYkZBclhURE1DNmpEbzlUYWpFYTpSMTlHemtoMk5kTE01U1Q3R1o2Z0RFRmxGNDRh";
    
    private $api_username="YNOTEPREPROD";
    private $api_password="YNOTEPREPROD2020";

    private $channelUserMsisdn="691301143";
    private $pinNumber="2222";

    private $b64Auth="";
    private $token="";
    private $payToken="";

    public $dbUrl="109.234.164.131";
    public $dbUser="ngma4782_zaYnote";
    public $dbPassword=";Gt8.)hq24m5";
    public $dbBase="ngma4782_azYnote";

    public function __construct() {
        $this->getToken();
    }

    private function getToken(){
      
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
        $this->b64Auth= base64_encode($this->api_username.":".$this->api_password);
        //var_dump($access_token);
        return $access_token;
    }

    public function getMpInit(){
        
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
        //var_dump($this->payToken);
        return $this->payToken;
    }

    public function payAction($nom,$prenom,$email,$tel){
        $this->getMpInit();
        $request_headers[] = 'Authorization: Bearer '.$this->token;
        array_push($request_headers,"X-AUTH-TOKEN: ".$this->b64Auth);
        
        if($this->payToken==""){
            return "{ 'error' : 'no payment Token'}";
        }
        $mysqli = new mysqli($this->dbUrl, $this->dbUser, $this->dbPassword, $this->dbBase);
        $notification = "http://za.y-note.cm/paiement-notification.php";
        $telClient=$tel;

        if ($mysqli->connect_errno) {
            echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $request = "INSERT INTO Orders (nomClient, prenomClient,telClient,channelUserMsisdn,amount,notifUrl,payToken,emailClient) VALUES ('".$nom."', '".$prenom."', '".$telClient."','".$this->channelUserMsisdn."','1','".$notification."','".$this->payToken."','".$email."');";


        if($mysqli->query($request)){
            $latest_id =  mysqli_insert_id($mysqli);
            //echo "Insert successful. Latest ID is: " . $latest_id;
        }else{
            //echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
        }

        $this->_post= array(
          "channelUserMsisdn" => $this->channelUserMsisdn,
          "pin" => $this->pinNumber,
          "subscriberMsisdn" => $telClient,
          "orderId" => "order-".$latest_id,
          "amount" => "1",
          "notifUrl" => $notification,
          "description" => "Achat Zone Alarm Security",
          "payToken" => $this->payToken,
        );

        $data_string = json_encode($this->_post);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->urlAPI."omcoreapis/1.0.2/mp/pay");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $request_headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT,20);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        

        $response = curl_exec($ch);
        $payResponse = json_decode($response,true);

        $request = "UPDATE Orders SET status = '".$payResponse["data"]["status"]."' WHERE `orderId` = ".$latest_id.";";
        $mysqli->query($request);
        mysqli_close($mysqli);
        echo json_encode($payResponse["data"]);
    }

    public function paycheck($paytoken){

        $request_headers[] = 'Authorization: Bearer '.$this->token;
        array_push($request_headers,"X-AUTH-TOKEN: ".$this->b64Auth);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->urlAPI."omcoreapis/1.0.2/mp/push/".$paytoken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  $request_headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT,20);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $payResponse = json_decode($response,true);
        return $payResponse["data"]["status"];
    }

}