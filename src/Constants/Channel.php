<?php
/**
 * Channel.php.
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP\Constants;

class Channel
{
    /**
     * @var array|\string[][]
     */
    public static array $DIRECT = [
        'va'            => ['bag', 'bni', 'cimb', 'mandiri'],
        'banktransfer'  => ['bca'],
        'cstore'        => ['indomaret', 'alfamart'],
        'cod'           => ['rpx'],
        'qris'          => ['linkaja'],
        'paylater'      => ['akulaku'],
    ];

    /**
     * @var array|\string[][]
     */
    public static array $REDIRECT = [
        'cstore' => ['indomaret', 'alfamart'],
    ];
}
