<?php

require_once("../classeInvoice.php");
header('Content-Type: application/json');
$invoice = new Ynote_Invoice();
$invoice->saveInvoiceAction($_POST['nom'],$_POST['invoice'],$_POST['email'],$_POST['tel'],$_POST['mail'],$_POST['amount']); 
