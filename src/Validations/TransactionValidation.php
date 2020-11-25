<?php
/**
 * TransactionValidation.php
 *
 * @package ferdhika31\iPaymuPHP\Validations
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP\Validations;

use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\Constants\Types;

class TransactionValidation
{
    /**
     * @param string $expiredType
     * @return bool
     */
    public static function validateExpiredType(string $expiredType) : bool
    {
        if (!in_array($expiredType, Types::$EXPIRED)) {
            $msg = "Expired Type is invalid. Available types: ".implode(', ', Types::$EXPIRED);
            throw new InvalidArgumentException($msg);
        }

        return true;
    }
}