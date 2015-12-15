<?php
/*
* Copyright (c) 2011 Litle & Co.
*
* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:
*
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
*/

namespace litle\sdk\Test\functional;

use litle\sdk\LitleOnlineRequest;
use litle\sdk\XmlParser;

class XmlFieldsFunctionalTest extends \PHPUnit_Framework_TestCase
{
    public function test_card_no_type_or_track()
    {
        $hash_in = [
            'merchantId' => '101',
          'version'      => '8.8',
          'reportGroup'  => 'Planets',
          'litleTxnId'   => '123456',
          'orderId'      => '12344',
          'amount'       => '106',
          'orderSource'  => 'ecommerce',
          'card'         => [
          'number'            => '4100000000000000',
          'expDate'           => '1210',
          'cardValidationNum' => '123',
        ], ];

        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($hash_in);
        $message = XmlParser::getAttribute($saleResponse, 'litleOnlineResponse', 'message');
        $this->assertRegExp('/Error validating xml data against the schema/', $message);
    }

    public function test_simple_customBilling()
    {
        $hash_in = [
                'merchantId' => '101',
          'version'          => '8.8',
          'reportGroup'      => 'Planets',
          'litleTxnId'       => '123456',
          'orderId'          => '12344',
          'amount'           => '106',
          'orderSource'      => 'ecommerce',
          'customBilling'    => ['phone' => '123456789', 'descriptor' => 'good'],
          'card'             => [
          'type'    => 'VI',
          'number'  => '4100000000000000',
          'expDate' => '1210', ],
        ];

        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($hash_in);
        $message = XmlParser::getAttribute($saleResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_simple_auth_with_litleTxnId()
    {
        $hash_in = ['merchantId' => '101',
          'version'              => '8.8',
          'reportGroup'          => 'Planets',
          'litleTxnId'           => '123456',
          'orderId'              => '12344',
          'amount'               => '106',
          'orderSource'          => 'ecommerce',
          'billMeLaterRequest'   => ['bmlMerchantId' => '12345', 'preapprovalNumber' => '12345678909023',
          'customerPhoneChnaged'                     => 'False', 'itemCategoryCode' => '2', ],
          'card' => [
          'type'    => 'VI',
          'number'  => '4100000000000000',
          'expDate' => '1210',
        ], ];

        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($hash_in);
        $response = XmlParser::getAttribute($saleResponse, 'litleOnlineResponse', 'response');
        $this->assertEquals('000', $response);
    }

    public function test_customerInfo()
    {
        $hash_in = ['merchantId' => '101',
          'version'              => '8.8',
          'reportGroup'          => 'Planets',
          'litleTxnId'           => '123456',
          'orderId'              => '12344',
          'amount'               => '106',
          'orderSource'          => 'ecommerce',
          'CustomerInfo'         => ['ssn' => '12345', 'incomeAmount' => '12345', 'incomeCurrency' => 'dollar', 'yearsAtResidence' => '2'],
          'card'                 => [
          'type'    => 'VI',
          'number'  => '4100000000000000',
          'expDate' => '1210',
        ], ];

        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($hash_in);
        $message = XmlParser::getAttribute($saleResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_simple_billtoAddress()
    {
        $hash_in = ['merchantId' => '101',
      'version'                  => '8.8',
      'reportGroup'              => 'Planets',
      'orderId'                  => '12344',
      'amount'                   => '106',
      'orderSource'              => 'ecommerce',
      'billToAddress'            => ['name' => 'Bob', 'city' => 'lowell', 'state' => 'MA', 'email' => 'litle.com'],
      'card'                     => [
      'type'    => 'VI',
      'number'  => '4100000000000000',
      'expDate' => '1210', ], ];

        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($hash_in);
        $message = XmlParser::getAttribute($authorizationResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_processingInstructions()
    {
        $hash_in = ['merchantId' => '101',
      'version'                  => '8.8',
      'reportGroup'              => 'Planets',
      'orderId'                  => '12344',
      'amount'                   => '106',
      'orderSource'              => 'ecommerce',
      'processingInstructions'   => ['bypassVelocityCheck' => 'true'],
      'card'                     => [
      'type'    => 'VI',
      'number'  => '4100000000000000',
      'expDate' => '1210', ], ];

        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($hash_in);
        $message = XmlParser::getAttribute($authorizationResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_pos()
    {
        $hash_in = ['merchantId' => '101',
      'version'                  => '8.8',
      'reportGroup'              => 'Planets',
      'orderId'                  => '12344',
      'amount'                   => '106',
      'orderSource'              => 'ecommerce',
      'pos'                      => ['capability' => 'notused', 'entryMode' => 'track1', 'cardholderId' => 'pin'],
      'card'                     => [
      'type'    => 'VI',
      'number'  => '4100000000000000',
      'expDate' => '1210', ], ];

        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($hash_in);
        $message = XmlParser::getAttribute($authorizationResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_pos_with_invalid_entryMode()
    {
        $hash_in = [
            'merchantId' => '101',
      'version'          => '8.8',
      'reportGroup'      => 'Planets',
      'orderId'          => '12344',
      'amount'           => '106',
      'orderSource'      => 'ecommerce',
      'pos'              => ['entryMode' => 'none', 'cardholderId' => 'pin', 'capability' => 'notused'],
      'card'             => [
      'type'    => 'VI',
      'number'  => '4100000000000000',
      'expDate' => '1210', ], ];

        $initilaize = new LitleOnlineRequest();
        $saleResponse = $initilaize->saleRequest($hash_in);
        $message = XmlParser::getAttribute($saleResponse, 'litleOnlineResponse', 'message');
        $this->assertRegExp('/Error validating xml data against the schema/', $message);
    }

    public function test_amexAggregatorData()
    {
        $hash_in = ['merchantId' => '101',
      'version'                  => '8.8',
      'reportGroup'              => 'Planets',
      'orderId'                  => '12344',
      'amount'                   => '106',
      'card'                     => [
      'type'    => 'VI',
      'number'  => '4100000000000000',
      'expDate' => '1210', ],
      'orderSource'        => 'ecommerce',
      'amexAggregatorData' => ['sellerMerchantCategoryCode' => '1234', 'sellerId' => '1234Id'], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_amexAggregatorData_missing_sellerId()
    {
        $hash_in = [
                  'merchantId' => '101',
          'version'            => '8.8',
          'reportGroup'        => 'Planets',
          'orderId'            => '12344',
          'amount'             => '106',
          'orderSource'        => 'ecommerce',
          'card'               => [
          'type'    => 'VI',
          'number'  => '4100000000000000',
          'expDate' => '1210', ],
          'amexAggregatorData' => ['sellerMerchantCategoryCode' => '1234'], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertRegExp('/Error validating xml data against the schema/', $message);
    }

    public function test_simple_enhancedData()
    {
        $hash_in = ['merchantId' => '101',
      'version'                  => '8.8',
      'reportGroup'              => 'Planets',
      'orderId'                  => '12344',
      'amount'                   => '106',
      'card'                     => [
      'type'    => 'VI',
      'number'  => '4100000000000000',
      'expDate' => '1210', ],
      'orderSource'  => 'ecommerce',
      'enhancedData' => [
      'customerReference'     => 'Litle',
      'salesTax'              => '50',
      'deliveryType'          => 'TBD',
      'restriction'           => 'DIG',
      'shipFromPostalCode'    => '01741',
      'destinationPostalCode' => '01742', ], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_simple_enhancedData_incorrect_enum_for_countryCode()
    {
        $hash_in = [
                      'merchantId' => '101',
          'version'                => '8.8',
          'reportGroup'            => 'Planets',
          'orderId'                => '12344',
          'amount'                 => '106',
          'card'                   => [
          'type'    => 'VI',
          'number'  => '4100000000000000',
          'expDate' => '1210', ],
          'orderSource'  => 'ecommerce',
          'enhancedData' => [
          'destinationCountryCode' => '001',
          'customerReference'      => 'Litle',
          'salesTax'               => '50',
          'deliveryType'           => 'TBD',
          'shipFromPostalCode'     => '01741',
          'destinationPostalCode'  => '01742', ], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertRegExp('/Error validating xml data against the schema/', $message);
    }

    public function test_enhancedData_with_detailtax()
    {
        $hash_in = ['merchantId' => '101',
          'version'              => '8.8',
          'reportGroup'          => 'Planets',
          'orderId'              => '12344',
          'amount'               => '106',
          'card'                 => [
          'type'    => 'VI',
          'number'  => '4100000000000000',
          'expDate' => '1210', ],
          'orderSource'  => 'ecommerce',
          'enhancedData' => [
          'detailtax'             => ['taxAmount' => '1234', 'tax' => '50'],
          'customerReference'     => 'Litle',
          'salesTax'              => '50',
          'deliveryType'          => 'TBD',
          'restriction'           => 'DIG',
          'shipFromPostalCode'    => '01741',
          'destinationPostalCode' => '01742', ], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_enhancedData_with_lineItem()
    {
        $hash_in = ['merchantId' => '101',
          'version'              => '8.8',
          'reportGroup'          => 'LINEITEM',
          'orderId'              => '12344',
          'amount'               => '106',
          'card'                 => [
          'type'    => 'VI',
          'number'  => '4100000000000000',
          'expDate' => '1210', ],
          'processingInstructions' => ['bypassVelocityCheck' => 'true'],
          'orderSource'            => 'ecommerce',
          'lineItemData'           => [
          'itemSequenceNumber' => '98765',
          'itemDescription'    => 'VERYnice',
          'productCode'        => '10010100',
          'quantity'           => '7',
          'unitOfMeasure'      => 'pounds',
          'enhancedData'       => [
          'detailtax' => ['taxAmount' => '1234', 'tax' => '50'], ],
          'customerReference'     => 'Litle',
          'salesTax'              => '50',
          'deliveryType'          => 'TBD',
          'restriction'           => 'DIG',
          'shipFromPostalCode'    => '01741',
          'destinationPostalCode' => '01742', ], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_simple_token()
    {
        $hash_in = ['merchantId' => '101',
      'version'                  => '8.8',
      'reportGroup'              => 'Planets',
      'orderId'                  => '12344',
      'amount'                   => '106',
      'orderSource'              => 'ecommerce',
      'token'                    => [
      'litleToken'        => '123456789101112',
      'expDate'           => '1210',
      'cardValidationNum' => '555',
      'type'              => 'VI', ], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_token_with_incorrect_token_length()
    {
        $hash_in = ['merchantId' => '101',
      'version'                  => '8.8',
      'reportGroup'              => 'Planets',
      'orderId'                  => '12344',
      'amount'                   => '106',
      'orderSource'              => 'ecommerce',
      'token'                    => [
      'litleToken'        => '123456',
      'expDate'           => '1210',
      'cardValidationNum' => '555',
      'type'              => 'VI', ], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertRegExp('/Error validating xml data against the schema/', $message);
    }

    public function test_token_missing_expDat_and_validationNum()
    {
        $hash_in = ['merchantId' => '101',
      'version'                  => '8.8',
      'reportGroup'              => 'Planets',
      'orderId'                  => '12344',
      'amount'                   => '106',
      'orderSource'              => 'ecommerce',
      'token'                    => [
      'litleToken' => '123456789101112',
      'type'       => 'VI', ], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_simple_paypage()
    {
        $hash_in = ['merchantId' => '101',
      'version'                  => '8.8',
      'reportGroup'              => 'Planets',
      'orderId'                  => '12344',
      'amount'                   => '106',
      'orderSource'              => 'ecommerce',
      'paypage'                  => [
      'paypageRegistrationId' => '123456789101112',
      'expDate'               => '1210',
      'cardValidationNum'     => '555',
      'type'                  => 'VI', ], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }

    public function test_paypage_missing_expDate_and_validationNum()
    {
        $hash_in = ['merchantId' => '101',
          'version'              => '8.8',
          'reportGroup'          => 'Planets',
          'orderId'              => '12344',
          'amount'               => '106',
          'orderSource'          => 'ecommerce',
          'paypage'              => [
          'paypageRegistrationId' => '123456789101112',
          'type'                  => 'VI', ], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertEquals('Valid Format', $message);
    }
}
