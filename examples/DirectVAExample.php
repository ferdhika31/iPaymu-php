<?php
/**
 * DirectVAExample.php
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

require './vendor/autoload.php';

use ferdhika31\iPaymuPHP\iPaymu;
use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\Exceptions\InvalidApiKeyException;
use ferdhika31\iPaymuPHP\PaymentDirect;

$config = [
    'env'               => 'SANDBOX',
    'virtual_account'   => 'your_virtual_account',
    'api_key'           => 'your_api_key',
    'notify_uri'        => 'http://localhost:8000/notify',
];

try{
    iPaymu::init($config);

    $customer = [
        'name' => 'Dika',
        'email' => 'fer@dika.web.id',
        'phone' => '083213123332'
    ];
    iPaymu::setCustomer($customer);


    $payloadTrx = [
        'amount' => 5000,
        // optional
        'expired' => 10,
        'expiredType' => 'minutes', // in:seconds,minutes,hours,days
        'comments' => 'Transaction comment here',
        'referenceId' => 'TRX202008310001'
    ];

    // Available channel: bag, bni, cimb (default), mandiri
    $channel = 'mandiri';
    $directPayment = PaymentDirect::VA($channel)->create($payloadTrx);
    var_dump($directPayment);
}catch (InvalidApiKeyException $e){
    echo ($e->getMessage());
}catch (InvalidArgumentException $e){
    echo ($e->getMessage());
}