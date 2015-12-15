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

class CertEcheckTest extends \PHPUnit_Framework_TestCase
{
    #37-40 echeckVerification

    public function test_37()
    {
        $echeck_hash = [
        'orderId'       => '37',
        'amount'        => '3001',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName' => 'Tom',
        'lastName'  => 'Black', ],
        'echeck' => [
        'accNum'     => '10@BC99999',
        'accType'    => 'Checking',
        'routingNum' => '053100300', ], ];

        $initilaize = new LitleOnlineRequest();
        $echeckVerificationResponse = $initilaize->echeckVerificationRequest($echeck_hash);
        $this->assertEquals('301', XMLParser::getNode($echeckVerificationResponse, 'response'));
        $this->assertEquals('Invalid Account Number', XMLParser::getNode($echeckVerificationResponse, 'message'));
    }

    public function test_38()
    {
        $echeck_hash = [
        'orderId'       => '38',
        'amount'        => '3002',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName' => 'John',
        'lastName'  => 'Smith',
        'phone'     => '999-999-9999', ],
        'echeck' => [
        'accNum'     => '1099999999',
        'accType'    => 'Checking',
        'routingNum' => '053000219', ], ];
        $initilaize = new LitleOnlineRequest();

        $echeckVerificationResponse = $initilaize->echeckVerificationRequest($echeck_hash);
        $this->assertEquals('000', XMLParser::getNode($echeckVerificationResponse, 'response'));
        $this->assertEquals('Approved', XMLParser::getNode($echeckVerificationResponse, 'message'));
    }

    public function test_39()
    {
        $echeck_hash = [
        'orderId'       => '39',
        'amount'        => '3003',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName'   => 'Robert',
        'lastName'    => 'Jones',
        'companyName' => 'Good Goods Inc',
        'phone'       => '9999999999', ],
        'echeck' => [
        'accNum'     => '3099999999',
        'accType'    => 'Corporate',
        'routingNum' => '053100300', ], ];

        $initilaize = new LitleOnlineRequest();
        $echeckVerificationResponse = $initilaize->echeckVerificationRequest($echeck_hash);
        $this->assertEquals('950', XMLParser::getNode($echeckVerificationResponse, 'response'));
        $this->assertEquals('Declined - Negative Information on File', XMLParser::getNode($echeckVerificationResponse, 'message'));
    }

    public function test_40()
    {
        $echeck_hash = [
        'orderId'       => '40',
        'amount'        => '3004',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName'   => 'Peter',
        'lastName'    => 'Green',
        'companyName' => 'Green Co',
        'phone'       => '9999999999', ],
        'echeck' => [
        'accNum'     => '8099999999',
        'accType'    => 'Corporate',
        'routingNum' => '063102152', ], ];

        $initilaize = new LitleOnlineRequest();
        $echeckVerificationResponse = $initilaize->echeckVerificationRequest($echeck_hash);
        $this->assertEquals('951', XMLParser::getNode($echeckVerificationResponse, 'response'));
        $this->assertEquals('Absolute Decline', XMLParser::getNode($echeckVerificationResponse, 'message'));
    }

    #41-44 echecksales

    public function test_41()
    {
        $echeck_hash = [
        'orderId'       => '41',
        'amount'        => '2008',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName'     => 'Mike',
        'middleInitial' => 'J',
        'lastName'      => 'Hammer', ],
        'echeck' => [
        'accNum'     => '10@BC99999',
        'accType'    => 'Checking',
        'routingNum' => '053100300', ], ];

        $initilaize = new LitleOnlineRequest();
        $echeckSaleResponse = $initilaize->echeckSaleRequest($echeck_hash);
        $this->assertEquals('301', XMLParser::getNode($echeckSaleResponse, 'response'));
        $this->assertEquals('Invalid Account Number', XMLParser::getNode($echeckSaleResponse, 'message'));
    }

    public function test_42()
    {
        $echeck_hash = [
        'orderId'       => '42',
        'amount'        => '2004',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName' => 'Tom',
        'lastName'  => 'Black', ],
        'echeck' => [
        'accNum'     => '4099999992',
        'accType'    => 'Checking',
        'routingNum' => '211370545', ], ];

        $initilaize = new LitleOnlineRequest();
        $echeckSaleResponse = $initilaize->echeckSaleRequest($echeck_hash);
        $this->assertEquals('000', XMLParser::getNode($echeckSaleResponse, 'response'));
        $this->assertEquals('Approved', XMLParser::getNode($echeckSaleResponse, 'message'));
    }

    public function test_43()
    {
        $echeck_hash = [
        'orderId'       => '43',
        'amount'        => '2007',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName'   => 'Peter',
        'lastName'    => 'Green',
        'companyName' => 'Green Co', ],
        'echeck' => [
        'accNum'     => '6099999992',
        'accType'    => 'Corporate',
        'routingNum' => '211370545', ], ];

        $initilaize = new LitleOnlineRequest();
        $echeckSaleResponse = $initilaize->echeckSaleRequest($echeck_hash);
        $this->assertEquals('000', XMLParser::getNode($echeckSaleResponse, 'response'));
        $this->assertEquals('Approved', XMLParser::getNode($echeckSaleResponse, 'message'));
    }

    public function test_44()
    {
        $echeck_hash = [
        'orderId'       => '44',
        'amount'        => '2009',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName'   => 'Peter',
        'lastName'    => 'Green',
        'companyName' => 'Green Co', ],
        'echeck' => [
        'accNum'     => '9099999992',
        'accType'    => 'Corporate',
        'routingNum' => '053133052', ], ];

        $initilaize = new LitleOnlineRequest();
        $echeckSaleResponse = $initilaize->echeckSaleRequest($echeck_hash);
        $this->assertEquals('900', XMLParser::getNode($echeckSaleResponse, 'response'));
        $this->assertEquals('Invalid Bank Routing Number', XMLParser::getNode($echeckSaleResponse, 'message'));
    }

    #test 45- 49 echeckCredit

    public function test_45()
    {
        $echeck_hash = [
        'orderId'       => '45',
        'amount'        => '1001',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName' => 'John',
        'lastName'  => 'Smith', ],
        'echeck' => [
        'accNum'     => '10@BC99999',
        'accType'    => 'Checking',
        'routingNum' => '053100300', ], ];

        $initilaize = new LitleOnlineRequest();
        $echeckCreditResponse = $initilaize->echeckCreditRequest($echeck_hash);
        $this->assertEquals('301', XMLParser::getNode($echeckCreditResponse, 'response'));
    }

    public function test_46()
    {
        $echeck_hash = [
        'orderId'       => '46',
        'amount'        => '1003',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName'   => 'Robert',
        'lastName'    => 'Jones',
        'companyName' => 'Widget Inc', ],
        'echeck' => [
        'accNum'     => '3099999999',
        'accType'    => 'Corporate',
        'routingNum' => '063102152', ], ];

        $initilaize = new LitleOnlineRequest();
        $echeckCreditResponse = $initilaize->echeckCreditRequest($echeck_hash);
        $this->assertEquals('000', XMLParser::getNode($echeckCreditResponse, 'response'));
        $this->assertEquals('Approved', XMLParser::getNode($echeckCreditResponse, 'message'));
    }

    public function test_47()
    {
        $echeck_hash = [
        'orderId'       => '47',
        'amount'        => '1007',
        'orderSource'   => 'telephone',
        'billToAddress' => [
        'firstName'   => 'Peter',
        'lastName'    => 'Green',
        'companyName' => 'Green Co', ],
        'echeck' => [
        'accNum'     => '6099999993',
        'accType'    => 'Corporate',
        'routingNum' => '211370545', ], ];

        $initilaize = new LitleOnlineRequest();
        $echeckCreditResponse = $initilaize->echeckCreditRequest($echeck_hash);
        $this->assertEquals('000', XMLParser::getNode($echeckCreditResponse, 'response'));
        $this->assertEquals('Approved', XMLParser::getNode($echeckCreditResponse, 'message'));
    }

    public function test_48()
    {
        $echeck_hash = ['litleTxnId' => '430000000000000001'];

        $initilaize = new LitleOnlineRequest();
        $echeckCreditResponse = $initilaize->echeckCreditRequest($echeck_hash);
        $this->assertEquals('000', XMLParser::getNode($echeckCreditResponse, 'response'));
        $this->assertEquals('Approved', XMLParser::getNode($echeckCreditResponse, 'message'));
    }

    public function test_49()
    {
        $echeck_hash = ['litleTxnId' => '2'];

        $initilaize = new LitleOnlineRequest();
        $echeckCreditResponse = $initilaize->echeckCreditRequest($echeck_hash);
        $this->assertEquals('360', XMLParser::getNode($echeckCreditResponse, 'response'));
        $this->assertEquals('No transaction found with specified litleTxnId', XMLParser::getNode($echeckCreditResponse, 'message'));
    }
}
