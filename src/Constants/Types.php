<?php
/**
 * Types.php
 *
 * @author  Ferdhika Yudira
 * @email   fer@dika.web.id
 */

namespace ferdhika31\iPaymuPHP\Constants;

class Types
{
    /**
     * @var string[]
     */
    public static $ENV = ["SANDBOX", "PRODUCTION"];

    /**
     * @var string[]
     */
    public static $FORMAT = ["xml", "json"];

    /**
     * @var string[]
     */
    public static $EXPIRED = ["seconds", "minutes", "hours", "days"];
}