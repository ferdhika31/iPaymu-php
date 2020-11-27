<?php
/**
 * CustomerValidation.php.
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP\Validations;

use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;

class CustomerValidation
{
    /**
     * @param array $customer
     *
     * @return bool
     */
    public static function validateField(array $customer = []): bool
    {
        if (!array_key_exists('name', $customer)) {
            $msg = 'Payload {name} is Required.';

            throw new InvalidArgumentException($msg);
        }

        if (!array_key_exists('email', $customer)) {
            $msg = 'Payload {email} is Required.';

            throw new InvalidArgumentException($msg);
        }

        if (!array_key_exists('phone', $customer)) {
            $msg = 'Payload {phone} is Required.';

            throw new InvalidArgumentException($msg);
        }

        return true;
    }
}
