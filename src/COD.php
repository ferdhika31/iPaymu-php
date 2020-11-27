<?php
/**
 * COD.php
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

class COD
{
    use ApiOperations;

    /**
     * @param string $trxId
     * @return mixed
     */
    public function pickup(string $trxId)
    {
        $data = [];
        $data['account'] = iPaymu::getVirtualAccount();
        $data['transactionId'] = $trxId;

        $params = http_build_query($data);

        $url = '/api/v2/cod/pickup?'.$params;

        return static::_request('GET', $url);
    }

    /**
     * @return mixed
     */
    public function getArea()
    {
        $data = [];
        $data['account'] = iPaymu::getVirtualAccount();

        $params = http_build_query($data);

        $url = '/api/v2/cod/getarea?'.$params;

        return static::_request('GET', $url);
    }

    /**
     * @param string $awb
     * @return mixed
     */
    public function tracking(string $awb)
    {
        $data = [];
        $data['awb'] = $awb;

        $params = http_build_query($data);

        $url = '/api/v2/cod/tracking?'.$params;

        return static::_request('GET', $url);
    }
}