<?php
/**
 * PaymentDirectTest.php.
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\iPaymu;
use ferdhika31\iPaymuPHP\PaymentDirect;
use PHPUnit\Framework\TestCase;

class PaymentDirectTest extends TestCase
{
    const RESPONSE_CODE = 200;
    const ERROR_CODE = 400;

    private static function initConfig()
    {
        $config = [
            'env'               => 'SANDBOX',
            'virtual_account'   => $_SERVER['VIRTUAL_ACCOUNT'],
            'api_key'           => $_SERVER['API_KEY'],
            'notify_uri'        => 'http://localhost:8000/notify',
        ];

        iPaymu::init($config);

        $customer = [
            'name'  => 'Dika',
            'email' => 'fer@dika.web.id',
            'phone' => '083213123332',
        ];
        iPaymu::setCustomer($customer);
    }

    public function testDirectPaymentVA()
    {
        self::initConfig();

        $payloadTrx = [
            'amount' => 5000,
            // optional
            'expired'     => 10,
            'expiredType' => 'minutes', // in:seconds,minutes,hours,days
            'comments'    => 'Transaction comment here',
            'referenceId' => 'TRX202008310001',
        ];

        // Available channel: bag, bni, cimb (default), mandiri
        $response = PaymentDirect::VA('mandiri')->create($payloadTrx);
        $this->assertEquals(self::RESPONSE_CODE, $response->Status);

        $response = PaymentDirect::VA()->create($payloadTrx);
        $this->assertEquals(self::RESPONSE_CODE, $response->Status);

        $this->expectException(InvalidArgumentException::class);
        PaymentDirect::VA('dika')->create($payloadTrx);
    }

    public function testDirectPaymentTransferBank()
    {
        self::initConfig();

        $payloadTrx = [
            'amount' => 5000,
            // optional
            'expired'     => 10,
            'expiredType' => 'minutes', // in:seconds,minutes,hours,days
            'comments'    => 'Transaction comment here',
            'referenceId' => 'TRX202008310001',
        ];

        // Available channel: bca (default)
        $response = PaymentDirect::bankTransfer('bca')->create($payloadTrx);
        $this->assertEquals(self::RESPONSE_CODE, $response->Status);

        $response = PaymentDirect::bankTransfer()->create($payloadTrx);
        $this->assertEquals(self::RESPONSE_CODE, $response->Status);

        $this->expectException(InvalidArgumentException::class);
        PaymentDirect::bankTransfer('dika')->create($payloadTrx);
    }

    public function testDirectPaymentQRIS()
    {
        self::initConfig();

        $payloadTrx = [
            'amount' => 5000,
            // optional
            'expired'     => 10,
            'expiredType' => 'minutes', // in:seconds,minutes,hours,days
            'comments'    => 'Transaction comment here',
            'referenceId' => 'TRX202008310001',
        ];

        // Available channel: linkaja (default)
        $response = PaymentDirect::QRIS('linkaja')->create($payloadTrx);
        $this->assertEquals(self::RESPONSE_CODE, $response->Status);

        $response = PaymentDirect::QRIS()->create($payloadTrx);
        $this->assertEquals(self::RESPONSE_CODE, $response->Status);

        $this->expectException(InvalidArgumentException::class);
        PaymentDirect::QRIS('dika')->create($payloadTrx);
    }

    public function testDirectPaymentCStore()
    {
        self::initConfig();

        $payloadTrx = [
            'amount' => 5000,
            // optional
            'expired'     => 10,
            'expiredType' => 'minutes', // in:seconds,minutes,hours,days
            'comments'    => 'Transaction comment here',
            'referenceId' => 'TRX202008310001',
        ];

        // Available channel: indomaret (default), alfamart
        $response = PaymentDirect::cStore('alfamart')->create($payloadTrx);
        $this->assertEquals(self::RESPONSE_CODE, $response->Status);

        $response = PaymentDirect::cStore()->create($payloadTrx);
        $this->assertEquals(self::RESPONSE_CODE, $response->Status);

        $this->expectException(InvalidArgumentException::class);
        PaymentDirect::cStore('dika')->create($payloadTrx);
    }
}
