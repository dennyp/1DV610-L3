<?php

namespace Model;

class UserRule
{
    private const minUsernameLength = 3;
    private const minPasswordLength = 6;

    public function getMinUsernameLength(): int
    {
        return self::minUsernameLength;
    }

    public function getMinPasswordLength(): int
    {
        return self::minPasswordLength;
    }

    public function isAboveMinimumUsernameLength(string $name): bool
    {
        return strlen($name) >= $this->getMinUsernameLength();
    }

    public function isBelowMinimumUsernameLength(string $name): bool
    {
        return strlen($name) < $this->getMinUsernameLength();
    }

    public function isAboveMinimumPasswordLength(string $password): bool
    {
        return strlen($password) >= $this->getMinPasswordLength();
    }

    public function isBelowMinimumPasswordLength(string $password): bool
    {
        return strlen($password) < $this->getMinPasswordLength();
    }
}
