<?php

require_once("classeStripe.php");
//require_once("classeOM.php");
header('Content-Type: application/json');
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
$om = new Ynote_Stripe();
$om->payAction($decoded['invoiceNum'],$decoded['purchaseref'],$decoded['amount'],$decoded['Nom'],$decoded['emailFacture']);
