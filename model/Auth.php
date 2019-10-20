<?php

namespace Model;

require_once 'DatabaseHandler.php';
require_once 'UserStorage.php';

class Auth
{
    public function validateUser(\Model\User $user): bool
    {
        $userStorage = new \Model\UserStorage();
        $dbUser = $userStorage->findOneUser($user->getUsername());
        return password_verify($user->getPassword(), $dbUser->getPassword());
    }
}
