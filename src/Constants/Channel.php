<?php
/**
 * Channel.php
 *
 * @package ferdhika31\iPaymuPHP\Constants
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP\Constants;

class Channel
{
    public static array $DIRECT = [
        "va"            => ["bag", "bni", "cimb", "mandiri"],
        "banktransfer"  => ["bca"],
        "cstore"        => ["indomaret", "alfamart"],
        "cod"           => ["rpx"],
        "qris"          => ["linkaja"],
        "paylater"      => ["akulaku"]
    ];

    public static array $REDIRECT = [
        "cstore" => ["indomaret", "alfamart"]
    ];
}