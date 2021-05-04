<?php

define('OM_PROTOCOL', 'https');
define('OM_HOST', 'api.orange.com');
define('OM_CONTEXT_ACCESSTOKEN', 'oauth/v2/token');
define('OM_CONTEXT_REQUESTWP', 'orange-money-webpay/cm/v1/webpayment');
define('OM_URL_AT', OM_PROTOCOL . '://' . OM_HOST . '/' . OM_CONTEXT_ACCESSTOKEN);
define('OM_URL_WP', OM_PROTOCOL . '://' . OM_HOST . '/' . OM_CONTEXT_REQUESTWP);

$request_headers = array();
$request_headers[] = 'Authorization: Basic '.$this->authorizationHeader;

/*** Construction de la première requête de gestion des Access Token */
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, OM_URL_AT);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS,  "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_HTTPHEADER,  $request_headers);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$response = explode(',',$response);
$access_token = explode(':',$response[1]);