<?php
/**
 * Arr.php.
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP\Helpers;

class Arr
{
    /**
     * Pluck an array of values from an array. (Only for PHP 5.3+).
     *
     * @param  $array - data
     * @param  $key - value you want to pluck from array
     *
     * @return plucked array only with key data
     *                 https://gist.github.com/ozh/82a17c2be636a2b1c58b49f271954071
     */
    public static function pluck($array, $key)
    {
        return array_map(function ($v) use ($key) {
            return is_object($v) ? $v->$key : $v[$key];
        }, $array);
    }

    /**
     * @param array $array
     *
     * @return float|int
     */
    public static function sum(array $array)
    {
        return array_sum($array);
    }

    /**
     * @param array $array
     * @param array $array2
     *
     * @return array
     */
    public static function merge(array $array, array $array2): array
    {
        return array_merge($array, $array2);
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public static function key(array $array)
    {
        return array_keys($array);
    }
}
