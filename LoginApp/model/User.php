<?php

namespace Model;

class User
{

    private $name;
    private $password;
    private const minUsernameLength = 3;
    private const minPasswordLength = 6;

    public function __construct($username, $password)
    {
        $this->name = $username;
        $this->password = $password;
    }

    public function getUsername()
    {
        return $this->name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getMinUsernameLength(): int
    {
        return self::minUsernameLength;
    }

    public function getMinPasswordLength(): int
    {
        return self::minPasswordLength;
    }

    public function isAboveMinimumUsernameLength(): bool
    {
        return strlen($this->name) >= $this->getMinUsernameLength();
    }

    public function isBelowMinimumUsernameLength(): bool
    {
        return strlen($this->name) < $this->getMinUsernameLength();
    }

    public function isAboveMinimumPasswordLength(): bool
    {
        return strlen($this->password) >= $this->getMinPasswordLength();
    }

    public function isBelowMinimumPasswordLength(): bool
    {
        return strlen($this->password) < $this->getMinPasswordLength();
    }
}
