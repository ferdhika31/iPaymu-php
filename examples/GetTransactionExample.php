<?php
/**
 * GetTransactionExample.php
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

require './vendor/autoload.php';

use ferdhika31\iPaymuPHP\iPaymu;
use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\Exceptions\InvalidApiKeyException;
use ferdhika31\iPaymuPHP\Transaction;

$config = [
    'env'               => 'SANDBOX',
    'virtual_account'   => 'your-virtual-account',
    'api_key'           => 'your-api-key'
];

try{
    iPaymu::init($config);
    $id = 27958;
    $getTrx = Transaction::getById($id);
    var_dump($getTrx);
}catch (InvalidApiKeyException $e){
    echo ($e->getMessage());
}catch (InvalidArgumentException $e){
    echo ($e->getMessage());
}