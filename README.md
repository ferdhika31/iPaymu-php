iPaymu REST API Client PHP
==============

[iPaymu](https://ipaymu.com) API wrapper written in PHP for access from applications.

[![Build Status](https://travis-ci.org/ferdhika31/iPaymu-php.svg?branch=main)](https://travis-ci.org/ferdhika31/iPaymu-php)
[![StyleCI](https://github.styleci.io/repos/315871520/shield?branch=main)](https://github.styleci.io/repos/315871520)
[![Coverage Status](https://coveralls.io/repos/ferdhika31/iPaymu-php/badge.svg?branch=main&service=github)](https://coveralls.io/github/ferdhika31/iPaymu-php?branch=main)
[![Latest Stable Version](https://poser.pugx.org/ferdhika31/iPaymu-php/v/stable)](https://packagist.org/packages/ferdhika31/iPaymu-php)
[![Total Downloads](https://poser.pugx.org/ferdhika31/iPaymu-php/downloads)](https://packagist.org/packages/ferdhika31/iPaymu-php)
[![Latest Unstable Version](https://poser.pugx.org/ferdhika31/iPaymu-php/v/unstable)](https://packagist.org/packages/ferdhika31/iPaymu-php)
[![License](https://poser.pugx.org/ferdhika31/iPaymu-php/license)](https://packagist.org/packages/ferdhika31/iPaymu-php)

## Documentation

For the API documentation, please check [iPaymu API Documentation](https://ipaymu.com/en/api-documentation/).

## Installation

Install the package with [composer](https://getcomposer.org/) by following command:
```
composer require ferdhika31/ipaymu-php
```

## Usage

### Initialization
Configure package with your account's secret key obtained from iPaymu Dashboard. You can use [production](https://my.ipaymu.com/) or [sandbox](https://sandbox.ipaymu.com/) environment.

```php
<?php
use ferdhika31\iPaymuPHP\iPaymu;

$config = [
    'env'               => 'SANDBOX', // SANDBOX or PRODUCTION
    'virtual_account'   => 'your_virtual_account',
    'api_key'           => 'your_api_key',
    'notify_uri'        => 'http://localhost:8000/notify',
    // for redirect payment is required
    'cancel_uri'        => 'http://localhost:8000/cancel',
    'return_uri'        => 'http://localhost:8000/return'
];

iPaymu::init($config);
```
See [example codes](./examples) for more details.

### Get Balance
```php
<?php
use ferdhika31\iPaymuPHP\Balance;

$getBalance = Balance::getBalance();
```

### Set Customer
```php
<?php
$customer = [
    'name' => 'Dika',
    'email' => 'fer@dika.web.id',
    'phone' => '083213123332'
];
iPaymu::setCustomer($customer);
```

### Add Product
```php
<?php
iPaymu::addProduct([
    'name'          => 'Mangga',
    'qty'           => 2,
    'price'         => 2500,
    'description'   => 'Mangga cobian'
]);
iPaymu::addProduct([
    'name'          => 'Jeruk',
    'qty'           => 1,
    'price'         => 1500,
    'description'   => 'Jeruk haseum'
]);
```

### Create Redirect Payment
```php
<?php
use ferdhika31\iPaymuPHP\PaymentRedirect;

// optional
$payloadTrx = [
    'expired' => 1, // in hours
    'comments' => 'Transaction comment here',
    'referenceId' => 'TRX202008310001'
];

$redirectPayment = PaymentRedirect::create($payloadTrx);
```

### Create Redirect Payment with Payment Method
```php
<?php
use ferdhika31\iPaymuPHP\PaymentRedirect;

// optional
$payloadTrx = [
    'expired' => 1, // in hours
    'comments' => 'Transaction comment here',
    'referenceId' => 'TRX202008310001'
];

$redirectPayment = PaymentRedirect::mandiriVA()->create($payloadTrx);
$redirectPayment = PaymentRedirect::niagaVA()->create($payloadTrx);
$redirectPayment = PaymentRedirect::BNIVA()->create($payloadTrx);
$redirectPayment = PaymentRedirect::BAGVA()->create($payloadTrx);
$redirectPayment = PaymentRedirect::BCATransfer()->create($payloadTrx);
$redirectPayment = PaymentRedirect::QRIS()->create($payloadTrx);
$redirectPayment = PaymentRedirect::CStore()->create($payloadTrx);
$redirectPayment = PaymentRedirect::creditCard()->create($payloadTrx);
$redirectPayment = PaymentRedirect::COD()->create($payloadTrx);
$redirectPayment = PaymentRedirect::akulaku()->create($payloadTrx);
```

### Create Direct Payment
```php
<?php
use ferdhika31\iPaymuPHP\PaymentDirect;

$payloadTrx = [
    'amount' => 5000,
    // optional
    'expired' => 10,
    'expiredType' => 'minutes', // in:seconds,minutes,hours,days
    'comments' => 'Transaction comment here',
    'referenceId' => 'TRX202008310001'
];

// Available channel Virtual Account : bag, bni, cimb (default), mandiri
$channel = 'mandiri';
$directPayment = PaymentDirect::VA($channel)->create($payloadTrx);

// Available channel Transfer Bank : bca (default)
$channel = 'bca';
$directPayment = PaymentDirect::bankTransfer($channel)->create($payloadTrx);

// Available channel Convenience Store : indomaret (default), alfamart
$channel = 'alfamart';
$directPayment = PaymentDirect::cStore($channel)->create($payloadTrx);

// Available channel: linkaja (default)
$channel = 'linkaja';
$directPayment = PaymentDirect::QRIS($channel)->create($payloadTrx);
```

### Get Transaction Detail
```php
<?php
use ferdhika31\iPaymuPHP\Transaction;

$id = 27958;
$getTrx = Transaction::getById($id);
```

## Running

### Running test suite:

```bash
vendor\bin\phpunit tests
vendor\bin\phpunit tests\BalanceTest.php
```

### Running examples:

```bash
php examples\CheckBalanceExample.php
```

## Contributing

For any requests, bugs, or comments, please open an [issue](https://github.com/ferdhika31/iPaymu-php/issues) or [submit a pull request](https://github.com/ferdhika31/iPaymu-php/pulls).