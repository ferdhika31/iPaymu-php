<?php
/**
 * Transaction.php
 *
 * @package ferdhika31\iPaymuPHP
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP;

use ferdhika31\iPaymuPHP\iPaymu;
use ferdhika31\iPaymuPHP\Constants\Types;
use ferdhika31\iPaymuPHP\Exceptions\InvalidArgumentException;
use ferdhika31\iPaymuPHP\Traits\ApiOperations;

class Transaction
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
     * @param string $idTrx
     * @param string $format
     * @return mixed
     */
    public function getById(string $idTrx, string $format = "json")
    {
        $data = [];
        $data['key'] = iPaymu::getApiKey();
        $data['id'] = $idTrx;
        if (!empty($format)) {
            self::validateFormat($format);
            $data['format'] = $format;
        }
        $params = http_build_query($data);

        $url = '/api/transaksi?'.$params;

        return static::_request('GET', $url);
    }
}