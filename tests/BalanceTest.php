<?php
/**
 * BalanceTest.php
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

use ferdhika31\iPaymuPHP\iPaymu;
use ferdhika31\iPaymuPHP\Balance;
use PHPUnit\Framework\TestCase;

class BalanceTest extends TestCase
{
    public function testCheckBalance()
    {
        $config = [
            'env'               => 'SANDBOX',
            'virtual_account'   => $_SERVER['VIRTUAL_ACCOUNT'],
            'api_key'           => $_SERVER['API_KEY']
        ];

        iPaymu::init($config);

        $response = Balance::getBalance();

        $this->assertObjectHasAttribute('Saldo', $response);
    }
}
