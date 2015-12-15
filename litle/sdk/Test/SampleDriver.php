<?php

namespace litle\sdk;

require_once realpath(__DIR__).'/../../../vendor/autoload.php';
#Sale
$sale_info = [
              'orderId'       => '1',
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
              'number'            => '5112010000000003',
              'expDate'           => '0112',
              'cardValidationNum' => '349',
              'type'              => 'MC', ],
            ];
$initilaize = &new LitleOnlineRequest();
$saleResponse = $initilaize->saleRequest($sale_info);
#display results
echo 'Response: '.(XmlParser::getNode($saleResponse, 'response')).'<br>';
echo 'Message: '.XmlParser::getNode($saleResponse, 'message').'<br>';
echo 'Litle Transaction ID: '.XmlParser::getNode($saleResponse, 'litleTxnId');
echo 'All Response :'.XmlParser::getAttribute($saleResponse, 'litleOnlineResponse', 'version');
