<?php

include("php-mailjet-v3-simple.class.php");
include("lib/phpqrcode/qrlib.php");

class Ynote_Invoice{

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
    }


    public function sendMailInvoice($mailClient,$invoice){
            $apiKey = 'f6eec11df75c2197debc2f059a267ed1';
            $secretKey = '553fa701c2e95f56e1f34775c099557b';

            // Create a new Object
            $mj = new Mailjet($apiKey, $secretKey);

            $message = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR .'email/SolidPurple/index.html'); 
            $message=str_replace('{{userName}}', $invoice['nomClient'], $message);
            $message=str_replace('{{invoiceNumber}}', $invoice['invoiceNumber'], $message);
            $message=str_replace('{{montant}}', number_format ($invoice['montant'], 0, ',', ' '), $message);
            $message=str_replace('{{linkInvoice}}',"https://www.y-note.cm/facture/paie-facture.php?id=".$invoice['codeInvoice'], $message);

            $ccEmail = array("sales@y-note.cm","orange@y-note.cm");
            $email = $invoice['emailClient'];
            if($mailClient==0){
               $email = "orange@y-note.cm";
               $ccEmail = "sales@y-note.cm";
            }
            $params = array(
                "method" => "POST",
                "from" => "hosting@y-note.cm",
                "to" => $email,
                "subject" => "Paiement de votre Facture Y-Note :".$invoice['invoiceNumber'],
                "cc" => $ccEmail,
                "html" => $message
            );

            $result = $mj->sendEmail($params);
            if ($mj->_response_code == 200) {
            //    echo "success - email sent";
            } elseif ($mj->_response_code == 400) {
            //    echo "error - " . $mj->_response_code;
            } elseif ($mj->_response_code == 401) {
            //    echo "error - " . $mj->_response_code;
            } elseif ($mj->_response_code == 404) {
            //    echo "error - " . $mj->_response_code;
            } elseif ($mj->_response_code == 405) {
            //    echo "error - " . $mj->_response_code;
            }
    }


    public function saveInvoiceAction($nom,$invoice,$email,$tel,$sendMail,$montant){
        $this->config = parse_ini_file('../config.ini');
        $this->dbUrl=$this->config['dbUrl'];
        $this->dbUser=$this->config['dbUser'];
        $this->dbPassword=$this->config['dbPassword'];
        $this->dbBase=$this->config['dbBase'];
        $mysqli = new mysqli($this->dbUrl, $this->dbUser, $this->dbPassword, $this->dbBase);
        $telClient=$tel;

        $responseJson = [];
        if ($mysqli->connect_errno) {
            $responseJson["error"] = "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $sendMail=0;
        if($sendMail=="true"){
            $sendMail=1;
        }

        $nom = $mysqli->real_escape_string($nom);
        $invoice = $mysqli->real_escape_string($invoice);
        $email = $mysqli->real_escape_string($email);
        $tel = $mysqli->real_escape_string($tel);
        $montant = $mysqli->real_escape_string($montant);
        $sendMail = $mysqli->real_escape_string($sendMail);

        $codeInvoice = md5(uniqid(rand(), true));

        $request = "INSERT INTO Invoice (nomClient,telClient,invoiceNumber,emailClient,sendMail,montant,codeInvoice) VALUES ('".$nom."', '".$telClient."','".$invoice."', '".$email."','".$sendMail."','".$montant."','".$codeInvoice."');";

        if($mysqli->query($request)){
            $latest_id =  mysqli_insert_id($mysqli);
            //echo "Insert successful. Latest ID is: " . $latest_id;
            $request = "select * from Invoice where idInvoice=".$latest_id.";";
            $result=$mysqli->query($request);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                $responseJson["data"]=$row;
              }
            }

        }else{
            $responseJson["error"]="Error: <br>" . mysqli_error($mysqli);
        }

        $this->sendMailInvoice($sendMail,$responseJson["data"]);
        mysqli_close($mysqli);

        // Traitement QR Code
        QRcode::png('https://www.y-note.cm/facture/paie-facture.php?id='.$codeInvoice, './qrcode/'.$codeInvoice.'.png', QR_ECLEVEL_H,5);
        $responseJson["Qr"]='qrcode/'.$codeInvoice.'.png';
        echo json_encode($responseJson);
    }

    public function getInvoiceAction($invoiceCode){

        $mysqli = new mysqli($this->dbUrl, $this->dbUser, $this->dbPassword, $this->dbBase);
        if ($mysqli->connect_errno) {
            $response["error"] = "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $invoiceCode = $mysqli->real_escape_string($invoiceCode);
        
        $response = "";
        $request = "select * from Invoice where codeInvoice='".$invoiceCode."';";

        $result=$mysqli->query($request);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $response=$row;
          }
        }

        mysqli_close($mysqli);
        return $response;
    }


}