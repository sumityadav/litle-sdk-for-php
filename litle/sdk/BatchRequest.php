<?php

namespace litle\sdk;

class BatchRequest
{
    private $counts_and_amounts;
    public $total_txns = 0;
    public $closed = false;

    // file name which holds the transaction markups during the batch process
    public $transaction_file;
    public $batch_file;

    public function isFull()
    {
        return $this->total_txns >= MAX_TXNS_PER_BATCH;
    }

    public function __construct($request_dir = null)
    {
        // initialize the counts and amounts
        $this->counts_and_amounts =  [
                'auth' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'sale' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'credit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'tokenRegistration' =>  [
                        'count' => 0,
                ],
                'captureGivenAuth' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'forceCapture' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'authReversal' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'capture' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'echeckVerification' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'echeckCredit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'echeckRedeposit' =>  [
                        'count' => 0,
                ],
                'echeckSale' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'updateCardValidationNumOnToken' =>  [
                        'count' => 0,
                ],
                'updateSubscription' =>  [
                        'count' => 0,
                ],
                'cancelSubscription' =>  [
                        'count' => 0,
                ],
                'createPlan' =>  [
                        'count' => 0,
                ],
                'updatePlan' =>  [
                        'count' => 0,
                ],
                'activate' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'deactivate' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'load' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'unload' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'balanceInquiry' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'accountUpdate' =>  [
                        'count' => 0,
                ],
                'echeckPreNoteSale' =>  [
                        'count' => 0,
                ],
                'echeckPreNoteCredit' =>  [
                        'count' => 0,
                ],
                'submerchantCredit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'payFacCredit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'reserveCredit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'vendorCredit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'physicalCheckCredit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'submerchantDebit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'payFacDebit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'reserveDebit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'vendorDebit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
                'physicalCheckDebit' =>  [
                        'count'  => 0,
                        'amount' => 0,
                ],
        ];

        // if a dir to place the request file is not explicitly provided, grab it from the config file
        if (!$request_dir) {
            $conf = Obj2xml::getConfig( []);
            $request_dir = $conf ['batch_requests_path'];
        }

        if (substr($request_dir, -1, 1) != DIRECTORY_SEPARATOR) {
            $request_dir = $request_dir.DIRECTORY_SEPARATOR;
        }

        $ts = str_replace(' ', '', substr(microtime(), 2));
        $filename = $request_dir.'batch_'.$ts.'_txns';
        $batch_filename = $request_dir.'batch_'.$ts;

        // if either file already exists, let's try again!
        if (file_exists($filename) || file_exists($batch_filename)) {
            $this->__construct();
        }

        // if we were unable to write the file
        if (file_put_contents($filename, '') === false) {
            throw new \RuntimeException("A batch file could not be written at $filename. Please check your privilege.");
        }
        $this->transaction_file = $filename;

        // if we were unable to write the file
        if (file_put_contents($batch_filename, '') === false) {
            throw new \RuntimeException("A batch file could not be written at $batch_filename. Please check your privilege.");
        }
        $this->batch_file = $batch_filename;
    }

    /*
     * Extracts the appropriate values from the hash in and passes them along to the addTransaction function
     */

    public function addSale($hash_in)
    {
        $hash_out = Transactions::createSaleHash($hash_in);

        $choice_hash =  [
                $hash_out ['card'],
                $hash_out ['paypal'],
                $hash_out ['token'],
                $hash_out ['paypage'],
        ];
        $choice2_hash =  [
                $hash_out ['fraudCheck'],
                $hash_out ['cardholderAuthentication'],
        ];

        $this->addTransaction($hash_out, $hash_in, 'sale', $choice_hash, $choice2_hash);
        $this->counts_and_amounts ['sale'] ['count'] += 1;
        $this->counts_and_amounts ['sale'] ['amount'] += $hash_out ['amount'];
    }

    public function addAuth($hash_in)
    {
        $hash_out = Transactions::createAuthHash($hash_in);

        $choice_hash =  [
                XmlFields::returnArrayValue($hash_out, 'card'),
                XmlFields::returnArrayValue($hash_out, 'paypal'),
                XmlFields::returnArrayValue($hash_out, 'token'),
                XmlFields::returnArrayValue($hash_out, 'paypage'),
        ];

        $this->addTransaction($hash_out, $hash_in, 'authorization', $choice_hash);
        $this->counts_and_amounts ['auth'] ['count'] += 1;
        $this->counts_and_amounts ['auth'] ['amount'] += $hash_out ['amount'];
    }

    public function addAuthReversal($hash_in)
    {
        $hash_out = Transactions::createAuthReversalHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'authReversal');
        $this->counts_and_amounts ['authReversal'] ['count'] += 1;
        $this->counts_and_amounts ['authReversal'] ['amount'] += $hash_out ['amount'];
    }

    public function addCredit($hash_in)
    {
        $hash_out = Transactions::createCreditHash($hash_in);

        $choice_hash =  [
                $hash_out ['card'],
                $hash_out ['paypal'],
                $hash_out ['token'],
                $hash_out ['paypage'],
        ];

        $this->addTransaction($hash_out, $hash_in, 'credit', $choice_hash);
        $this->counts_and_amounts ['credit'] ['count'] += 1;
        $this->counts_and_amounts ['credit'] ['amount'] += $hash_out ['amount'];
    }

    public function addRegisterToken($hash_in)
    {
        $hash_out = Transactions::createRegisterTokenHash($hash_in);

        $choice_hash =  [
                $hash_out ['accountNumber'],
                $hash_out ['echeckForToken'],
                $hash_out ['paypageRegistrationId'],
        ];

        $this->addTransaction($hash_out, $hash_in, 'registerTokenRequest', $choice_hash);
        $this->counts_and_amounts ['tokenRegistration'] ['count'] += 1;
    }

    public function addForceCapture($hash_in)
    {
        $hash_out = Transactions::createForceCaptureHash($hash_in);

        $choice_hash =  [
                XmlFields::returnArrayValue($hash_out, 'card'),
                XmlFields::returnArrayValue($hash_out, 'paypal'),
                XmlFields::returnArrayValue($hash_out, 'token'),
                XmlFields::returnArrayValue($hash_out, 'paypage'),
        ];

        $this->addTransaction($hash_out, $hash_in, 'forceCapture', $choice_hash);
        $this->counts_and_amounts ['forceCapture'] ['count'] += 1;
        $this->counts_and_amounts ['forceCapture'] ['amount'] += $hash_out ['amount'];
    }

    public function addCapture($hash_in)
    {
        $hash_out = Transactions::createCaptureHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'capture');
        $this->counts_and_amounts ['capture'] ['count'] += 1;
        $this->counts_and_amounts ['capture'] ['amount'] += $hash_out ['amount'];
    }

    public function addCaptureGivenAuth($hash_in)
    {
        $hash_out = Transactions::createCaptureGivenAuthHash($hash_in);

        $choice_hash =  [
                $hash_out ['card'],
                $hash_out ['token'],
                $hash_out ['paypage'],
        ];

        $this->addTransaction($hash_out, $hash_in, 'captureGivenAuth', $choice_hash);
        $this->counts_and_amounts ['captureGivenAuth'] ['count'] += 1;
        $this->counts_and_amounts ['captureGivenAuth'] ['amount'] += $hash_out ['amount'];
    }

    public function addEcheckRedeposit($hash_in)
    {
        $hash_out = Transactions::createEcheckRedepositHash($hash_in);

        $choice_hash =  [
                $hash_out ['echeck'],
                $hash_out ['echeckToken'],
        ];

        $this->addTransaction($hash_out, $hash_in, 'echeckRedeposit', $choice_hash);
        $this->counts_and_amounts ['echeckRedeposit'] ['count'] += 1;
    }

    public function addEcheckSale($hash_in)
    {
        $hash_out = Transactions::createEcheckSaleHash($hash_in);

        $choice_hash =  [
                $hash_out ['echeck'],
                $hash_out ['echeckToken'],
        ];

        $this->addTransaction($hash_out, $hash_in, 'echeckSale', $choice_hash);
        $this->counts_and_amounts ['echeckSale'] ['count'] += 1;
        $this->counts_and_amounts ['echeckSale'] ['amount'] += $hash_out ['amount'];
    }

    public function addEcheckCredit($hash_in)
    {
        $hash_out = Transactions::createEcheckCreditHash($hash_in);

        $choice_hash =  [
                $hash_out ['echeck'],
                $hash_out ['echeckToken'],
        ];

        $this->addTransaction($hash_out, $hash_in, 'echeckCredit', $choice_hash);
        $this->counts_and_amounts ['echeckCredit'] ['count'] += 1;
        $this->counts_and_amounts ['echeckCredit'] ['amount'] += $hash_out ['amount'];
    }

    public function addEcheckVerification($hash_in)
    {
        $hash_out = Transactions::createEcheckVerificationHash($hash_in);

        $choice_hash =  [
                $hash_out ['echeck'],
                $hash_out ['echeckToken'],
        ];

        $this->addTransaction($hash_out, $hash_in, 'echeckVerification', $choice_hash);
        $this->counts_and_amounts ['echeckVerification'] ['count'] += 1;
        $this->counts_and_amounts ['echeckVerification'] ['amount'] += $hash_out ['amount'];
    }

    public function addUpdateCardValidationNumOnToken($hash_in)
    {
        $hash_out = Transactions::createUpdateCardValidationNumOnTokenHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'updateCardValidationNumOnToken');
        $this->counts_and_amounts ['updateCardValidationNumOnToken'] ['count'] += 1;
    }

    public function addUpdateSubscription($hash_in)
    {
        $hash_out = Transactions::createUpdateSubscriptionHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'updateSubscription');
        $this->counts_and_amounts ['updateSubscription'] ['count'] += 1;
    }

    public function addCancelSubscription($hash_in)
    {
        $hash_out = Transactions::createCancelSubscriptionHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'cancelSubscription');
        $this->counts_and_amounts ['cancelSubscription'] ['count'] += 1;
    }

    public function addCreatePlan($hash_in)
    {
        $hash_out = Transactions::createCreatePlanHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'createPlan');
        $this->counts_and_amounts ['createPlan'] ['count'] += 1;
    }

    public function addUpdatePlan($hash_in)
    {
        $hash_out = Transactions::createUpdatePlanHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'updatePlan');
        $this->counts_and_amounts ['updatePlan'] ['count'] += 1;
    }

    public function addActivate($hash_in)
    {
        $hash_out = Transactions::createActivateHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'activate');
        $this->counts_and_amounts ['activate'] ['count'] += 1;
        $this->counts_and_amounts ['activate'] ['amount'] += $hash_out ['amount'];
    }

    public function addDeactivate($hash_in)
    {
        $hash_out = Transactions::createDeactivateHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'deactivate');
        $this->counts_and_amounts ['deactivate'] ['count'] += 1;
    }

    public function addLoad($hash_in)
    {
        $hash_out = Transactions::createLoadHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'load');
        $this->counts_and_amounts ['load'] ['count'] += 1;
        $this->counts_and_amounts ['load'] ['amount'] += $hash_out ['amount'];
    }

    public function addUnload($hash_in)
    {
        $hash_out = Transactions::createUnloadHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'unload');
        $this->counts_and_amounts ['unload'] ['count'] += 1;
        $this->counts_and_amounts ['unload'] ['amount'] += $hash_out ['amount'];
    }

    public function addBalanceInquiry($hash_in)
    {
        $hash_out = Transactions::createBalanceInquiryHash($hash_in);

        $this->addTransaction($hash_out, $hash_in, 'balanceInquiry');
        $this->counts_and_amounts ['balanceInquiry'] ['count'] += 1;
    }

    public function addAccountUpdate($hash_in)
    {
        $hash_out = Transactions::createAccountUpdate($hash_in);

        $choice_hash =  [
                XmlFields::returnArrayValue($hash_out, 'card'),
                XmlFields::returnArrayValue($hash_out, 'token'),
        ];

        $this->addTransaction($hash_out, $hash_in, 'accountUpdate', $choice_hash);
        $this->counts_and_amounts ['accountUpdate'] ['count'] += 1;
    }

    public function addEcheckPreNoteSale($hash_in)
    {
        $hash_out = Transactions::createEcheckPreNoteSaleHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'echeckPreNoteSale');
        $this->counts_and_amounts ['echeckPreNoteSale'] ['count'] += 1;
    }

    public function addEcheckPreNoteCredit($hash_in)
    {
        $hash_out = Transactions::createEcheckPreNoteCreditHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'echeckPreNoteCredit');
        $this->counts_and_amounts ['echeckPreNoteCredit'] ['count'] += 1;
    }

    public function addSubmerchantCredit($hash_in)
    {
        $hash_out = Transactions::createSubmerchantCreditHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'submerchantCredit');
        $this->counts_and_amounts ['submerchantCredit'] ['count'] += 1;
        $this->counts_and_amounts ['submerchantCredit'] ['amount'] += $hash_out ['amount'];
    }

    public function addPayFacCredit($hash_in)
    {
        $hash_out = Transactions::createPayFacCreditHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'payFacCredit');
        $this->counts_and_amounts ['payFacCredit'] ['count'] += 1;
        $this->counts_and_amounts ['payFacCredit'] ['amount'] += $hash_out ['amount'];
    }

    public function addReserveCredit($hash_in)
    {
        $hash_out = Transactions::createReserveCreditHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'reserveCredit');
        $this->counts_and_amounts ['reserveCredit'] ['count'] += 1;
        $this->counts_and_amounts ['reserveCredit'] ['amount'] += $hash_out ['amount'];
    }

    public function addVendorCredit($hash_in)
    {
        $hash_out = Transactions::createVendorCreditHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'vendorCredit');
        $this->counts_and_amounts ['vendorCredit'] ['count'] += 1;
        $this->counts_and_amounts ['vendorCredit'] ['amount'] += $hash_out ['amount'];
    }

    public function addPhysicalCheckCredit($hash_in)
    {
        $hash_out = Transactions::createPhysicalCheckCreditHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'physicalCheckCredit');
        $this->counts_and_amounts ['physicalCheckCredit'] ['count'] += 1;
        $this->counts_and_amounts ['physicalCheckCredit'] ['amount'] += $hash_out ['amount'];
    }

    public function addSubmerchantDebit($hash_in)
    {
        $hash_out = Transactions::createSubmerchantDebitHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'submerchantDebit');
        $this->counts_and_amounts ['submerchantDebit'] ['count'] += 1;
        $this->counts_and_amounts ['submerchantDebit'] ['amount'] += $hash_out ['amount'];
    }

    public function addPayFacDebit($hash_in)
    {
        $hash_out = Transactions::createPayFacDebitHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'payFacDebit');
        $this->counts_and_amounts ['payFacDebit'] ['count'] += 1;
        $this->counts_and_amounts ['payFacDebit'] ['amount'] += $hash_out ['amount'];
    }

    public function addReserveDebit($hash_in)
    {
        $hash_out = Transactions::createReserveDebitHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'reserveDebit');
        $this->counts_and_amounts ['reserveDebit'] ['count'] += 1;
        $this->counts_and_amounts ['reserveDebit'] ['amount'] += $hash_out ['amount'];
    }

    public function addVendorDebit($hash_in)
    {
        $hash_out = Transactions::createVendorDebitHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'vendorDebit');
        $this->counts_and_amounts ['vendorDebit'] ['count'] += 1;
        $this->counts_and_amounts ['vendorDebit'] ['amount'] += $hash_out ['amount'];
    }

    public function addPhysicalCheckDebit($hash_in)
    {
        $hash_out = Transactions::createPhysicalCheckDebitHash($hash_in);
        $this->addTransaction($hash_out, $hash_in, 'physicalCheckDebit');
        $this->counts_and_amounts ['physicalCheckDebit'] ['count'] += 1;
        $this->counts_and_amounts ['physicalCheckDebit'] ['amount'] += $hash_out ['amount'];
    }

    /*
     * Adds the XML for the transaction given the appropriate data to the transactions file
     */

    private function addTransaction($hash_out, $hash_in, $type, $choice1 = null, $choice2 = null)
    {
        if ($this->closed) {
            throw new \RuntimeException('Could not add the transaction. This batchRequest is closed.');
        }
        if ($this->isFull()) {
            throw new \RuntimeException('The transaction could not be added to the batch. It is full.');
        }
        if ($type == 'accountUpdate' && $this->counts_and_amounts ['accountUpdate'] ['count'] != $this->total_txns) {
            throw new \RuntimeException("The transaction could not be added to the batch. The transaction type $type cannot be mixed with non-Account Updates.");
        } elseif ($type != 'accountUpdate' && $this->counts_and_amounts ['accountUpdate'] ['count'] == $this->total_txns && $this->total_txns > 0) {
            throw new \RuntimeException("The transaction could not be added to the batch. The transaction type $type cannot be mixed with AccountUpdates.");
        }

        if (isset($hash_in ['reportGroup'])) {
            $report_group = $hash_in ['reportGroup'];
        } else {
            $conf = Obj2xml::getConfig( []);
            $report_group = $conf ['reportGroup'];
        }

        Checker::choice($choice1);
        Checker::choice($choice2);

        $request = Obj2xml::transactionToXml($hash_out, $type, $report_group);

        if (file_put_contents($this->transaction_file, $request, FILE_APPEND) === false) {
            throw new \RuntimeException("A transaction could not be written to the batch file at $this->transaction_file. Please check your privilege.");
        }

        $this->total_txns += 1;
    }

    /*
     * When no more transactions are to be added, the transactions file can be amended with the XML tags for the counts
     * and amounts of the batch request. Returns the filename of the complete batchrequest file
     */

    public function closeRequest()
    {
        $handle = @fopen($this->transaction_file, 'r');
        if ($handle) {
            file_put_contents($this->batch_file, Obj2xml::generateBatchHeader($this->counts_and_amounts), FILE_APPEND);
            while (($buffer = fgets($handle, 4096)) !== false) {
                file_put_contents($this->batch_file, $buffer, FILE_APPEND);
            }
            if (!feof($handle)) {
                throw new \RuntimeException("Error when reading transactions file at $this->transaction_file. Please check your privilege.");
            }
            fclose($handle);
            file_put_contents($this->batch_file, '</batchRequest>', FILE_APPEND);

            unlink($this->transaction_file);
            unset($this->transaction_file);
            $this->closed = true;
        } else {
            throw new \RuntimeException("Could not open transactions file at $this->transaction_file. Please check your privilege.");
        }
    }

    public function getCountsAndAmounts()
    {
        return $this->counts_and_amounts;
    }
}
