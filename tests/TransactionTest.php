<?php
/**
 * TransactionTest.php.
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

use ferdhika31\iPaymuPHP\iPaymu;
use ferdhika31\iPaymuPHP\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testGetDetail()
    {
        $config = [
            'env'               => 'SANDBOX',
            'virtual_account'   => $_SERVER['VIRTUAL_ACCOUNT'],
            'api_key'           => $_SERVER['API_KEY'],
        ];

        iPaymu::init($config);

        $id = 28197;
        $response = Transaction::getById($id);

        $this->assertObjectHasAttribute('Channel', $response);
    }
}
