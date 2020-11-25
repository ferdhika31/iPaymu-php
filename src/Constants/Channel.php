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
    /**
     * @var \string[][]
     */
    public static $DIRECT = [
        "va"            => ["bag", "bni", "cimb", "mandiri"],
        "banktransfer"  => ["bca"],
        "cstore"        => ["indomaret", "alfamart"],
        "cod"           => ["rpx"],
        "qris"          => ["linkaja"],
        "paylater"      => ["akulaku"]
    ];

    /**
     * @var \string[][]
     */
    public static $REDIRECT = [
        "cstore"        => ["indomaret", "alfamart"]
    ];
}