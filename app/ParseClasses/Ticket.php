<?php

namespace App\ParseClasses;

use Parse\ParseObject;
use LaraParse\Traits\CastsParseProperties;

/**
 * Class Ticket
 *
 * @package LaraParse
 */
class Ticket extends ParseObject
{
    use CastsParseProperties;

    public static $parseClassName = 'Ticket';
}