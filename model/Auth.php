<?php

namespace Model;

require_once 'DatabaseHandler.php';

class Auth extends DatabaseHandler
{

    public function __construct()
    {
        parent::__construct();
    }

    public function validateUser(\Model\User $user): bool
    {
        $dbUser = $user->findOneUser($user->getUsername());

        $dbUsername = $dbUser['username'] ?? null;
        $dbPassword = $dbUser['password'] ?? null;

        return password_verify($user->getPassword(), $dbPassword);
    }
}
