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

namespace litle\sdk;

#require_once realpath(dirname(__FILE__)) . "/LitleOnline.php";

class XmlFields
{
    public static function returnArrayValue($hash_in, $key, $maxlength = null)
    {
        $retVal = array_key_exists($key, $hash_in) ? $hash_in[$key] : null;
        if ($maxlength && !is_null($retVal)) {
            $retVal = substr($retVal, 0, $maxlength);
        }

        return $retVal;
    }

    public static function contact($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'name'          => self::returnArrayValue($hash_in, 'name', 100),
                        'firstName'     => self::returnArrayValue($hash_in, 'firstName', 25),
                        'middleInitial' => self::returnArrayValue($hash_in, 'middleInitial', 1),
                        'lastName'      => self::returnArrayValue($hash_in, 'lastName', 25),
                        'companyName'   => self::returnArrayValue($hash_in, 'companyName', 40),
                        'addressLine1'  => self::returnArrayValue($hash_in, 'addressLine1', 35),
                        'addressLine2'  => self::returnArrayValue($hash_in, 'addressLine2', 35),
                        'addressLine3'  => self::returnArrayValue($hash_in, 'addressLine3', 35),
                        'city'          => self::returnArrayValue($hash_in, 'city', 35),
                        'state'         => self::returnArrayValue($hash_in, 'state', 30),
                        'zip'           => self::returnArrayValue($hash_in, 'zip', 20),
                        'country'       => self::returnArrayValue($hash_in, 'country', 3),
                        'email'         => self::returnArrayValue($hash_in, 'email', 100),
                        'phone'         => self::returnArrayValue($hash_in, 'phone', 20),
            ];

            return $hash_out;
        }
    }

    public static function customerInfo($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'ssn'                      => self::returnArrayValue($hash_in, 'ssn'),
                        'dob'                      => self::returnArrayValue($hash_in, 'dob'),
                        'customerRegistrationDate' => self::returnArrayValue($hash_in, 'customerRegistrationDate'),
                        'customerType'             => self::returnArrayValue($hash_in, 'customerType'),
                        'incomeAmount'             => self::returnArrayValue($hash_in, 'incomeAmount'),
                        'incomeCurrency'           => self::returnArrayValue($hash_in, 'incomeCurrency'),
                        'customerCheckingAccount'  => self::returnArrayValue($hash_in, 'customerCheckingAccount'),
                        'customerSavingAccount'    => self::returnArrayValue($hash_in, 'customerSavingAccount'),
                        'customerWorkTelephone'    => self::returnArrayValue($hash_in, 'customerWorkTelephone'),
                        'residenceStatus'          => self::returnArrayValue($hash_in, 'residenceStatus'),
                        'yearsAtResidence'         => self::returnArrayValue($hash_in, 'yearsAtResidence'),
                        'yearsAtEmployer'          => self::returnArrayValue($hash_in, 'yearsAtEmployer'),
            ];

            return $hash_out;
        }
    }

    public static function billMeLaterRequest($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'bmlMerchantId'                             => self::returnArrayValue($hash_in, 'bmlMerchantId'),
                        'termsAndConditions'                        => self::returnArrayValue($hash_in, 'termsAndConditions'),
                        'preapprovalNumber'                         => self::returnArrayValue($hash_in, 'preapprovalNumber'),
                        'merchantPromotionalCode'                   => self::returnArrayValue($hash_in, 'merchantPromotionalCode'),
                        'customerPasswordChanged'                   => self::returnArrayValue($hash_in, 'customerPasswordChanged'),
                        'customerEmailChanged'                      => self::returnArrayValue($hash_in, 'customerEmailChanged'),
                        'customerPhoneChanged'                      => self::returnArrayValue($hash_in, 'customerPhoneChanged'),
                        'secretQuestionCode'                        => self::returnArrayValue($hash_in, 'secretQuestionCode'),
                        'secretQuestionAnswer'                      => self::returnArrayValue($hash_in, 'secretQuestionAnswer'),
                        'virtualAuthenticationKeyPresenceIndicator' => self::returnArrayValue($hash_in, 'virtualAuthenticationKeyPresenceIndicator'),
                        'virtualAuthenticationKeyData'              => self::returnArrayValue($hash_in, 'virtualAuthenticationKeyData'),
                        'itemCategoryCode'                          => self::returnArrayValue($hash_in, 'itemCategoryCode'),
                        'authorizationSourcePlatform'               => self::returnArrayValue($hash_in, 'authorizationSourcePlatform'),
            ];

            return $hash_out;
        }
    }

    public static function fraudCheckType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'authenticationValue'         => self::returnArrayValue($hash_in, 'authenticationValue'),
                        'authenticationTransactionId' => self::returnArrayValue($hash_in, 'authenticationTransactionId'),
                        'customerIpAddress'           => self::returnArrayValue($hash_in, 'customerIpAddress'),
                        'authenticatedByMerchant'     => self::returnArrayValue($hash_in, 'authenticatedByMerchant'),
            ];

            return $hash_out;
        }
    }

    public static function merchantData($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'campaign'           => self::returnArrayValue($hash_in, 'campaign'),
                        'affiliate'          => self::returnArrayValue($hash_in, 'affiliate'),
                        'merchantGroupingId' => self::returnArrayValue($hash_in, 'merchantGroupingId'),
            ];

            return $hash_out;
        }
    }

    public static function authInformation($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'authDate'    => (Checker::requiredField(self::returnArrayValue($hash_in, 'authDate'))),
                        'authCode'    => (Checker::requiredField(self::returnArrayValue($hash_in, 'authCode'))),
                        'fraudResult' => self::fraudResult(self::returnArrayValue($hash_in, 'fraudResult')),
                        'authAmount'  => self::returnArrayValue($hash_in, 'authAmount'),
            ];

            return $hash_out;
        }
    }

    public static function fraudResult($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'avsResult'            => self::returnArrayValue($hash_in, 'avsResult'),
                        'cardValidationResult' => self::returnArrayValue($hash_in, 'cardValidationResult'),
                        'authenticationResult' => self::returnArrayValue($hash_in, 'authenticationResult'),
                        'advancedAVSResult'    => self::returnArrayValue($hash_in, 'advancedAVSResult'),
            ];

            return $hash_out;
        }
    }

    public static function healthcareAmounts($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'totalHealthcareAmount' => self::returnArrayValue($hash_in, 'totalHealthcareAmount'),
                        'RxAmount'              => self::returnArrayValue($hash_in, 'RxAmount'),
                        'visionAmount'          => self::returnArrayValue($hash_in, 'visionAmount'),
                        'clinicOtherAmount'     => self::returnArrayValue($hash_in, 'clinicOtherAmount'),
                        'dentalAmount'          => self::returnArrayValue($hash_in, 'dentalAmount'),
            ];

            return $hash_out;
        }
    }

    public static function healthcareIIAS($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'healthcareAmounts' => (self::healthcareAmounts(self::returnArrayValue($hash_in, 'healthcareAmounts'))),
                        'IIASFlag'          => self::returnArrayValue($hash_in, 'IIASFlag'),
            ];

            return $hash_out;
        }
    }

    public static function pos($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'capability'   => (Checker::requiredField(self::returnArrayValue($hash_in, 'capability'))),
                        'entryMode'    => (Checker::requiredField(self::returnArrayValue($hash_in, 'entryMode'))),
                        'cardholderId' => (Checker::requiredField(self::returnArrayValue($hash_in, 'cardholderId'))),
                        'terminalId'   => self::returnArrayValue($hash_in, 'terminalId'),
                        'catLevel'     => self::returnArrayValue($hash_in, 'catLevel'),
            ];

            return $hash_out;
        }
    }

    public static function detailTax($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'taxIncludedInTotal' => self::returnArrayValue($hash_in, 'taxIncludedInTotal'),
                        'taxAmount'          => self::returnArrayValue($hash_in, 'taxAmount'),
                        'taxRate'            => self::returnArrayValue($hash_in, 'taxRate'),
                        'taxTypeIdentifier'  => self::returnArrayValue($hash_in, 'taxTypeIdentifier'),
                        'cardAcceptorTaxId'  => self::returnArrayValue($hash_in, 'cardAcceptorTaxId'),
            ];

            return $hash_out;
        }
    }

    public static function lineItemData($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'itemSequenceNumber'   => self::returnArrayValue($hash_in, 'itemSequenceNumber'),
                        'itemDescription'      => self::returnArrayValue($hash_in, 'itemDescription', 26),
                        'productCode'          => self::returnArrayValue($hash_in, 'productCode', 12),
                        'quantity'             => self::returnArrayValue($hash_in, 'quantity'),
                        'unitOfMeasure'        => self::returnArrayValue($hash_in, 'unitOfMeasure'),
                        'taxAmount'            => self::returnArrayValue($hash_in, 'taxAmount'),
                        'lineItemTotal'        => self::returnArrayValue($hash_in, 'lineItemTotal'),
                        'lineItemTotalWithTax' => self::returnArrayValue($hash_in, 'lineItemTotalWithTax'),
                        'itemDiscountAmount'   => self::returnArrayValue($hash_in, 'itemDiscountAmount'),
                        'commodityCode'        => self::returnArrayValue($hash_in, 'commodityCode'),
                        'unitCost'             => self::returnArrayValue($hash_in, 'unitCost'),
                        'detailTax'            => (self::detailTax(self::returnArrayValue($hash_in, 'detailTax'))),
            ];

            return $hash_out;
        }
    }

    public static function enhancedData($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'customerReference'      => self::returnArrayValue($hash_in, 'customerReference'),
                        'salesTax'               => self::returnArrayValue($hash_in, 'salesTax'),
                        'deliveryType'           => self::returnArrayValue($hash_in, 'deliveryType'),
                        'taxExempt'              => self::returnArrayValue($hash_in, 'taxExempt'),
                        'discountAmount'         => self::returnArrayValue($hash_in, 'discountAmount'),
                        'shippingAmount'         => self::returnArrayValue($hash_in, 'shippingAmount'),
                        'dutyAmount'             => self::returnArrayValue($hash_in, 'dutyAmount'),
                        'shipFromPostalCode'     => self::returnArrayValue($hash_in, 'shipFromPostalCode'),
                        'destinationPostalCode'  => self::returnArrayValue($hash_in, 'destinationPostalCode'),
                        'destinationCountryCode' => self::returnArrayValue($hash_in, 'destinationCountryCode'),
                        'invoiceReferenceNumber' => self::returnArrayValue($hash_in, 'invoiceReferenceNumber'),
                        'orderDate'              => self::returnArrayValue($hash_in, 'orderDate'),
            ];
            foreach ($hash_in as $key => $value) {
                if ($key == 'lineItemData' && $key != null) {
                    $lineItem = [];
                    for ($j = 0; $j < count($value); $j++) {
                        $outIndex = ('lineItemData').(string) $j;
                        $hash_out[$outIndex] = self::lineItemData(self::returnArrayValue($value, $j));
                    }
                } elseif ($key == 'detailTax' & $key != null) {
                    $detailtax = [];
                    for ($j = 0; $j < count($value); $j++) {
                        $outIndex = ('detailTax').(string) $j;
                        $hash_out[$outIndex] = self::detailTax(self::returnArrayValue($value, $j));
                    }
                }
            }

            return $hash_out;
        }
    }

    public static function amexAggregatorData($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'sellerId'                   => self::returnArrayValue($hash_in, 'sellerId'),
                        'sellerMerchantCategoryCode' => self::returnArrayValue($hash_in, 'sellerMerchantCategoryCode'),
            ];

            return $hash_out;
        }
    }

    public static function cardType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'type'              => self::returnArrayValue($hash_in, 'type'),
                        'track'             => self::returnArrayValue($hash_in, 'track'),
                        'number'            => self::returnArrayValue($hash_in, 'number'),
                        'expDate'           => self::returnArrayValue($hash_in, 'expDate'),
                        'cardValidationNum' => self::returnArrayValue($hash_in, 'cardValidationNum'),
            ];

            return $hash_out;
        }
    }

    public static function cardTokenType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'litleToken'        => (Checker::requiredField(self::returnArrayValue($hash_in, 'litleToken'))),
                        'expDate'           => self::returnArrayValue($hash_in, 'expDate'),
                        'cardValidationNum' => self::returnArrayValue($hash_in, 'cardValidationNum'),
                        'type'              => self::returnArrayValue($hash_in, 'type'),
            ];

            return $hash_out;
        }
    }

    public static function cardPaypageType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'paypageRegistrationId' => (Checker::requiredField(self::returnArrayValue($hash_in, 'paypageRegistrationId'))),
                        'expDate'               => self::returnArrayValue($hash_in, 'expDate'),
                        'cardValidationNum'     => self::returnArrayValue($hash_in, 'cardValidationNum'),
                        'type'                  => self::returnArrayValue($hash_in, 'type'),
            ];

            return $hash_out;
        }
    }

    public static function paypal($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'payerId'       => (Checker::requiredField(self::returnArrayValue($hash_in, 'payerId'))),
                        'token'         => self::returnArrayValue($hash_in, 'token'),
                        'transactionId' => (Checker::requiredField(self::returnArrayValue($hash_in, 'transactionId'))),
            ];

            return $hash_out;
        }
    }

    #paypal field for credit transaction

    public static function credit_paypal($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'payerId'    => (Checker::requiredField(self::returnArrayValue($hash_in, 'payerId'))),
                        'payerEmail' => (Checker::requiredField(self::returnArrayValue($hash_in, 'payerEmail'))),
            ];

            return $hash_out;
        }
    }

    public static function customBilling($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'phone'      => self::returnArrayValue($hash_in, 'phone', 13),
                        'city'       => self::returnArrayValue($hash_in, 'city', 35),
                        'url'        => self::returnArrayValue($hash_in, 'url', 13),
                        'descriptor' => self::returnArrayValue($hash_in, 'descriptor', 25),
            ];

            return $hash_out;
        }
    }

    public static function taxBilling($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'taxAuthority' => (Checker::requiredField(self::returnArrayValue($hash_in, 'taxAuthority'))),
                        'state'        => (Checker::requiredField(self::returnArrayValue($hash_in, 'state'))),
                        'govtTxnType'  => (Checker::requiredField(self::returnArrayValue($hash_in, 'govtTxnType'))),
            ];

            return $hash_out;
        }
    }

    public static function processingInstructions($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'bypassVelocityCheck' => self::returnArrayValue($hash_in, 'bypassVelocityCheck'),
            ];

            return $hash_out;
        }
    }

    public static function echeckForTokenType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'accNum'     => (Checker::requiredField(self::returnArrayValue($hash_in, 'accNum'))),
                        'routingNum' => (Checker::requiredField(self::returnArrayValue($hash_in, 'routingNum'))),
            ];

            return $hash_out;
        }
    }

    public static function filteringType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'prepaid'       => self::returnArrayValue($hash_in, 'prepaid'),
                        'international' => self::returnArrayValue($hash_in, 'international'),
                        'chargeback'    => self::returnArrayValue($hash_in, 'chargeback'),
            ];

            return $hash_out;
        }
    }

    public static function echeckType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'accType'               => (Checker::requiredField(self::returnArrayValue($hash_in, 'accType'))),
                        'accNum'                => (Checker::requiredField(self::returnArrayValue($hash_in, 'accNum'))),
                        'routingNum'            => (Checker::requiredField(self::returnArrayValue($hash_in, 'routingNum'))),
                        'checkNum'              => self::returnArrayValue($hash_in, 'checkNum'),
                        'ccdPaymentInformation' => self::returnArrayValue($hash_in, 'ccdPaymentInformation'),

            ];

            return $hash_out;
        }
    }

    public static function echeckTokenType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'litleToken' => (Checker::requiredField(self::returnArrayValue($hash_in, 'litleToken'))),
                        'routingNum' => (Checker::requiredField(self::returnArrayValue($hash_in, 'routingNum'))),
                        'accType'    => (Checker::requiredField(self::returnArrayValue($hash_in, 'accType'))),
                        'checkNum'   => self::returnArrayValue($hash_in, 'checkNum'),
            ];

            return $hash_out;
        }
    }

    public static function recyclingRequestType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                        'recycleBy' => (Checker::requiredField(self::returnArrayValue($hash_in, 'recycleBy'))),
            ];

            return $hash_out;
        }
    }

    public static function recurringRequestType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                    'subscription' => (self::recurringSubscriptionType(self::returnArrayValue($hash_in, 'subscription'))),
            ];

            return $hash_out;
        }
    }

    public static function recurringSubscriptionType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                    'planCode'         => (Checker::requiredField(self::returnArrayValue($hash_in, 'planCode'))),
                    'numberOfPayments' => (self::returnArrayValue($hash_in, 'numberOfPayments')),
                    'startDate'        => (self::returnArrayValue($hash_in, 'startDate')),
                    'amount'           => (self::returnArrayValue($hash_in, 'amount')),
            ];

            return $hash_out;
        }
    }

    public static function litleInternalRecurringRequestType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                    'subscriptionId' => (Checker::requiredField(self::returnArrayValue($hash_in, 'subscriptionId'))),
                    'recurringTxnId' => (Checker::requiredField(self::returnArrayValue($hash_in, 'recurringTxnId'))),
            ];

            return $hash_out;
        }
    }

    public static function advancedFraudChecksType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                'threatMetrixSessionId' => (Checker::requiredField(self::returnArrayValue($hash_in, 'threatMetrixSessionId', 128))),
                'customAttribute1'      => (self::returnArrayValue($hash_in, 'customAttribute1')),
                'customAttribute2'      => (self::returnArrayValue($hash_in, 'customAttribute2')),
                'customAttribute3'      => (self::returnArrayValue($hash_in, 'customAttribute3')),
                'customAttribute4'      => (self::returnArrayValue($hash_in, 'customAttribute4')),
                'customAttribute5'      => (self::returnArrayValue($hash_in, 'customAttribute5')),
            ];

            return $hash_out;
        }
    }

    public static function mposType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
            'ksn'            => (Checker::requiredField(self::returnArrayValue($hash_in, 'ksn', 1028))),
            'formatId'       => (Checker::requiredField(self::returnArrayValue($hash_in, 'formatId', 1028))),
            'encryptedTrack' => (Checker::requiredField(self::returnArrayValue($hash_in, 'encryptedTrack', 1028))),
            'track1Status'   => (Checker::requiredField(self::returnArrayValue($hash_in, 'track1Status', 1028))),
            'track2Status'   => (Checker::requiredField(self::returnArrayValue($hash_in, 'track2Status', 1028))),
            ];

            return $hash_out;
        }
    }

    public static function applePayType($hash_in)
    {
        if (isset($hash_in)) {
            $hash_out = [
                    'data'      => (self::returnArrayValue($hash_in, 'data')),
                    'header'    => Checker::requiredField(self::returnArrayValue($hash_in, 'header')),
                    'signature' => self::returnArrayValue($hash_in, 'signature'),
                    'version'   => self::returnArrayValue($hash_in, 'version'),
            ];

            return $hash_out;
        }
    }
}
