<?php

namespace litle\sdk;

require_once realpath(__DIR__).'/../../vendor/autoload.php';
#PHP SDK Auth with PayPage Registration ID
#Authorization
$auth_info = [
    'orderId'       => '1',
    'amount'        => '10010',
    'id'            => '456',
    'orderSource'   => 'ecommerce',
    'billToAddress' => [
        'name'         => 'John Smith',
        'addressLine1' => '1 Main St.',
        'city'         => 'Burlington',
        'state'        => 'MA',
        'zip'          => '01803-3747',
        'country'      => 'US',
    ],
    'paypage' => [
        'paypageRegistrationId' => '4457010000000009',
        'expDate'               => '0112',
        'cardValidationNum'     => '349',
    ],
];

$initilaize = new LitleOnlineRequest();
$authResponse = $initilaize->authorizationRequest($auth_info);

echo 'Message: '.XmlParser::getNode($authResponse, 'message');

if (XmlParser::getNode($authResponse, 'message') != 'Partially Approved') {
    throw new \Exception('AuthWithPaypageReID does not get the right response');
}
