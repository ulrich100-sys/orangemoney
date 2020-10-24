<?php

//require_once("classeOM-Sandbox.php");
require_once("classeOM.php");
header('Content-Type: application/json');
$om = new Ynote_Orangemoney();
$om->payAction($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['tel']);
