<?php

/**
 * PaymentRedirect.php
 *
 * @package ferdhika31\iPaymuPHP
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP;

use ferdhika31\iPaymuPHP\Validations\PaymentRedirectValidation;
use ferdhika31\iPaymuPHP\Traits\ApiOperations;
use ferdhika31\iPaymuPHP\Helpers\Arr;

class PaymentRedirect
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
    private static string $uri = '/api/v2/payment';

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
     * @return static
     */
    public static function BAGVA()
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('bagva');

        return new static();
    }

    /**
     * @return static
     */
    public static function BNIVA()
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('bniva');

        return new static();
    }

    /**
     * @return static
     */
    public static function mandiriVA()
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('mandiriva');

        return new static();
    }

    /**
     * @return static
     */
    public static function niagaVA()
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('niagava');

        return new static();
    }

    /**
     * @return static
     */
    public static function BCATransfer()
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('bcatransfer');

        return new static();
    }

    /**
     * @return static
     */
    public static function creditCard()
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('cc');

        return new static();
    }

    /**
     * @param array $payloadCOD
     * @return static
     */
    public static function COD(array $payloadCOD=[])
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('cod');

        if(in_array('dimension', iPaymu::getProducts())){
            self::$payload['dimension'] = Arr::pluck(iPaymu::getProducts(), 'dimension');
        }
        if(in_array('weight', iPaymu::getProducts())){
            self::$payload['weight'] = Arr::pluck(iPaymu::getProducts(), 'weight');
        }
        if (!empty($payloadCOD)) {
            self::$payload = Arr::merge($payloadCOD, self::$payload);
        }

        return new static();
    }

    /**
     * @param string $channel
     * @return static
     */
    public static function CStore(string $channel='alfamart')
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('cstore');

        PaymentRedirectValidation::validateChannel(self::$payload['paymentMethod'], $channel);

        return new static();
    }

    /**
     * @return static
     */
    public static function akulaku()
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('akulaku');

        return new static();
    }

    /**
     * @return static
     */
    public static function QRIS()
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::setPaymentMethod('qris');

        return new static();
    }

    /**
     * @param array $payloadTrx
     * @return mixed
     */
    public static function create(array $payloadTrx=[])
    {
        $payload = self::$payload;

        $customer = iPaymu::getCustomer();
        if (!empty($customer)) {
            $payload['buyerName']     = $customer['name'];
            $payload['buyerEmail']    = $customer['email'];
            $payload['buyerPhone']    = $customer['phone'];
        }

        $payload['product']       = Arr::pluck(iPaymu::getProducts(), 'name');
        $payload['qty']           = Arr::pluck(iPaymu::getProducts(), 'qty');
        $payload['price']         = Arr::pluck(iPaymu::getProducts(), 'price');
        $payload['description']   = Arr::pluck(iPaymu::getProducts(), 'description');
        $payload['notifyUrl']     = iPaymu::getNotifyUri();
        $payload['returnUrl']     = iPaymu::getReturnUri();
        $payload['cancelUrl']     = iPaymu::getCancelUri();
        $payload['amount']        = Arr::sum((array)Arr::pluck(iPaymu::getProducts(), 'price'));

        if (!empty($payloadTrx)) {
            $payload = Arr::merge($payload, $payloadTrx);
        }

        PaymentRedirectValidation::validateField($payload);

        return self::_request('POST', self::$uri, $payload);
    }
}