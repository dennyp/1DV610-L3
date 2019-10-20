<?php

namespace Model;

class Util
{
    public static function hasBadCharacters($rawString): bool
    {
        return strcmp($rawString, \strip_tags($rawString)) !== 0;
    }

    public static function isNotNullOrEmpty(string $str): bool
    {
        return !is_null($str) && $str !== '';
    }

    public static function isNotMatch($left, $right)
    {
        return $left !== $right;
    }

    public static function isNotNull($str)
    {
        return !is_null($str);
    }

    public static function removeBadCharacters($rawString)
    {
        return filter_var($rawString, FILTER_SANITIZE_STRING);
    }

    public static function removeWhitespace(string $str): string
    {
        return trim($str);
    }
}
