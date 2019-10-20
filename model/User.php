<?php

namespace Model;

class User
{

    private $name;
    private $password;

    public function __construct($username, $password)
    {
        parent::__construct();
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
}
