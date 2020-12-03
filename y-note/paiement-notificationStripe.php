<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./lib/stripe-php-7.61.0/init.php');
session_start();
$payload = @file_get_contents('php://input');
$request = json_decode($request);


// Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
 $this->config = parse_ini_file('./stripe-config.ini');
\Stripe\Stripe::setApiKey($this->config['stripe_secret_key']);  

$event = null;

try {
    $event = \Stripe\Event::constructFrom(
        json_decode($payload, true)
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
}

// Handle the event
switch ($event->type) {
    case 'payment_intent.succeeded':
        $paymentIntent = $event->data->object; // contains a StripePaymentIntent
                
        $status = $request->status;
        $notif_token = $request->notif_token;
        $txnid = $request->txnid;
        $refNo = null;
        $messages = array();


        $myfile = fopen("paiement-log-Stripe-Nofif.txt", "a+");
        fwrite($myfile, '----------------- ------------------- ----------------'."\n");
        fwrite($myfile, 'Status: '.$status."\n");
        fwrite($myfile, 'Notif Token: '.$notif_token."\n");
        fwrite($myfile, 'TXnid: '.$txnid."\n");
        fclose($myfile);
        break;
    case 'payment_method.attached':
        $paymentMethod = $event->data->object; // contains a StripePaymentMethod
        handlePaymentMethodAttached($paymentMethod);
        break;
    // ... handle other event types
    default:
        echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);