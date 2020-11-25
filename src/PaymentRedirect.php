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
    private static string $uri = '/api/v2/payment';

    /**
     * @return static
     */
    public static function BAGVA()
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }

        self::$payload['paymentMethod'] = 'bagva';

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

        self::$payload['paymentMethod'] = 'bniva';

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

        self::$payload['paymentMethod'] = 'mandiriva';

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

        self::$payload['paymentMethod'] = 'niagava';

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

        self::$payload['paymentMethod'] = 'bcatransfer';

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

        self::$payload['paymentMethod'] = 'cc';

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

        self::$payload['paymentMethod'] = 'cod';

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

        self::$payload['paymentMethod'] = 'cstore';

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

        self::$payload['paymentMethod'] = 'akulaku';

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

        self::$payload['paymentMethod'] = 'qris';

        return new static();
    }

    /**
     * @param array $payloadTrx
     * @return mixed
     */
    public static function create(array $payloadTrx=[])
    {
        $customer = iPaymu::getCustomer();
        if (!empty($customer)) {
            self::$payload['buyerName']     = $customer['name'];
            self::$payload['buyerEmail']    = $customer['email'];
            self::$payload['buyerPhone']    = $customer['phone'];
        }

        self::$payload['product']       = Arr::pluck(iPaymu::getProducts(), 'name');
        self::$payload['qty']           = Arr::pluck(iPaymu::getProducts(), 'qty');
        self::$payload['price']         = Arr::pluck(iPaymu::getProducts(), 'price');
        self::$payload['description']   = Arr::pluck(iPaymu::getProducts(), 'description');
        self::$payload['notifyUrl']     = iPaymu::getNotifyUri();
        self::$payload['returnUrl']     = iPaymu::getReturnUri();
        self::$payload['cancelUrl']     = iPaymu::getCancelUri();
        self::$payload['amount']        = Arr::sum((array)Arr::pluck(iPaymu::getProducts(), 'price'));

        if (!empty($payloadTrx)) {
            self::$payload = Arr::merge(self::$payload, $payloadTrx);
        }

        PaymentRedirectValidation::validateField(self::$payload);

        return (new PaymentRedirect)->_request('POST', self::$uri, self::$payload);
    }
}