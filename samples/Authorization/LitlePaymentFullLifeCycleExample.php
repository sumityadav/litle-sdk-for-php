<?php

namespace litle\sdk;

require_once realpath(__DIR__).'/../../vendor/autoload.php';

#Authorization
#Puts a hold on the fund
$auth_info = [
                      'id'    => '456',
                  'orderId'   => '1',
              'amount'        => '10010',
              'orderSource'   => 'ecommerce',
              'billToAddress' => [
              'name'         => 'John Smith',
              'addressLine1' => '1 Main St.',
              'city'         => 'Burlington',
              'state'        => 'MA',
              'zip'          => '01803-3747',
              'country'      => 'US', ],
              'card' => [
              'number'            => '4457010000000009',
              'expDate'           => '0112',
              'cardValidationNum' => '349',
              'type'              => 'VI', ],
            ];

$initilaize = &new LitleOnlineRequest();
$authResponse = $initilaize->authorizationRequest($auth_info);

if (XmlParser::getNode($authResponse, 'message') != 'Approved') {
    throw new \Exception('LitlePaymentFullLifeCycleExample authResponse does not get the right response');
}
#Capture
#Captures the authorization and results in money movement
$capture_hash = ['litleTxnId' => (XmlParser::getNode($authResponse, 'litleTxnId')), 'id' => '456'];
$initilaize = &new LitleOnlineRequest();
$captureResponse = $initilaize->captureRequest($capture_hash);

if (XmlParser::getNode($captureResponse, 'message') != 'Approved') {
    throw new \Exception('LitlePaymentFullLifeCycleExample captureResponse does not get the right response');
}
#Credit
#Refund the customer
$credit_hash = ['litleTxnId' => (XmlParser::getNode($captureResponse, 'litleTxnId')), 'id' => '456'];
$initilaize = &new LitleOnlineRequest();
$creditResponse = $initilaize->creditRequest($credit_hash);

if (XmlParser::getNode($creditResponse, 'message') != 'Approved') {
    throw new \Exception('LitlePaymentFullLifeCycleExample creditResponse does not get the right response');
}
#Void
#Cancel the refund, note that a deposit can be Voided as well
$void_hash = ['litleTxnId' => (XmlParser::getNode($creditResponse, 'litleTxnId')), 'id' => '456'];
$initilaize = &new LitleOnlineRequest();
$voidResponse = $initilaize->voidRequest($void_hash);

if (XmlParser::getNode($voidResponse, 'message') != 'Approved') {
    throw new \Exception('LitlePaymentFullLifeCycleExample voidResponse does not get the right response');
}
