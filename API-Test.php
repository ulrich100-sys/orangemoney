<?php
// Merchant Key 90f20b45
define('OM_PROTOCOL', 'https');
define('OM_HOST', 'api.orange.com');
define('OM_CONTEXT_ACCESSTOKEN', 'oauth/v2/token');
define('OM_CONTEXT_REQUESTWP', 'orange-money-webpay/cm/v1/webpayment');
define('OM_URL_AT', OM_PROTOCOL . '://' . OM_HOST . '/' . OM_CONTEXT_ACCESSTOKEN);
define('OM_URL_WP', OM_PROTOCOL . '://' . OM_HOST . '/' . OM_CONTEXT_REQUESTWP);

class Ynote_Orangemoney_IndexController{

    protected $_responseUcollect = null;
    protected $_invoice = null;
    protected $_invoiceFlag = false;
    protected $_order = null;
    protected $_post = null;
    protected $_refNumber = null;
    public $access_token_response = "";

    public $authorizationHeader = "dkdhWWJEdHJGc21qUkdGRlYwZDVZY3JEOFJBZWlwbnA6N0NFWGV6YnpyTTBRYTlaTw==";
    public $merchant_key = "528ece9c";

    public function redirectAction(){

        $request_headers = array();
        $request_headers[] = 'Authorization: Basic '.$this->authorizationHeader;

        $this->_postAK = array(
            "grant_type" => "client_credentials"
        );

        $currency="XAF";
        /*if(Mage::getStoreConfig('payment/orangemoney/develop_mode')==0){
            $currency="CM";
        }*/

        $price = 10000;
        $this->_post= array(
          "merchant_key" => $this->merchant_key,
          "currency" => $currency,
          "order_id" => "123457",
          "amount" => $price,
          "return_url" => "http://www.y-note.cm/return",
          "cancel_url" => "http://www.y-note.cm/cancel",
          "notif_url" => "http://www.y-note.cm/notification",
          "lang" => "fr",
          "reference" => "Y-Note",
        );

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
        $returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $information = curl_getinfo($ch);
        curl_close($ch);

        $this->access_token_response=trim(str_replace("\"","",$access_token[1]));

        echo '<h1>----------Access Token------------</h1>';
        echo '<strong>ReturnCode:</strong> '. $returnCode.'<br/>';
        echo '<strong>Response:</strong> <br/>';
        var_dump($response);
        echo '<br/><strong>Access Token:</strong> '.$this->access_token_response.'<br/>';
        echo "<br/><strong> Request Header </strong>: <br/>";
        var_dump($information);
        echo '<br/>----------Access Token------------'.'<br/><br/>';
        

        $chpay = curl_init();

        $data_string = json_encode($this->_post);
        curl_setopt($chpay, CURLOPT_URL, OM_URL_WP);
        curl_setopt($chpay, CURLOPT_POST, true);
        curl_setopt($chpay, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($chpay, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($chpay, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($chpay, CURLINFO_HEADER_OUT, true);
        curl_setopt($chpay, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->access_token_response,
            'Accept: application/json'));
        curl_setopt($chpay, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($chpay);
        $response_decode=json_decode($response);
        $informationPay = curl_getinfo($chpay);

        if(isset($response_decode->code)){
            $returnCode = $response_decode->code;
        }else{
            $returnCode = $response_decode->status;
        }

        echo '<h1>----------Payment ------------</h1>';
        echo '<strong>Post :</strong>';
        var_dump($data_string);
        echo '<strong>ReturnCode:</strong> '. $returnCode.'<br/>';
        echo '<strong>Response:</strong> <br/>';
        var_dump($response_decode);
        echo "<br/><strong> Request Header </strong>: <br/>";
        var_dump($informationPay);
        echo '<br/>----------Access Token------------'.'<br/><br/>';


       
        //Check if there are no errors ie httpresponse == 200 -OK
        if ($returnCode == 201) {
            //This line declares the Link to pay for this transaction
            $paylink = $response_decode->payment_url;
            $notif_token = $response_decode->notif_token;
            echo 'Payment URL: '.$paylink;

            echo '<br/><strong>Redirection vers la <a href="'.$paylink.'">plateforme de paiement OrangeMoney </a></strong>';
            //return $paylink;
        } else {
            //Get return Error Code, If there was an error during call
            //
            switch($returnCode){
                default:
                    echo 'Payment Error : '.$returnCode.'<br/>';
                    echo 'Payment Message : '.$response_decode->message.'<br/>';
                    $result = 'HTTP ERROR -> ' . $returnCode.'<br/>';
                    $result.= 'Message : '.$response_decode->message.'<br/>';
                    break;
            }
            echo $result;

        }
    }

    public function ipnAction()
    {

        $helper = Mage::helper('orangemoney');
        $params = $this->getRequest()->getParams();

        $request = file_get_contents('php://input');
        $request = json_decode($request);
        

        $status = $request->status;
        $notif_token = $request->notif_token;
        $txnid = $request->txnid;
        $refNo = null;
        $messages = array();


/*        echo "<h1>IPN</h1>";
        var_dump($status);
        var_dump($notif_token);
*/
        
        Mage::log('----------IPN------------',null,'orangemoney-ipn.log');
        Mage::log('Status: '.$status,null,'orangemoney-ipn.log');
        Mage::log('Notif Token: '.$notif_token,null,'orangemoney-ipn.log');
        Mage::log('TXnid: '.$txnid,null,'orangemoney-ipn.log');
        Mage::log('Request: ',null,'orangemoney-ipn.log');
        Mage::log($params,null,'orangemoney-ipn.log');



        switch ($status) {
            case 'SUCCESS':
                // On fait une seconde vérification asynchrone pour être sur que quelqu'un a pas simplement renvoyé la bonne URL avec son numéro de commande...

                $notification = Mage::getModel('orangemoney/notification')
                        ->getCollection()
                        ->addFieldToFilter("id_notification",$notif_token);
                foreach($notification as $item){
                    $order = Mage::getModel('sales/order');
                    $this->_refNumber = $item->getIdOrder();
                    $order->loadByIncrementId($this->_refNumber);
                    $this->_order=$order;
                    Mage::log('Notification Token - IPN : '.$notif_token,null,'orangemoney-ipn.log');

                    $order->addStatusHistoryComment($this->__('Paiement valide par la plateforme OM.<br/> Reference Transaction:'.$notif_token))->save();
                    $this->getCheckoutSession()->getQuote()->setIsActive(false)->save();
                    // Set redirect URL
                    $response['redirect_url'] = 'checkout/onepage/success';

                    // Update payment
                    $this->_processOrderPayment($transactionId);

                    // Create invoice
                    if ($this->_invoiceFlag) {
                        $invoiceId = $this->_processInvoice();
                        $messages[] = $helper->__('Invoice #%s created', $invoiceId);
                    }

                    // Add messages to order history
                    foreach ($messages as $message) {
                    $this->_order->addStatusHistoryComment($message);
                    }

                    // Save order
                    $this->_order->save();

                    // Send order confirmation email
                    if (!$this->_order->getEmailSent() && $this->_order->getCanSendNewEmailFlag()) {
                        try {
                            if (method_exists($this->_order, 'queueNewOrderEmail')) {
                            $this->_order->queueNewOrderEmail();
                            } else {
                            $this->_order->sendNewOrderEmail();
                            }
                        } catch (Exception $e) {
                          Mage::logException($e);
                        }
                        }
                        // Send invoice email
                        if ($this->_invoiceFlag) {
                            try {
                                $this->_invoice->sendEmail();
                            } catch (Exception $e) {
                                Mage::logException($e);
                            }
                        }

                }

            break;
        default:
            // Log error
            $errorMessage = $this->__('Paiement non valide par OM :  %s.<br />Reference Transaction : %s', $status, $notif_token);
            // Add error on order message, cancel order and reorder
            if ($order->getId()) {
                if ($order->canCancel()) {
                    try {
                        $order->registerCancellation($errorMessage)->save();
                    } catch (Mage_Core_Exception $e) {
                        Mage::logException($e);
                    } catch (Exception $e) {
                        Mage::logException($e);
                        $errorMessage .= '<br/><br/>';
                        $errorMessage .= $this->__('The order has not been cancelled.'). ' : ' . $e->getMessage();
                        $order->addStatusHistoryComment($errorMessage)->save();
                    }
                } else {
                    $errorMessage .= '<br/><br/>';
                    $errorMessage .= $this->__('The order was already cancelled.');
                    $order->addStatusHistoryComment($errorMessage)->save();
                }

                // Refill cart
                Mage::helper('orangemoney')->reorder($refNo);

            }

            // Set redirect URL
        

        }
        $this->_redirect($response['redirect_url'], array('_secure' => true));
    }
}

$om = new Ynote_Orangemoney_IndexController();
$om->redirectAction();
