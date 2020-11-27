<?php
/**
 * iPaymu.php.
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP;

use ferdhika31\iPaymuPHP\Constants\Types;
use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\Validations\CustomerValidation;
use ferdhika31\iPaymuPHP\Validations\PaymentRedirectValidation;

class iPaymu
{
    /**
     * @var string
     */
    public static string $env;

    /**
     * @var string
     */
    public static string $baseUri;

    /**
     * @var string
     */
    public static string $virtualAccount;

    /**
     * @var string
     */
    public static string $apiKey;

    /**
     * @var string
     */
    public static string $notifyUri;

    /**
     * @var string
     */
    public static string $cancelUri;

    /**
     * @var string
     */
    public static string $returnUri;

    /**
     * @var array
     */
    public static array $customer = [];

    /**
     * @var array
     */
    public static array $products = [];

    /**
     * @param array $config
     */
    public static function init(array $config): void
    {
        if (array_key_exists('env', $config)) {
            if (!in_array($config['env'], Types::$ENV)) {
                $msg = 'Environment type is invalid. Available types: '.implode(' ', Types::$ENV);

                throw new InvalidArgumentException($msg);
            }
            self::setEnv($config['env']);
            $baseUri = $config['env'] === 'SANDBOX' ? 'http://sandbox.ipaymu.com' : 'https://my.ipaymu.com';
            self::setBaseUri($baseUri);
        }

        if (!array_key_exists('virtual_account', $config)) {
            $msg = 'Virtual Account not empty!';

            throw new InvalidArgumentException($msg);
        }
        self::setVirtualAccount($config['virtual_account']);
        if (!array_key_exists('api_key', $config)) {
            $msg = 'API Key not empty!';

            throw new InvalidArgumentException($msg);
        }
        self::setApiKey($config['api_key']);

        if (array_key_exists('notify_uri', $config)) {
            self::setNotifyUri($config['notify_uri']);
        }
        if (array_key_exists('cancel_uri', $config)) {
            self::setCancelUri($config['cancel_uri']);
        }
        if (array_key_exists('return_uri', $config)) {
            self::setReturnUri($config['return_uri']);
        }
    }

    /**
     * @return string
     */
    public static function getEnv(): string
    {
        return self::$env;
    }

    /**
     * @param string $env
     */
    public static function setEnv(string $env): void
    {
        self::$env = $env;
    }

    /**
     * @return string
     */
    public static function getBaseUri(): string
    {
        return self::$baseUri;
    }

    /**
     * @param string $baseUri
     */
    public static function setBaseUri(string $baseUri): void
    {
        self::$baseUri = $baseUri;
    }

    /**
     * @return string
     */
    public static function getVirtualAccount(): string
    {
        return self::$virtualAccount;
    }

    /**
     * @param string $virtualAccount
     */
    public static function setVirtualAccount(string $virtualAccount): void
    {
        self::$virtualAccount = $virtualAccount;
    }

    /**
     * @return string
     */
    public static function getApiKey(): string
    {
        return self::$apiKey;
    }

    /**
     * @param string $apiKey
     */
    public static function setApiKey(string $apiKey): void
    {
        self::$apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public static function getNotifyUri(): string
    {
        return self::$notifyUri;
    }

    /**
     * @param string $notifyUri
     */
    public static function setNotifyUri(string $notifyUri): void
    {
        self::$notifyUri = $notifyUri;
    }

    /**
     * @return string
     */
    public static function getCancelUri(): string
    {
        return self::$cancelUri;
    }

    /**
     * @param string $cancelUri
     */
    public static function setCancelUri(string $cancelUri): void
    {
        self::$cancelUri = $cancelUri;
    }

    /**
     * @return string
     */
    public static function getReturnUri(): string
    {
        return self::$returnUri;
    }

    /**
     * @param string $returnUri
     */
    public static function setReturnUri(string $returnUri): void
    {
        self::$returnUri = $returnUri;
    }

    /**
     * @return array
     */
    public static function getCustomer(): array
    {
        return self::$customer;
    }

    /**
     * @param array $customer
     */
    public static function setCustomer(array $customer): void
    {
        CustomerValidation::validateField($customer);
        self::$customer = $customer;
    }

    /**
     * @return array
     */
    public static function getProducts(): array
    {
        return self::$products;
    }

    /**
     * @param array $products
     */
    public static function setProducts(array $products): void
    {
        self::$products = $products;
    }

    /**
     * @param array $product
     */
    public static function addProduct(array $product): void
    {
        PaymentRedirectValidation::validateProduct($product);
        array_push(self::$products, $product);
    }
}
