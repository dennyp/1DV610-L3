<?php

namespace Model;

class Util
{
    public static function hasBadCharacters($rawString): bool
    {
        return strcmp($rawString, \strip_tags($rawString)) !== 0;
    }

    public static function hasNoBadCharacters($rawString): bool
    {
        return strcmp($rawString, \strip_tags($rawString)) === 0;
    }

    public static function isNotNullOrEmpty(string $str): bool
    {
        return !is_null($str) && $str !== '';
    }

    public static function isNotMatch(string $left, string $right): bool
    {
        return $left !== $right;
    }

    public static function isNotNull(string $str): bool
    {
        return !is_null($str);
    }

    public static function removeBadCharacters(string $rawString): string
    {
        return filter_var($rawString, FILTER_SANITIZE_STRING);
    }

    public static function removeWhitespace(string $str): string
    {
        return trim($str);
    }
}
