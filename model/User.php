<?php

namespace Model;

class User
{

    private $name;
    private $password;

    public function __construct($username, $password)
    {
        $this->name = $username;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
