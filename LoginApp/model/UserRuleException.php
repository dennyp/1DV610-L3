<?php

namespace Model;

require_once 'UserStorage.php';

class UserRuleException extends \Exception
{
    private $userStorage;

    public function __construct()
    {
        $this->userStorage = new \Model\UserStorage();
    }

    public function checkUserRules(string $name, string $password, string $passwordRepeat)
    {
        $name = Util::removeWhitespace($name);
        $password = Util::removeWhitespace($password);
        $passwordRepeat = Util::removeWhitespace($passwordRepeat);

        $message = '';
        $message .= $this->containingBadCharacters($name);
        $message .= $this->checkName($name);
        $message .= $this->checkPassword($password);
        $message .= $this->passwordsNotMatching($password, $passwordRepeat);

        if (Util::isNotNull($message)) {
            throw new \Exception($message);
        }
    }

    private function checkName(string $name): string
    {
        if (Util::isNotNull($name)) {
            $user = new \Model\User($name, '');

            if ($user->isBelowMinimumUsernameLength($name)) {
                return 'Username has too few characters, at least ' .
                    $user->getMinUsernameLength() . ' characters. ';
            } else if ($this->userStorage->isUsernameExisting(Util::removeBadCharacters($name))) {
                return "User exists, pick another username. ";
            }
        }
        return '';
    }

    private function checkPassword(string $password): string
    {
        if (Util::isNotNull($password)) {
            $user = new \Model\User('', $password);

            if ($user->isBelowMinimumPasswordLength($password)) {
                return 'Password has too few characters, at least ' .
                    $user->getMinPasswordLength() . ' characters. ';
            }
        }
        return '';
    }

    private function containingBadCharacters(string $name): string
    {
        if (Util::hasBadCharacters($name)) {
            return "Username contains invalid characters. ";
        }
        return '';
    }

    private function passwordsNotMatching(string $password, string $passwordRepeat): string
    {
        if (Util::isNotMatch($password, $passwordRepeat)) {
            return "Passwords do not match. ";
        }
        return '';
    }
}
