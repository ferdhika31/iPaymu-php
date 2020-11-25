iPaymu REST API Client PHP
==============

[iPaymu](https://ipaymu.com) API wrapper written in PHP for access from applications.

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