<?php
/**
 * PaymentRedirectTest.php
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

use ferdhika31\iPaymuPHP\iPaymu;
use ferdhika31\iPaymuPHP\PaymentRedirect;
use PHPUnit\Framework\TestCase;

class PaymentRedirectTest extends TestCase
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
            'cancel_uri'        => 'http://localhost:8000/cancel',
            'return_uri'        => 'http://localhost:8000/return'
        ];

        iPaymu::init($config);

        iPaymu::addProduct([
            'name'          => 'Mangga',
            'qty'           => 3,
            'price'         => 2500,
            'description'   => 'Mangga cobian'
        ]);
    }

    public function testRedirectPayment()
    {
        self::initConfig();

        // optional
        $payloadTrx = [
            'expired' => 1, // in hours
            'comments' => 'Transaction comment here',
            'referenceId' => 'TRX202008310001'
        ];
        $response = PaymentRedirect::create($payloadTrx);

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }

    public function testRedirectPaymentVAMandiri()
    {
        self::initConfig();

        $response = PaymentRedirect::mandiriVA()->create();

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }

    public function testRedirectPaymentVACIMB()
    {
        self::initConfig();

        $response = PaymentRedirect::niagaVA()->create(['comments' => 'Transaction comment here']);

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }

    public function testRedirectPaymentVABNI()
    {
        self::initConfig();

        $response = PaymentRedirect::BNIVA()->create(['comments' => 'Transaction comment here']);

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }

    public function testRedirectPaymentVABAG()
    {
        self::initConfig();

        $response = PaymentRedirect::BAGVA()->create(['comments' => 'Transaction comment here']);

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }

    public function testRedirectPaymentTransferBCA()
    {
        self::initConfig();

        $response = PaymentRedirect::BCATransfer()->create(['comments' => 'Transaction comment here']);

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }

    public function testRedirectPaymentQRIS()
    {
        self::initConfig();

        $response = PaymentRedirect::QRIS()->create(['comments' => 'Transaction comment here']);

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }

    public function testRedirectPaymentCStore()
    {
        self::initConfig();

        $response = PaymentRedirect::CStore()->create(['comments' => 'Transaction comment here']);

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }

    public function testRedirectPaymentCreditCard()
    {
        self::initConfig();

        $response = PaymentRedirect::creditCard()->create(['comments' => 'Transaction comment here']);

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }

    public function testRedirectPaymentCOD()
    {
        self::initConfig();

        $response = PaymentRedirect::COD()->create(['comments' => 'Transaction comment here']);

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }

    public function testRedirectPaymentAkulaku()
    {
        self::initConfig();

        $response = PaymentRedirect::akulaku()->create(['comments' => 'Transaction comment here']);

        $this->assertEquals(self::RESPONSE_CODE, $response->Status);
    }
}
