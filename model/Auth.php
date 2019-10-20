<?php

namespace Model;

require_once 'DatabaseHandler.php';
require_once 'model/UserStorage.php';

class Auth
{
    public function validateUser(\Model\User $user): bool
    {
        $userStorage = new \Model\UserStorage();
        $dbUser = $userStorage->findOneUser($user->getUsername());

        $dbUsername = $dbUser['username'] ?? null;
        $dbPassword = $dbUser['password'] ?? null;

        return password_verify($user->getPassword(), $dbPassword);
    }
}
