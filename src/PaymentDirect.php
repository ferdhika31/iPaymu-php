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

    /**
     * @var null
     */
    private static $instance = null;

    /**
     * @var array
     */
    private static array $payload=[];

    /**
     * @var string
     */
    private static string $paymentMethod="";

    /**
     * @var string
     */
    private static string $channel="";

    /**
     * @var string
     */
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
    private static function setPaymentMethod(string $paymentMethod): void
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
    private static function setChannel(string $channel): void
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
    private static function setPayload(array $payload): void
    {
        self::$payload = $payload;
    }

    /**
     * @param string $channel
     * @return static
     */
    public static function VA(string $channel="cimb")
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('va');
        self::setChannel($channel);

        return new static();
    }

    /**
     * @param string $channel
     * @return static
     */
    public static function bankTransfer(string $channel="bca")
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('banktransfer');
        self::setChannel($channel);

        return new static();
    }

    /**
     * @param string $channel
     * @return static
     */
    public static function cStore(string $channel="indomaret")
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('cstore');
        self::setChannel($channel);

        return new static();
    }

    /**
     * @param array $CODPayload
     * @param string $channel
     * @return static
     */
    public static function cod(array $CODPayload=[], string $channel="rpx")
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        $products = iPaymu::getProducts();
        PaymentDirectValidation::validateProducts($products);

        $payload = self::getPayload();
        $payload['account'] = iPaymu::getVirtualAccount();
        $payload['product'] = Arr::pluck($products, 'name');
        $payload['qty'] = Arr::pluck($products, 'qty');
        $payload['price'] = Arr::pluck($products, 'price');
        $payload['weight'] = Arr::pluck($products, 'weight');
        $payload['length'] = Arr::pluck($products, 'length');
        $payload['width'] = Arr::pluck($products, 'width');
        $payload['height'] = Arr::pluck($products, 'height');
        $payload = Arr::merge($payload, $CODPayload);
        self::setPayload($payload);
        self::setPaymentMethod('cod');
        self::setChannel($channel);

        return new static();
    }

    /**
     * @param string $channel
     * @return static
     */
    public static function QRIS(string $channel="linkaja")
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('qris');
        self::setChannel($channel);

        return new static();
    }

    /**
     * @param array $payloadTrx
     * @return mixed
     */
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