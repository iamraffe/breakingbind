<?php

namespace App\ParseClasses;

use Parse\ParseObject;
use LaraParse\Traits\CastsParseProperties;

/**
 * Class Content
 *
 * @package LaraParse
 */
class Content extends ParseObject
{
    use CastsParseProperties;

    public static $parseClassName = 'Content';
}