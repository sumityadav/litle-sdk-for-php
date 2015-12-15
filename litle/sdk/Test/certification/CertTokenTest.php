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

namespace litle\sdk\Test\certification;

use litle\sdk\LitleOnlineRequest;
use litle\sdk\XmlParser;

class CertTokenTest extends \PHPUnit_Framework_TestCase
{
    public function test_50()
    {
        $token_hash = [
        'orderId'         => '50',
          'accountNumber' => '4457119922390123', ];

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->registerTokenRequest($token_hash);
        $this->assertEquals('445711', XMLParser::getNode($registerTokenResponse, 'bin'));
        $this->assertEquals('VI', XMLParser::getNode($registerTokenResponse, 'type'));
        $this->assertEquals('801', XMLParser::getNode($registerTokenResponse, 'response'));
        $this->assertEquals('1111222233330123', XMLParser::getNode($registerTokenResponse, 'litleToken'));
        $this->assertEquals('Account number was successfully registered', XMLParser::getNode($registerTokenResponse, 'message'));
    }

    public function test_51()
    {
        $token_hash = [
            'orderId'         => '51',
              'accountNumber' => '4457119999999999', ];

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->registerTokenRequest($token_hash);
        $this->assertEquals('820', XMLParser::getNode($registerTokenResponse, 'response'));
        $this->assertEquals('Credit card number was invalid', XMLParser::getNode($registerTokenResponse, 'message'));
    }

    public function test_52()
    {
        $token_hash = [
            'orderId'         => '52',
              'accountNumber' => '4457119922390123', ];

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->registerTokenRequest($token_hash);
        $this->assertEquals('445711', XMLParser::getNode($registerTokenResponse, 'bin'));
        $this->assertEquals('VI', XMLParser::getNode($registerTokenResponse, 'type'));
        $this->assertEquals('802', XMLParser::getNode($registerTokenResponse, 'response'));
        $this->assertEquals('1111222233330123', XMLParser::getNode($registerTokenResponse, 'litleToken'));
        $this->assertEquals('Account number was previously registered', XMLParser::getNode($registerTokenResponse, 'message'));
    }

    public function test_53() #merchant is not authorized for echeck tokens
    {
        $token_hash = [
                'orderId'          => '53',
                  'echeckForToken' => ['accNum' => '1099999998', 'routingNum' => '114567895'], ];

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->registerTokenRequest($token_hash);
        $this->assertEquals('EC', XMLParser::getNode($registerTokenResponse, 'type'));
        $this->assertEquals('998', XMLParser::getNode($registerTokenResponse, 'eCheckAccountSuffix'));
        $this->assertEquals('801', XMLParser::getNode($registerTokenResponse, 'response'));
        $this->assertEquals('111922223333000998', XMLParser::getNode($registerTokenResponse, 'litleToken'));
        $this->assertEquals('Account number was successfully registered', XMLParser::getNode($registerTokenResponse, 'message'));
    }

    public function test_54() #merchant is not authorized for echeck tokens
    {
        $token_hash = [
                'orderId'          => '54',
                  'echeckForToken' => ['accNum' => '1022222102', 'routingNum' => '1145_7895'], ];

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->registerTokenRequest($token_hash);
        $this->assertEquals('900', XMLParser::getNode($registerTokenResponse, 'response'));
        $this->assertEquals('Invalid bank routing number', XMLParser::getNode($registerTokenResponse, 'message'));
    }

    public function test_55()
    {
        $token_hash = [
                    'orderId' => '55',
          'amount'            => '15000',
          'orderSource'       => 'ecommerce',
          'card'              => ['number' => '5435101234510196', 'expDate' => '1112', 'cardValidationNum' => '987', 'type' => 'MC'], ];

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->authorizationRequest($token_hash);
        $this->assertEquals('MC', XMLParser::getNode($registerTokenResponse, 'type'));
        $this->assertEquals('801', XMLParser::getNode($registerTokenResponse, 'tokenResponseCode'));
        $this->assertEquals('000', XMLParser::getNode($registerTokenResponse, 'response'));
        $this->assertEquals('Account number was successfully registered', XMLParser::getNode($registerTokenResponse, 'tokenMessage'));
        $this->assertEquals('Approved', XMLParser::getNode($registerTokenResponse, 'message'));
        $this->assertEquals('543510', XMLParser::getNode($registerTokenResponse, 'bin'));
    }

    public function test_56()
    {
        $token_hash = [
                    'orderId' => '56',
      'amount'                => '15000',
      'orderSource'           => 'ecommerce',
      'card'                  => ['number' => '5435109999999999', 'expDate' => '1112', 'cardValidationNum' => '987', 'type' => 'MC'], ];

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->authorizationRequest($token_hash);
        $this->assertEquals('301', XMLParser::getNode($registerTokenResponse, 'response'));
        $this->assertEquals('Invalid account number', XMLParser::getNode($registerTokenResponse, 'message'));
    }

    public function test_57()
    {
        $token_hash = [
                        'orderId' => '57',
          'amount'                => '15000',
          'orderSource'           => 'ecommerce',
          'card'                  => ['number' => '5435101234510196', 'expDate' => '1112', 'cardValidationNum' => '987', 'type' => 'MC'], ];

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->authorizationRequest($token_hash);
        $this->assertEquals('MC', XMLParser::getNode($registerTokenResponse, 'type'));
        $this->assertEquals('802', XMLParser::getNode($registerTokenResponse, 'tokenResponseCode'));
        $this->assertEquals('000', XMLParser::getNode($registerTokenResponse, 'response'));
        $this->assertEquals('Account number was previously registered', XMLParser::getNode($registerTokenResponse, 'tokenMessage'));
        $this->assertEquals('Approved', XMLParser::getNode($registerTokenResponse, 'message'));
        $this->assertEquals('543510', XMLParser::getNode($registerTokenResponse, 'bin'));
    }

    public function test_59()
    {
        $token_hash = [
                        'orderId' => '59',
          'amount'                => '15000',
          'orderSource'           => 'ecommerce',
          'token'                 => ['litleToken' => '1712990000040196', 'expDate' => '1112'], ];

        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($token_hash);
        $this->assertEquals('822', XMLParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Token was not found', XMLParser::getNode($authorizationResponse, 'message'));
    }

    public function test_60()
    {
        $token_hash = [
                            'orderId' => '60',
              'amount'                => '15000',
              'orderSource'           => 'ecommerce',
              'token'                 => ['litleToken' => '1712999999999999', 'expDate' => '1112'], ];

        $initilaize = new LitleOnlineRequest();
        $authorizationResponse = $initilaize->authorizationRequest($token_hash);
        $this->assertEquals('823', XMLParser::getNode($authorizationResponse, 'response'));
        $this->assertEquals('Token was invalid', XMLParser::getNode($authorizationResponse, 'message'));
    }

    # test 61-64 need echecksale to support token. merchantid not authoried.

        public function test_61()
        {
            $token_hash = [
                    'orderId' => '61',
          'amount'            => '15000',
          'orderSource'       => 'ecommerce',
          'billToAddress'     => [
          'firstName' => 'Tom',
          'lastName'  => 'Black', ],
          'echeck' => ['accType' => 'Checking', 'accNum' => '1099999003', 'routingNum' => '114567895'], ];

            $initilaize = new LitleOnlineRequest();
            $registerTokenResponse = $initilaize->echeckSaleRequest($token_hash);
            $this->assertEquals('801', XMLParser::getNode($registerTokenResponse, 'tokenResponseCode'));
            $this->assertEquals('Account number was successfully registered', XMLParser::getNode($registerTokenResponse, 'tokenMessage'));
            $this->assertEquals('EC', XMLParser::getNode($registerTokenResponse, 'type'));
            $this->assertEquals('003', XMLParser::getNode($registerTokenResponse, 'eCheckAccountSuffix'));
            $this->assertEquals('111922223333444003', XMLParser::getNode($registerTokenResponse, 'litleToken'));
        }

    public function test_62()
    {
        $token_hash = [
                            'orderId' => '62',
                  'amount'            => '15000',
                  'orderSource'       => 'ecommerce',
                  'billToAddress'     => [
                  'firstName' => 'Tom',
                  'lastName'  => 'Black', ],
                  'echeck' => ['accType' => 'Checking', 'accNum' => '1099999999', 'routingNum' => '114567895'], ];

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->echeckSaleRequest($token_hash);
        $this->assertEquals('801', XMLParser::getNode($registerTokenResponse, 'tokenResponseCode'));
        $this->assertEquals('Account number was successfully registered', XMLParser::getNode($registerTokenResponse, 'tokenMessage'));
        $this->assertEquals('EC', XMLParser::getNode($registerTokenResponse, 'type'));
        $this->assertEquals('999', XMLParser::getNode($registerTokenResponse, 'eCheckAccountSuffix'));
        $this->assertEquals('111922223333444999', XMLParser::getNode($registerTokenResponse, 'litleToken'));
    }

    public function test_63()
    {
        $token_hash = [
        'orderId'                         => '63',
                          'amount'        => '15000',
                          'orderSource'   => 'ecommerce',
                          'billToAddress' => [
        'firstName'                  => 'Tom',
                          'lastName' => 'Black', ],
                          'echeck' => ['accType' => 'Checking', 'accNum' => '1099999999', 'routingNum' => '214567892'], ];

        $initilaize = new LitleOnlineRequest();
        $registerTokenResponse = $initilaize->echeckSaleRequest($token_hash);
        $this->assertEquals('801', XMLParser::getNode($registerTokenResponse, 'tokenResponseCode'));
        $this->assertEquals('Account number was successfully registered', XMLParser::getNode($registerTokenResponse, 'tokenMessage'));
        $this->assertEquals('EC', XMLParser::getNode($registerTokenResponse, 'type'));
        $this->assertEquals('999', XMLParser::getNode($registerTokenResponse, 'eCheckAccountSuffix'));
        $this->assertEquals('111922223333555999', XMLParser::getNode($registerTokenResponse, 'litleToken'));
    }
}
