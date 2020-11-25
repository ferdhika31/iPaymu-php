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
    public static array $ENV = ["SANDBOX", "PRODUCTION"];

    /**
     * @var string[]
     */
    public static array $FORMAT = ["xml", "json"];

    /**
     * @var string[]
     */
    public static array $EXPIRED = ["seconds", "minutes", "hours", "days"];
}