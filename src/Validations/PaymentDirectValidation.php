<?php
/**
 * PaymentDirectValidation.php.
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP\Validations;

use ferdhika31\iPaymuPHP\Constants\Channel;
use ferdhika31\iPaymuPHP\Constants\Types;
use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\Helpers\Arr;
use ferdhika31\iPaymuPHP\iPaymu;

class PaymentDirectValidation
{
    /**
     * @param array $body
     *
     * @return bool
     */
    public static function validateField(array $body = []): bool
    {
        if (!array_key_exists('amount', $body)) {
            $msg = 'Payload {amount} is Required.';

            throw new InvalidArgumentException($msg);
        }

        $notifyUri = iPaymu::getNotifyUri();
        if (empty($notifyUri)) {
            $msg = 'Notify Uri is Required.';

            throw new InvalidArgumentException($msg);
        }

        if (array_key_exists('expiredType', $body)) {
            if (!in_array($body['expiredType'], Types::$EXPIRED)) {
                $msg = 'Expired Type is invalid. Available types: '.implode(', ', Types::$EXPIRED);

                throw new InvalidArgumentException($msg);
            }
        }

        if (array_key_exists('paymentMethod', $body)) {
            $pMet = Arr::key(Channel::$DIRECT);
            if (empty($body['paymentMethod'])) {
                $msg = 'Payment Method not empty! Available method: '.implode(', ', $pMet);

                throw new InvalidArgumentException($msg);
            }
            if (!in_array($body['paymentMethod'], $pMet)) {
                $msg = 'Payment Method is invalid. Available method: '.implode(', ', $pMet);

                throw new InvalidArgumentException($msg);
            }
        }

        return true;
    }

    /**
     * @param string $paymentMethod
     * @param string $channel
     *
     * @return bool
     */
    public static function validateChannel(string $paymentMethod, string $channel): bool
    {
        if (empty($channel)) {
            $msg = 'Channel not empty! Available channel: '.implode(', ', Channel::$DIRECT[$paymentMethod]);

            throw new InvalidArgumentException($msg);
        }

        if (!in_array($channel, Channel::$DIRECT[$paymentMethod])) {
            $msg = "Channel {$channel} is invalid. Available channel: ".implode(', ', Channel::$DIRECT[$paymentMethod]);

            throw new InvalidArgumentException($msg);
        }

        return true;
    }

    /**
     * @param array $products
     *
     * @return bool
     */
    public static function validateProducts(array $products): bool
    {
        if (empty($products)) {
            $msg = 'Products not empty!';

            throw new InvalidArgumentException($msg);
        }

        return true;
    }
}
