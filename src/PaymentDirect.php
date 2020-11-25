<?php
/**
 * PaymentDirect.php
 *
 * @package ferdhika31\iPaymuPHP
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP;

use ferdhika31\iPaymuPHP\Validations\PaymentDirectValidation;
use ferdhika31\iPaymuPHP\Traits\ApiOperations;
use ferdhika31\iPaymuPHP\Helpers\Arr;

class PaymentDirect
{
    use ApiOperations;

    private static $instance = null;
    private static array $payload=[];
    private static string $paymentMethod="";
    private static string $channel="";
    private static string $uri = '/api/v2/payment/direct';

    /**
     * @return string
     */
    public static function getPaymentMethod(): string
    {
        return self::$paymentMethod;
    }

    /**
     * @param string $paymentMethod
     */
    public static function setPaymentMethod(string $paymentMethod): void
    {
        self::$paymentMethod = $paymentMethod;
    }

    /**
     * @return string
     */
    public static function getChannel(): string
    {
        return self::$channel;
    }

    /**
     * @param string $channel
     */
    public static function setChannel(string $channel): void
    {
        self::$channel = $channel;
    }

    /**
     * @return array
     */
    public static function getPayload(): array
    {
        return self::$payload;
    }

    /**
     * @param array $payload
     */
    public static function setPayload(array $payload): void
    {
        self::$payload = $payload;
    }

    public static function VA(string $channel="cimb")
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('va');
        self::setChannel($channel);

        return new static();
    }

    public static function bankTransfer(string $channel="bca")
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('banktransfer');
        self::setChannel($channel);

        return new static();
    }

    public static function cStore(string $channel="indomaret")
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('cstore');
        self::setChannel($channel);

        return new static();
    }

    public static function cod(array $CODPayload=[], string $channel="rpx")
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        // maintenance
        // kudu nyieun heula
//
//        $payload = self::getPayload();
//
//        $payload['account'] = iPaymu::getVirtualAccount();
//        $payload['amount'] = 0;
//
//        $payload = Arr::merge($payload, $CODPayload);
//
//        self::setPayload($payload);
//
//        self::setPaymentMethod('cod');
//        self::setChannel($channel);

        return new static();
    }

    public static function QRIS(string $channel="linkaja")
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('qris');
        self::setChannel($channel);

        return new static();
    }

    public static function create(array $payloadTrx=[])
    {
        $payload = self::getPayload();

        $customer = iPaymu::getCustomer();
        if (!empty($customer)) {
            $payload = array_merge($customer, $payload);
        }

        $payload['notifyUrl'] = iPaymu::getNotifyUri();

        if (!empty($payloadTrx)) {
            $payload = Arr::merge($payload, $payloadTrx);
        }
        $paymentMethod = self::getPaymentMethod();
        $paymentChannel = self::getChannel();
        $payload['paymentMethod'] = $paymentMethod;
        $payload['paymentChannel'] = $paymentChannel;
        
        PaymentDirectValidation::validateField($payload);
        PaymentDirectValidation::validateChannel($paymentMethod, $paymentChannel);

        return self::_request('POST', self::$uri, $payload);
    }
}