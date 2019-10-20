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
        $name = $this->trimWhitespace($name);
        $password = $this->trimWhitespace($password);
        $passwordRepeat = $this->trimWhitespace($passwordRepeat);

        $message = '';
        $message .= $this->containingBadCharacters($name);
        $message .= $this->checkName($name);
        $message .= $this->checkPassword($password);
        $message .= $this->passwordsNotMatching($password, $passwordRepeat);

        if (Util::isNotNull($message)) {
            throw new \Exception($message);
        }
    }

    private function trimWhitespace($str)
    {
        return trim($str);
    }

    private function checkName(string $name)
    {
        if (Util::isNotNull($name)) {
            if ($this->userRule->isMinimumUsernameLength($name)) {
                return 'Username has too few characters, at least ' .
                $this->userRule->getMinUsernameLength() . ' characters. ';
            } else if ($this->userStorage->isUsernameExisting(Util::removeBadCharacters($name))) {
                return "User exists, pick another username. ";
            }
        }
    }

    private function checkPassword($password)
    {
        if (Util::isNotNull($password) &&
            $this->userRule->isMinimumPasswordLength($password)) {
            return 'Password has too few characters, at least ' .
            $this->userRule->getMinPasswordLength() . ' characters. ';
        }
    }

    private function containingBadCharacters($name)
    {
        if (Util::hasBadCharacters($name)) {
            return "Username contains invalid characters. ";
        }
    }

    private function passwordsNotMatching($password, $passwordRepeat)
    {
        if (Util::isNotMatch($password, $passwordRepeat)) {
            return "Passwords do not match. ";
        }
    }
}
