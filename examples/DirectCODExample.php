<?php
/**
 * DirectCODExample.php
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

    iPaymu::addProduct([
        'name'      => 'Mangga',
        'qty'       => 2,
        'price'     => 2500,
        'weight'    => 2, // in kilogram
        'length'    => 10, // in cm
        'width'     => 20, // in cm
        'height'    => 20 // in cm
    ]);

    $payloadTrx = [
        'amount' => 5000,
        // optional
        'expired' => 10,
        'expiredType' => 'minutes', // in:seconds,minutes,hours,days
        'description' => 'Description comment here',
        'referenceId' => 'TRX202008310001'
    ];

    $payloadCOD = [
        'deliveryArea' => '40391',
        'deliveryAddress' => 'Lembang',
        // optional
        'pickupArea' => '40391',
        'pickupAddress' => 'Lembang',
        'splitCount' => 1
    ];
    $directPayment = PaymentDirect::COD($payloadCOD)->create($payloadTrx);
    var_dump($directPayment);
}catch (InvalidApiKeyException $e){
    echo ($e->getMessage());
}catch (InvalidArgumentException $e){
    echo ($e->getMessage());
}