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
}
