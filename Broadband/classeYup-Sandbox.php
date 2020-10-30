<?php
set_time_limit(0);

class Ynote_Yup{

    private $tagPayUrl="33026";
    private $merchantid="2237199951774207";

    public $dbUrl="109.234.164.131";
    public $dbUser="ngma4782_broadband_paiement";
    public $dbPassword="fjH#YJ8QZg0&";
    public $dbBase="ngma4782_broadband_paiement";

    public function __construct() {
       
    }

    public function getSessionId(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://".$this->tagPayUrl.".tagpay.fr/online/online.php?merchantid=".$this->merchantid,
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
        echo $response;
    }


    public function payAction($nom,$numberInvoice,$tel,$amount){
        


        $mysqli = new mysqli($this->dbUrl, $this->dbUser, $this->dbPassword, $this->dbBase);
        $notification = "http://broadband.cm/facture/paiement-notificationYUP.php";
        $telClient=$tel;

        $this->getSessionId();
        
        $nom = $mysqli->real_escape_string($nom);
        $numberInvoice = $mysqli->real_escape_string($numberInvoice);
        $tel = $mysqli->real_escape_string($tel);
        $amount = $mysqli->real_escape_string($amount);

        if ($mysqli->connect_errno) {
            echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $request = "INSERT INTO Orders (nomClient, numberInvoice,telClient,channelUserMsisdn,amount,notifUrl,payToken,method) VALUES ('".$nom."', '".$numberInvoice."', '".$telClient."','".$this->channelUserMsisdn."','".$amount."','".$notification."','".$this->payToken."','Yup');";


        if($mysqli->query($request)){
            $latest_id =  mysqli_insert_id($mysqli);
        }

        $request = "UPDATE Orders SET status = '".$payResponse["data"]["status"]."' WHERE `orderId` = ".$latest_id.";";
        $mysqli->query($request);
        mysqli_close($mysqli);
        //echo json_encode($payResponse["data"]);
    }

}