<?php

include("php-mailjet-v3-simple.class.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once("classeYup-Sandbox.php");
error_reporting(E_ALL);

session_start();
$request = $_GET;

$purchaseref = $request['purchaseref'];
$amount = $request['amount'];
$currency = $request['currency'];
$status = $request['status'];
$clientid = $request['clientid'];
$cname = $request['cname'];
$mobile = $request['mobile'];
$paymentref = $request['paymentref'];
$payid = $request['payid'];
$timestamp = $request['timestamp'];
$ipaddr = $request['ipaddr'];
$error = $request['error'];



$refNo = null;
$messages = array();


$myfile = fopen("paiement-log-YUP-Nofif.txt", "a+");
fwrite($myfile, '----------------- ------------------- ----------------'."\n");
fwrite($myfile, 'purchaseref: '.$purchaseref."\n");
fwrite($myfile, 'amount: '.$amount."\n");
fwrite($myfile, 'currency: '.$currency."\n");
fwrite($myfile, 'status: '.$status."\n");
fwrite($myfile, 'clientid: '.$clientid."\n");
fwrite($myfile, 'cname: '.$cname."\n");
fwrite($myfile, 'mobile: '.$mobile."\n");
fwrite($myfile, 'purchaseref: '.$purchaseref."\n");
fwrite($myfile, 'paymentref: '.$paymentref."\n");
fwrite($myfile, 'payid: '.$payid."\n");
fwrite($myfile, 'timestamp: '.$timestamp."\n");
fwrite($myfile, 'ipaddr: '.$ipaddr."\n");
fwrite($myfile, 'error: '.$error."\n");
fclose($myfile);


switch ($status) {
    case 'OK':
            $myfileOK = fopen("paiement-log-Yup-Nofif-OK.txt", "a+");
            fwrite($myfileOK, 'Status: '.$status."\n");
            fwrite($myfileOK, 'Amount: '.$amount."\n");
            fwrite($myfileOK, 'currency: '.$currency."\n");
            fwrite($myfileOK, 'clientid: '.$clientid."\n");
            fwrite($myfileOK, 'cname: '.$cname."\n");
            fwrite($myfileOK, 'mobile: '.$mobile."\n");
            fwrite($myfileOK, 'purchaseref: '.$purchaseref."\n");
            fwrite($myfileOK, 'paymentref: '.$paymentref."\n");
            fwrite($myfileOK, 'payid: '.$payid."\n");
            fwrite($myfileOK, 'timestamp: '.$timestamp."\n");
            fwrite($myfileOK, 'ipaddr: '.$ipaddr."\n");
            fwrite($myfileOK, 'error: '.$error."\n");
            fwrite($myfileOK, '----------------- ------------------- ----------------'."\n");
            fclose($myfileOK);
            $msg = "Paiement consultation par YUP ";
            $msg .= ' Status: '.$status."\n";
            $msg .= ' amount: '.$amount."\n";
            $msg .= ' status: '.$status."\n";           
            $msg .= ' clientid: '.$clientid."\n";           
            $msg .= ' cname: '.$cname."\n";           
            $msg .= ' mobile: '.$mobile."\n";         
            $msg .= ' purchaseref: '.$purchaseref."\n";              
            $msg .= ' paymentref: '.$paymentref."\n";           
            $msg .= ' payid: '.$payid."\n";           
            $msg .= ' timestamp: '.$timestamp."\n";           
            $msg .= ' ipaddr: '.$ipaddr."\n";           
            $msg .= ' error: '.$error."\n";           


            // send email
            mail("m.ngoe@y-note.cm","Encaissement YUP Broadband",$msg);
    break;
default:
    echo "none";
break;
}

$yup = new Ynote_Yup();
$yup->confirmPaymentAction($amount,$status,$purchaseref,$error);
