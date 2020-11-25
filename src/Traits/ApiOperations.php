<?php
/**
 * Request.php
 *
 * @package ferdhika31\iPaymuPHP\Traits
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP\Traits;

use ferdhika31\iPaymuPHP\iPaymu;
use ferdhika31\iPaymuPHP\Exceptions\InvalidApiKeyException;

trait ApiOperations
{
    /**
     * @param array $body
     * @param $method
     * @return string
     */
    private static function generateSignature(array $body, $method) : string
    {
        $va = iPaymu::getVirtualAccount();
        $secret = iPaymu::getApiKey();

        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $secret;

        return hash_hmac('sha256', $stringToSign, $secret);
    }

    /**
     * @param string $method
     * @param string $pathUrl
     * @param array $params
     * @return mixed
     */
    private function _request(string $method, string $pathUrl, array $params = [])
    {
        $method     = strtoupper($method);
        $url        = iPaymu::getBaseUri().$pathUrl;
        $signature  = self::generateSignature($params, $method);
        $timestamp  = Date('YmdHis');

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . iPaymu::getVirtualAccount(),
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        );
        $jsonBody = json_encode($params, JSON_UNESCAPED_SLASHES);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $err = curl_error($ch);
        $ret = curl_exec($ch);
        curl_close($ch);
        if($err) {
            echo $err;
        } else {
            $ret = json_decode($ret);
            if($ret->Status === -1001 or $ret->Status === 401) {
                $msg = $ret->Status === -1001 ? $ret->Keterangan : '';
                $msg = $ret->Status === 401 ? $ret->Message : $msg;
                throw new InvalidApiKeyException($msg);
            }
            return $ret;
        }
    }
}