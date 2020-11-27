<?php
/**
 * CheckBalanceExample.php.
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */
require './vendor/autoload.php';

use ferdhika31\iPaymuPHP\Balance;
use ferdhika31\iPaymuPHP\Exceptions\InvalidApiKeyException;
use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\iPaymu;

$config = [
    'env'               => 'SANDBOX',
    'virtual_account'   => 'your-virtual-account',
    'api_key'           => 'your-api-key',
];

try {
    iPaymu::init($config);

    $getBalance = Balance::getBalance();
    var_dump($getBalance);
} catch (InvalidApiKeyException $e) {
    echo $e->getMessage();
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
