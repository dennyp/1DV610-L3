<?php

namespace Model;

require_once 'UserRule.php';
require_once 'UserStorage.php';

class UserRuleException extends \Exception
{
    private $userRule;
    private $userStorage;

    public function __construct()
    {
        $this->userRule = new \Model\UserRule();
        $this->userStorage = new \Model\UserStorage();
    }

    public function checkUserRules(string $name, string $password, string $passwordRepeat)
    {
        $message = '';
        $message .= $this->checkName($name);
        $message .= $this->checkPassword($password);
        $message .= $this->passwordsNotMatching($password, $passwordRepeat);
        $message .= $this->containingBadCharacters($name);

        if ($this->isNotNull($message)) {
            throw new \Exception($message);
        }
    }

    private function checkName(string $name)
    {
        if ($this->userRule->isNotNullOrWhitespace($name) &&
            $this->userRule->isMinimumUsernameLength($name)) {
            return 'Username has too few characters, at least ' .
            $this->userRule->getMinUsernameLength() . ' characters. ';
        } else if ($this->userStorage->isUsernameExisting($name)) {
            return "User exists, pick another username. ";
        }
    }

    private function checkPassword($password)
    {
        if ($this->userRule->isNotNullOrWhitespace($password) &&
            $this->userRule->isMinimumPasswordLength($password)) {
            return 'Password has too few characters, at least ' .
            $this->userRule->getMinPasswordLength() . ' characters. ';
        }
    }

    private function containingBadCharacters($name)
    {
        if ($this->userRule->hasBadCharacters($name)) {
            $message .= "Username contains invalid characters. ";
        }
    }

    private function passwordsNotMatching($password, $passwordRepeat)
    {
        if ($this->isNotMatch($password, $passwordRepeat)) {
            return "Passwords do not match. ";
        }
    }

    private function isNotMatch($left, $right)
    {
        return $left !== $right;
    }

    private function isNotNull($str)
    {
        return !is_null($str);
    }
}
