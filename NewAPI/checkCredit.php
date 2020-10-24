<?php
header('Content-Type: application/json');
session_start();
$numOrange = 693600164;
require_once("classeOM.php");
$om = new Ynote_Orangemoney();
if(!isset($_SESSION["CreditDispo"])){
	$_SESSION["CreditDispo"]=1000000;
}


$checkPay = "Le solde du compte du payeur est insuffisant";
//while($checkPay=="Le solde du compte du payeur est insuffisant"){
$returnPay = $om->payAction($numOrange,$_SESSION["CreditDispo"]);
$myfile = fopen("checkCredit-OM-".$numOrange.".txt", "a+");
fwrite($myfile, '--- Check Montant : '.$_SESSION["CreditDispo"].'  -- Resultat : '.$returnPay["inittxnmessage"]."\n");
fclose($myfile);

$_SESSION["CreditDispo"] = $_SESSION["CreditDispo"]-10;
$checkPay = $returnPay["inittxnmessage"];
$arrayPay["txt"] = $checkPay;
$arrayPay["montant"] = $_SESSION["CreditDispo"];
echo json_encode($arrayPay);

//}
