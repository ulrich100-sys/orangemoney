<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("php-mailjet-v3-simple.class.php");
//require_once("classeOM-Sandbox.php");
require_once("classeOM.php");
$om = new Ynote_Orangemoney();
$mysqli = new mysqli($om->dbUrl, $om->dbUser, $om->dbPassword, $om->dbBase);
$request = "select * from Orders where method='OrangeMoney' and status!='FAILED' and status!='EXPIRED' and status!='SUCCESSFULL';";
$result=$mysqli->query($request);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["idOrders"]. " - paytoken: " . $row["payToken"]. " " . $row["status"]. "<br>";
    $resultPaycheck=$om->paycheck($row["payToken"]);
    if($row["status"]!=$resultPaycheck){ 

        if($resultPaycheck=="SUCCESSFULL"){
            $requestGetLicense = "select * from Invoice where codeInvoice='".$row["numberInvoice"]."' limit 0,1";
            $requestGetLicense = $mysqli->query($requestGetLicense);
            while($rowLicense = $requestGetLicense->fetch_assoc()) {
                echo "id: " . $rowLicense["idInvoice"]. " - invoiceNumber: " . $rowLicense["invoiceNumber"]. " " . $rowLicense["emailClient"]. "<br>";
                echo "Envoi du mail client <br/>";

                function sendEmail($invoice) {
                    $apiKey = 'f6eec11df75c2197debc2f059a267ed1';
                    $secretKey = '553fa701c2e95f56e1f34775c099557b';

                    // Create a new Object
                    $mj = new Mailjet($apiKey, $secretKey);

                    $message = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR .'email/SolidPurple/index-confirm.html'); 
                    $message=str_replace('{{userName}}', $invoice['nomClient'], $message);
                    $message=str_replace('{{invoiceNumber}}', $invoice['invoiceNumber'], $message);
                    $message=str_replace('{{montant}}', number_format ($invoice['montant'], 0, ',', ' '), $message);
                    $message=str_replace('{{methodPaiement}}', "Orange Money", $message);
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

                sendEmail($rowLicense);

                $requestUpdateLicense = "update Invoice set idOrder='".$row["idOrders"]."' where idInvoice='".$rowLicense["idInvoice"]."';";
                var_dump($requestUpdateLicense);
                $resultLicense=$mysqli->query($requestUpdateLicense);
            }
        }

        $requestUpdate = "update Orders set status='".$resultPaycheck."' where idOrders='".$row["idOrders"]."';";
        $resultUpdate=$mysqli->query($requestUpdate);

        $myfile = fopen("paiement-log-OM-Nofif.txt", "a+");
        fwrite($myfile, '----------------- ------------------- ----------------'."\n");
        fwrite($myfile, 'Status: '.$row["idOrders"]."\n");
        fwrite($myfile, 'Notif Token: '.$row["payToken"]."\n");
        fclose($myfile);


    }

  }
} else {
    echo "Aucun resultats a traiter";
}
$mysqli->close();