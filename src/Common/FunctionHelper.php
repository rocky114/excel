<?php

namespace Rocky114\Excel\Common;

class FunctionHelper
{
    public static function isXLSXFile($filename)
    {
        return 'xlsx' === pathinfo($filename, PATHINFO_EXTENSION);
    }

    public static function isCSVFile($filename)
    {
        return 'csv' === pathinfo($filename, PATHINFO_EXTENSION);
    }

    public static function createUniqueId()
    {
        return uniqid(php_uname('n').getmypid(), true);
    }

    public static function isUTF8Code($string)
    {
        if (function_exists('mb_check_encoding')) {
            return mb_check_encoding($string, 'UTF-8') ? true : false;
        }

        return preg_match("//u", $string) ? true : false;
    }
}