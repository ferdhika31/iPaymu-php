<?php
/**
 * Balance.php
 *
 * @package ferdhika31\iPaymuPHP
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP;

use ferdhika31\iPaymuPHP\Constants\Types;
use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\Traits\ApiOperations;

class Balance
{
    use ApiOperations;

    /**
     * @param string|null $format
     * @return bool
     */
    public static function validateFormat(string $format = null) : bool
    {
        if (!in_array($format, Types::$FORMAT)) {
            $msg = "Format is invalid. Available types: ".implode(' ', Types::$FORMAT);
            throw new InvalidArgumentException($msg);
        }

        return true;
    }

    /**
     * @param string|null $format
     * @return mixed
     */
    public function getBalance(string $format = "json")
    {
        $data = [];
        $data['key'] = iPaymu::getApiKey();
        if (!empty($format)) {
            self::validateFormat($format);
            $data['format'] = $format;
        }
        $params = http_build_query($data);

        $url = '/api/saldo?'.$params;

        return static::_request('GET', $url);
    }
}