<?php
/**
 * Exception.php
 *
 * @date        16/11/2018
 * @file        Exception.php
 */

namespace NagiosDat;

/**
 * Exception
 */
class Exception extends \Exception
{

    static function noIteratorDefined()
    {
        return new static('No Dat Iterator defined');
    }
}
