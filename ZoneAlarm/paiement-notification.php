<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$request = file_get_contents('php://input');
$request = json_decode($request);

$status = $request->status;
$notif_token = $request->notif_token;
$txnid = $request->txnid;
$refNo = null;
$messages = array();


$myfile = fopen("paiement-log-OM-Nofif.txt", "a+");
fwrite($myfile, '----------------- ------------------- ----------------'."\n");
fwrite($myfile, 'Status: '.$status."\n");
fwrite($myfile, 'Notif Token: '.$notif_token."\n");
fwrite($myfile, 'TXnid: '.$txnid."\n");
fclose($myfile);


switch ($status) {
    case 'SUCCESS':
            $myfileOK = fopen("paiement-log-OM-Nofif-OK.txt", "a+");
            fwrite($myfileOK, 'Status: '.$status."\n");
            fwrite($myfileOK, 'Notif Token: '.$notif_token."\n");
            fwrite($myfileOK, 'TXnid: '.$txnid."\n");  
            fclose($myfileOK);
            $msg = "Paiement consultation par OM ";
            $msg .= ' Status: '.$status."\n";
            $msg .= ' Notif Token: '.$notif_token."\n";
            $msg .= ' TXnid: '.$txnid."\n";           

            // send email
            mail("m.ngoe@y-note.cm","Encaissement Orange Money iDocta",$msg);
    break;
default:
    echo "none";
break;
}