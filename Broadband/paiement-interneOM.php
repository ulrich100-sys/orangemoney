<?php

require_once("classeOM-Sandbox.php");
//require_once("classeOM.php");
header('Content-Type: application/json');
$om = new Ynote_Orangemoney();
$om->payAction($_POST['Nom'],$_POST['NumberInvoice'],$_POST['Tel'],$_POST['amount']);