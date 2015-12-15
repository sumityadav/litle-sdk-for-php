<?php

namespace litle\sdk\Test\unit;

use litle\sdk\Transactions;

class TransactionsUnitTest extends \PHPUnit_Framework_TestCase
{
    public function test_auth_with_card()
    {
        $hash_in = [
            'card' => ['type'           => 'VI',
                    'number'            => '4100000000000001',
                    'expDate'           => '1213',
                    'cardValidationNum' => '1213', ],
            'orderId'     => '2111',
            'orderSource' => 'ecommerce',
            'amount'      => '123', ];

        $hash_out = Transactions::createAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_auth_muliple_lineItemData()
    {
        $lineItemData = [
        ['itemSequenceNumber' => '1', 'itemDescription' => 'desc'],
        ['itemSequenceNumber' => '2', 'itemDescription' => 'desc2'], ];

        $hash_in = [
                    'card' => ['type'           => 'VI',
                            'number'            => '4100000000000001',
                            'expDate'           => '1213',
                            'cardValidationNum' => '1213', ],
                    'orderId'      => '2111',
                    'orderSource'  => 'ecommerce',
                    'enhancedData' => ['salesTax' => '123',
                    'shippingAmount'              => '123',
                    'lineItemData'                => $lineItemData, ],
                    'amount' => '123', ];

        $hash_out = Transactions::createAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_auth_muliple_detailTax()
    {
        $detailTax = [
        ['taxAmount' => '0', 'cardAcceptorTaxId' => '0'],
        ['taxAmount' => '1', 'cardAcceptorTaxId' => '1'], ];

        $hash_in = [
                        'card' => ['type'           => 'VI',
                                'number'            => '4100000000000001',
                                'expDate'           => '1213',
                                'cardValidationNum' => '1213', ],
                        'orderId'      => '2111',
                        'orderSource'  => 'ecommerce',
                        'enhancedData' => ['salesTax' => '123',
                        'shippingAmount'              => '123',
                        'detailTax'                   => $detailTax, ],
                        'amount' => '123', ];

        $hash_out = Transactions::createAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_auth_merchant_data()
    {
        $hash_in = [
                'orderId'      => '2111',
                'orderSource'  => 'ecommerce',
                'amount'       => '123',
                'merchantData' => [
                    'campaign' => 'foo',
        ],
        ];
        $hash_out = Transactions::createAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_auth_fraud_filter_override()
    {
        $hash_in = [
            'card' => ['type'                   => 'VI',
                            'number'            => '4100000000000001',
                            'expDate'           => '1213',
                            'cardValidationNum' => '1213', ],
            'orderSource'         => 'ecommerce',
            'amount'              => '123',
            'fraudFilterOverride' => 'true',
        ];
        $hash_out = Transactions::createAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_auth_surchargeAmount()
    {
        $hash_in = [
            'card' => [
                'type'    => 'VI',
                'number'  => '4100000000000001',
                'expDate' => '1213',
            ],
            'amount'          => '2',
            'surchargeAmount' => '1',
            'orderSource'     => 'ecommerce',
        ];
        $hash_out = Transactions::createAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_auth_surchargeAmount_Optional()
    {
        $hash_in = [
                'card' => [
                        'type'    => 'VI',
                        'number'  => '4100000000000001',
                        'expDate' => '1213',
                ],
                'orderId'     => '12344',
                'amount'      => '2',
                'orderSource' => 'ecommerce',
        ];
        $hash_out = Transactions::createAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_auth_recurringRequest()
    {
        $hash_in = [
            'card' => [
                'type'    => 'VI',
                'number'  => '4100000000000001',
                'expDate' => '1213',
            ],
            'orderId'             => '12344',
            'amount'              => '2',
            'orderSource'         => 'ecommerce',
            'fraudFilterOverride' => 'true',
            'recurringRequest'    => [
                'subscription' => [
                    'planCode'         => 'abc123',
                    'numberOfPayments' => 12,
                ],
            ],
        ];
        $hash_out = Transactions::createAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_auth_debtRepayment()
    {
        $hash_in = [
                'card' => [
                        'type'    => 'VI',
                        'number'  => '4100000000000001',
                        'expDate' => '1213',
                ],
                'orderId'             => '12344',
                'amount'              => '2',
                'orderSource'         => 'ecommerce',
                'fraudFilterOverride' => 'true',
                'debtRepayment'       => 'true',
        ];
        $hash_out = Transactions::createAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_capture_simple_capture()
    {
        $hash_in = ['litleTxnId' => '12312312', 'amount' => '123'];
        $hash_out = Transactions::createCaptureHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_capture_surchargeAmount()
    {
        $hash_in = [
            'litleTxnId'      => '3',
            'amount'          => '2',
            'surchargeAmount' => '1',
            'payPalNotes'     => 'notes',
        ];
        $hash_out = Transactions::createCaptureHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_capture_surchargeAmount_optional()
    {
        $hash_in = [
                'litleTxnId'  => '3',
                'amount'      => '2',
                'payPalNotes' => 'notes',
        ];
        $hash_out = Transactions::createCaptureHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_captureGivenAuth_simple_captureGivenAuth()
    {
        $hash_in = [
       'amount'          => '123',
       'orderId'         => '12344',
       'authInformation' => [
       'authDate'   => '2002-10-09', 'authCode' => '543216',
       'authAmount' => '12345', ],
       'orderSource' => 'ecommerce',
       'card'        => [
       'type'    => 'VI',
       'number'  => '4100000000000001',
       'expDate' => '1210', ], ];
        $hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_captureGivenAuth_surchargeAmount()
    {
        $hash_in = [
            'amount'          => '2',
            'surchargeAmount' => '1',
            'orderSource'     => 'ecommerce',
            'orderId'         => '3',
        ];
        $hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_captureGivenAuth_surchargeAmount_optional()
    {
        $hash_in = [
                'amount'      => '2',
                'orderSource' => 'ecommerce',
                'orderId'     => '3',
        ];
        $hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_captureGivenAuth_debtRepayment_true()
    {
        $hash_in = [
                'amount'       => '2',
                'orderSource'  => 'ecommerce',
                'orderId'      => '3',
                'merchantData' => [
                    'campaign' => 'foo',
                ],
                'debtRepayment' => 'true',
        ];
        $hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_captureGivenAuth_debtRepayment_false()
    {
        $hash_in = [
                'amount'       => '2',
                'orderSource'  => 'ecommerce',
                'orderId'      => '3',
                'merchantData' => [
                    'campaign' => 'foo',
                ],
                'debtRepayment' => 'false',
        ];
        $hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_captureGivenAuth_debtRepayment_optional()
    {
        $hash_in = [
                'amount'       => '2',
                'orderSource'  => 'ecommerce',
                'orderId'      => '3',
                'merchantData' => [
                        'campaign' => 'foo',
                ],
        ];
        $hash_out = Transactions::createCaptureGivenAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_credit()
    {
        $hash_in = ['litleTxnId'       => '12312312',
                         'orderId'     => '2111',
                         'orderSource' => 'ecommerce',
                         'amount'      => '123', ];
        $hash_out = Transactions::createCreditHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_credit_action_reason_on_orphaned_refund()
    {
        $hash_in = [
                    'orderId'      => '2111',
                    'orderSource'  => 'ecommerce',
                    'amount'       => '123',
                    'actionReason' => 'SUSPECT_FRAUD',
        ];
        $hash_out = Transactions::createCreditHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_credit_surchargeAmount_tied()
    {
        $hash_in = [
                'amount'                 => '2',
                'surchargeAmount'        => '1',
                'litleTxnId'             => '3',
                'processingInstructions' => [],
        ];
        $hash_out = Transactions::createCreditHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_credit_surchargeAmount_tied_optional()
    {
        $hash_in = [
                'amount'                 => '2',
                'litleTxnId'             => '3',
                'processingInstructions' => [],
        ];
        $hash_out = Transactions::createCreditHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_credit_surchargeAmount_orphan()
    {
        $hash_in = [
                'amount'          => '2',
                'surchargeAmount' => '1',
                'orderId'         => '3',
                'orderSource'     => 'ecommerce',
        ];
        $hash_out = Transactions::createCreditHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_credit_surchargeAmount_orphan_optional()
    {
        $hash_in = [
                'amount'      => '2',
                'orderId'     => '3',
                'orderSource' => 'ecommerce',
        ];
        $hash_out = Transactions::createCreditHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_credit_pos_tied()
    {
        $hash_in = [
                'amount' => '2',
                'pos'    => [
                    'terminalId'   => 'abc123',
                    'capability'   => 'a',
                    'entryMode'    => 'b',
                    'cardholderId' => 'c',
                ],
                'litleTxnId'  => '3',
                'payPalNotes' => 'notes',
        ];
        $hash_out = Transactions::createCreditHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_credit_pos_tied_optional()
    {
        $hash_in = [
                'amount'      => '2',
                'litleTxnId'  => '3',
                'payPalNotes' => 'notes',
        ];
        $hash_out = Transactions::createCreditHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_echeckCredit()
    {
        $hash_in = ['litleTxnId' => '123123'];
        $hash_out = Transactions::createEcheckCreditHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_echeckRedeposit()
    {
        $hash_in = ['litleTxnId' => '123123'];
        $hash_out = Transactions::createEcheckRedepositHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_echeckRedeposit_merchantData()
    {
        $hash_in = [
                'litleTxnId'   => '123123',
                'merchantData' => ['campaign' => 'camping'], ];
        $hash_out = Transactions::createEcheckRedepositHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_echeckSale()
    {
        $hash_in = ['litleTxnId' => '123123'];
        $hash_out = Transactions::createEcheckSaleHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_echeckVerification()
    {
        $hash_in = ['amount' => '123', 'orderId' => '123', 'orderSource' => 'ecommerce',
        'echeckToken'         => ['accType' => 'Checking', 'routingNum' => '123123', 'litleToken' => '1234565789012', 'checkNum' => '123455'], ];
        $hash_out = Transactions::createEcheckVerificationHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_echeckVerification_merchantData()
    {
        $hash_in = ['amount'  => '123', 'orderId' => '123', 'orderSource' => 'ecommerce', 'merchantData' => ['campaign' => 'camping'],
                'echeckToken' => ['accType' => 'Checking', 'routingNum' => '123123', 'litleToken' => '1234565789012', 'checkNum' => '123455'], ];
        $hash_out = Transactions::createEcheckVerificationHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_forceCapture()
    {
        $hash_in = [
          'amount'      => '106',
          'orderSource' => 'ecommerce',
          'token'       => [
          'litleToken'        => '123456789101112',
          'expDate'           => '1210',
          'cardValidationNum' => '555',
          'type'              => 'VI', ], ];
        $hash_out = Transactions::createForceCaptureHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_forceCapture_surchargeAmount()
    {
        $hash_in = [
            'orderId'         => '3',
            'amount'          => '2',
            'surchargeAmount' => '1',
            'orderSource'     => 'ecommerce',
        ];
        $hash_out = Transactions::createForceCaptureHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_forceCapture_surchargeAmount_optional()
    {
        $hash_in = [
            'orderId'     => '3',
            'amount'      => '2',
            'orderSource' => 'ecommerce',
        ];
        $hash_out = Transactions::createForceCaptureHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_forceCapture_debtRepayment_true()
    {
        $hash_in = [
                'amount'       => '2',
                'orderSource'  => 'ecommerce',
                'orderId'      => '3',
                'merchantData' => [
                        'campaign' => 'foo',
                ],
                'debtRepayment' => 'true',
        ];
        $hash_out = Transactions::createForceCaptureHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_forceCapture_debtRepayment_false()
    {
        $hash_in = [
                'amount'       => '2',
                'orderSource'  => 'ecommerce',
                'orderId'      => '3',
                'merchantData' => [
                        'campaign' => 'foo',
                ],
                'debtRepayment' => 'false',
        ];
        $hash_out = Transactions::createForceCaptureHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_forceCapture_debtRepayment_optional()
    {
        $hash_in = [
                'amount'       => '2',
                'orderSource'  => 'ecommerce',
                'orderId'      => '3',
                'merchantData' => [
                        'campaign' => 'foo',
                ],
        ];
        $hash_out = Transactions::createForceCaptureHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_sale_with_card()
    {
        $hash_in = [
            'card' => ['type'           => 'VI',
                    'number'            => '4100000000000001',
                    'expDate'           => '1213',
                    'cardValidationNum' => '1213', ],
            'orderId'     => '2111',
            'orderSource' => 'ecommerce',
            'amount'      => '123', ];

        $hash_out = Transactions::createSaleHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_token()
    {
        $hash_in = [
            'orderId'       => '1',
            'accountNumber' => '123456789101112', ];

        $hash_out = Transactions::createRegisterTokenHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_updateCardValidationNumOnToken()
    {
        $hash_in = [
            'orderId'           => '1',
            'litleToken'        => '123456789101112',
            'cardValidationNum' => '123', ];
        $hash_out = Transactions::createUpdateCardValidationNumOnTokenHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_updateSubscription()
    {
        $hash_in = [
            'subscriptionId' => '1',
            'planCode'       => '2',
            'billToAddress'  =>  [
                'addressLine1' => '3',
            ],
            'card' =>  [
                'type'              => 'VI',
                'number'            => '4100000000000000',
                'expDate'           => '1213',
                'cardValidationNum' => '1213',
            ],
            'billingDate' => '2013-12-17', ];
        $hash_out = Transactions::createUpdateSubscriptionHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_cancelSubscription()
    {
        $hash_in = [
            'subscriptionId' => '1', ];
        $hash_out = Transactions::createCancelSubscriptionHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_createPlan()
    {
        $hash_in = [
            'planCode'     => '1',
            'name'         => '2',
            'intervalType' => 'MONTHLY',
            'amount'       => '1000',
        ];
        $hash_out = Transactions::createCreatePlanHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_updatePlan()
    {
        $hash_in = [
            'planCode' => '1',
            'active'   => 'false',
        ];
        $hash_out = Transactions::createUpdatePlanHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_activate()
    {
        $hash_in = [
            'orderId'     => '1',
            'amount'      => '2',
            'orderSource' => 'ECOMMERCE',
            'card'        =>  [
                'type'              => 'VI',
                'number'            => '4100000000000000',
                'expDate'           => '1213',
                'cardValidationNum' => '1213',
            ],
        ];
        $hash_out = Transactions::createActivateHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_deactivate()
    {
        $hash_in = [
            'orderId'     => '1',
            'orderSource' => 'ECOMMERCE',
            'card'        =>  [
                'type'              => 'VI',
                'number'            => '4100000000000000',
                'expDate'           => '1213',
                'cardValidationNum' => '1213',
            ],
        ];
        $hash_out = Transactions::createDeactivateHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_load()
    {
        $hash_in = [
            'orderId'     => '1',
            'amount'      => '2',
            'orderSource' => 'ECOMMERCE',
            'card'        =>  [
                'type'              => 'VI',
                'number'            => '4100000000000000',
                'expDate'           => '1213',
                'cardValidationNum' => '1213',
            ],
        ];
        $hash_out = Transactions::createLoadHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_unload()
    {
        $hash_in = [
            'orderId'     => '1',
            'amount'      => '2',
            'orderSource' => 'ECOMMERCE',
            'card'        =>  [
                'type'              => 'VI',
                'number'            => '4100000000000000',
                'expDate'           => '1213',
                'cardValidationNum' => '1213',
            ],
        ];
        $hash_out = Transactions::createUnloadHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_simple_balanceInquiry()
    {
        $hash_in = [
            'orderId'     => '1',
            'orderSource' => 'ECOMMERCE',
            'card'        =>  [
                'type'              => 'VI',
                'number'            => '4100000000000000',
                'expDate'           => '1213',
                'cardValidationNum' => '1213',
            ],
        ];
        $hash_out = Transactions::createBalanceInquiryHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_auth_with_applepay()
    {
        $hash_in = [
                'orderId'         => '2111',
                'amount'          => '123',
                'secondaryAmount' => '2000',
                'orderSource'     => 'ecommerce',
                'applepay'        => [
                        'data'      => 'string data here',
                        'header'    => 'header stuff here',
                        'signature' => 'signature',
                        'version'   => 'version 1', ], ];

        $hash_out = Transactions::createAuthHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_sale_with_applepay()
    {
        $hash_in = [
                'orderId'         => '2111',
                'amount'          => '123',
                'secondaryAmount' => '2000',
                'orderSource'     => 'ecommerce',
                'applepay'        => [
                        'data'      => 'string data here',
                        'header'    => 'header stuff here',
                        'signature' => 'signature',
                        'version'   => 'version 1', ], ];

        $hash_out = Transactions::createSaleHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_credit_with_secondary_amount()
    {
        $hash_in = [
                'orderId'         => '2111',
                'amount'          => '123',
                'secondaryAmount' => '2000',
                'orderSource'     => 'ecommerce',
                'card'            =>  [
                    'type'              => 'VI',
                    'number'            => '4100000000000000',
                    'expDate'           => '1213',
                    'cardValidationNum' => '1213', ], ];

        $hash_out = Transactions::createCreditHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_token_with_applepay()
    {
        $hash_in = [
                'orderId'  => '1',
                'applepay' => [
                        'data'      => 'string data here',
                        'header'    => 'header stuff here',
                        'signature' => 'signature',
                        'version'   => 'version 1', ], ];

        $hash_out = Transactions::createRegisterTokenHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_forcecapture_with_secondary_amount()
    {
        $hash_in = [
                'orderId'         => '2111',
                'amount'          => '123',
                'secondaryAmount' => '2000',
                'orderSource'     => 'ecommerce',
                'card'            =>  [
                        'type'              => 'VI',
                        'number'            => '4100000000000000',
                        'expDate'           => '1213',
                        'cardValidationNum' => '1213', ], ];

        $hash_out = Transactions::createForceCaptureHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }

    public function test_echeckSale_secondaryamount()
    {
        $hash_in = ['litleTxnId' => '123123', 'secondaryAmount' => '2000'];
        $hash_out = Transactions::createEcheckSaleHash($hash_in);
        $this->assertEquals($hash_in, array_intersect($hash_in, $hash_out));
    }
}
