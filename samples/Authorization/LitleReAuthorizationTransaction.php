<?php

namespace litle\sdk;

require_once realpath(__DIR__).'/../../vendor/autoload.php';

#Re authorization using the litleTxnId of a previous auth

$auth_info = [
        'litleTxnId' => '1234567891234567891',
        'id'         => '456',
    ];

$initilaize = &new LitleOnlineRequest();
$authResponse = $initilaize->authorizationRequest($auth_info);

#display results
echo 'Response: '.(XmlParser::getNode($authResponse, 'response')).'<br>';
echo 'Message: '.XmlParser::getNode($authResponse, 'message').'<br>';
echo 'Litle Transaction ID: '.XmlParser::getNode($authResponse, 'litleTxnId');

if (XmlParser::getNode($authResponse, 'message') != 'Approved') {
    throw new \Exception('LitleReAuthorizationTransaction does not get the right response');
}
