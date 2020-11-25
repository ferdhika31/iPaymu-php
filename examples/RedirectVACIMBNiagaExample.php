<?php
/**
 * RedirectVACIMBNiagaExample.php
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

require './vendor/autoload.php';

use ferdhika31\iPaymuPHP\iPaymu;
use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\Exceptions\InvalidApiKeyException;
use ferdhika31\iPaymuPHP\PaymentRedirect;

$config = [
    'env'               => 'SANDBOX',
    'virtual_account'   => 'your_virtual_account',
    'api_key'           => 'your_api_key',
    'notify_uri'        => 'http://localhost:8000/notify',
    'cancel_uri'        => 'http://localhost:8000/cancel',
    'return_uri'        => 'http://localhost:8000/return'
];

try{
    iPaymu::init($config);

    // optional
    $customer = [
        'name' => 'Dika',
        'email' => 'fer@dika.web.id',
        'phone' => '083213123332'
    ];
    iPaymu::setCustomer($customer);

    $products = [
        [
            'name'          => 'Mangga',
            'qty'           => 2,
            'price'         => 2500,
            'description'   => 'Mangga cobian'
        ],
        [
            'name'          => 'Jeruk',
            'qty'           => 1,
            'price'         => 5000,
            'description'   => 'Jeruk asem'
        ]
    ];
    foreach ($products as $product){
        iPaymu::addProduct($product);
    }

    // optional
    $payloadTrx = [
        'expired' => 5, // in hours
        'comments' => 'Transaction comment here',
        'referenceId' => 'TRX202008310001'
    ];

    $redirectPayment = PaymentRedirect::niagaVA()->create($payloadTrx);
    var_dump($redirectPayment);
}catch (InvalidApiKeyException $e){
    echo ($e->getMessage());
}catch (InvalidArgumentException $e){
    echo ($e->getMessage());
}