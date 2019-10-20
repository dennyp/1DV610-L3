<?php

namespace Model;

class UserRule
{
    private const minUsernameLength = 3;
    private const minPasswordLength = 6;

    public function getMinUsernameLength()
    {
        return self::minUsernameLength;
    }

    public function getMinPasswordLength()
    {
        return self::minPasswordLength;
    }

    public function isMinimumUsernameLength(string $name): bool
    {
        return strlen($name) < $this->getMinUsernameLength();
    }

    public function isMinimumPasswordLength(string $password): bool
    {
        return strlen($password) < $this->getMinPasswordLength();
    }

    public function isNotNullOrEmpty(string $str): bool
    {
        return !is_null($str) && $str !== '';
    }

    public function hasBadCharacters($rawString): bool
    {
        return strcmp($rawString, \strip_tags($rawString)) !== 0;
    }

    public function removeBadCharacters($rawString)
    {
        return filter_var($rawString, FILTER_SANITIZE_STRING);
    }
}
