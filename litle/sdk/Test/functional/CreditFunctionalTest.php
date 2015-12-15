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

class CreditFunctionalTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple_credit_with_card()
    {
        $hash_in = [
            'card' => ['type'           => 'VI',
                    'number'            => '4100000000000000',
                    'expDate'           => '1213',
                    'cardValidationNum' => '1213', ],
            'id'          => '1211',
            'orderId'     => '2111',
            'reportGroup' => 'Planets',
            'orderSource' => 'ecommerce',
            'amount'      => '123', ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $response = XmlParser::getNode($creditResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_simple_credit_with_paypal()
    {
        $hash_in = [
                'paypal' => ['payerId' => '123', 'payerEmail' => '12321321',
                'transactionId'        => '123123', ],
                'id'          => '1211',
                'orderId'     => '2111',
                'reportGroup' => 'Planets',
                'orderSource' => 'ecommerce',
                'amount'      => '123', ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'message');
        $this->assertRegExp('/Error validating xml data against the schema/', $message);
    }

    public function test_simple_credit_with_litleTxnId()
    {
        $hash_in = ['reportGroup' => 'planets', 'litleTxnId' => '1234567891234567891'];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'response');
        $this->assertEquals('0', $message);
    }

    public function test_paypal_notes()
    {
        $hash_in = [
                'card' => ['type'           => 'VI',
                        'number'            => '4100000000000000',
                        'expDate'           => '1213',
                        'cardValidationNum' => '1213', ],
                'id'          => '1211',
                'payPalNotes' => 'hello',
                'orderId'     => '2111',
                'reportGroup' => 'Planets',
                'orderSource' => 'ecommerce',
                'amount'      => '123', ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $response = XmlParser::getNode($creditResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_amexAggregator()
    {
        $hash_in = [
          'amount'                => '2000',
          'orderId'               => '12344',
          'orderSource'           => 'ecommerce',
          'processingInstuctions' => ['bypassVelocityCheck' => 'yes'],
          'card'                  => [
          'type'    => 'VI',
          'number'  => '4100000000000000',
          'expDate' => '1210', ],
          'amexAggregatorData' => ['sellerMerchantCategoryCode' => '1234', 'sellerId' => '1234Id'], ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $response = XmlParser::getNode($creditResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_simple_credit_with_secondary_amount()
    {
        $hash_in = [
                'card' => ['type'           => 'VI',
                        'number'            => '4100000000000000',
                        'expDate'           => '1213',
                        'cardValidationNum' => '1213', ],
                'id'              => '1211',
                'orderId'         => '2111',
                'reportGroup'     => 'Planets',
                'orderSource'     => 'ecommerce',
                'amount'          => '123',
                'secondaryAmount' => '1234', ];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $response = XmlParser::getNode($creditResponse, 'response');
        $this->assertEquals('000', $response);
    }

    public function test_simple_credit_with_litleTxnId_AndSecondaryAmount()
    {
        $hash_in = ['reportGroup' => 'planets', 'litleTxnId' => '1234567891234567891', 'secondaryAmount' => '100'];

        $initilaize = new LitleOnlineRequest();
        $creditResponse = $initilaize->creditRequest($hash_in);
        $message = XmlParser::getAttribute($creditResponse, 'litleOnlineResponse', 'response');
        $this->assertEquals('0', $message);
    }
}
