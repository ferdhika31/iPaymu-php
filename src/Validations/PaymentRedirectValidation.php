<?php
/**
 * PaymentRedirectValidation.php.
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP\Validations;

use ferdhika31\iPaymuPHP\Constants\Channel;
use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\iPaymu;

class PaymentRedirectValidation
{
    /**
     * @param array $product
     *
     * @return bool
     */
    public static function validateProduct(array $product = []): bool
    {
        if (!array_key_exists('name', $product)) {
            $msg = 'Payload {name} is Required.';

            throw new InvalidArgumentException($msg);
        }

        if (!array_key_exists('qty', $product)) {
            $msg = 'Payload {qty} is Required.';

            throw new InvalidArgumentException($msg);
        }

        if (!array_key_exists('price', $product)) {
            $msg = 'Payload {price} is Required.';

            throw new InvalidArgumentException($msg);
        }

        return true;
    }

    /**
     * @param array $body
     *
     * @return bool
     */
    public static function validateField(array $body = []): bool
    {
        $notifyUri = iPaymu::getNotifyUri();
        if (empty($notifyUri)) {
            $msg = 'Notify Uri is Required.';

            throw new InvalidArgumentException($msg);
        }

        $cancelUri = iPaymu::getCancelUri();
        if (empty($cancelUri)) {
            $msg = 'Cancel Uri is Required.';

            throw new InvalidArgumentException($msg);
        }

        $returnUri = iPaymu::getReturnUri();
        if (empty($returnUri)) {
            $msg = 'Return Uri is Required.';

            throw new InvalidArgumentException($msg);
        }

        if (array_key_exists('expiredType', $body)) {
            TransactionValidation::validateExpiredType($body['expiredType']);
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
            $msg = 'Channel not empty! Available channel: '.implode(', ', Channel::$REDIRECT[$paymentMethod]);

            throw new InvalidArgumentException($msg);
        }

        if (!in_array($channel, Channel::$REDIRECT[$paymentMethod])) {
            $msg = "Channel {$channel} is invalid. Available channel: ".implode(', ', Channel::$REDIRECT[$paymentMethod]);

            throw new InvalidArgumentException($msg);
        }

        return true;
    }
}
