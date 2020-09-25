<?php

namespace View;

require_once 'model/UserRuleException.php';

class RegisterView
{
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $register = 'RegisterView::Register';
    private static $messageId = 'RegisterView::Message';
    private $userRuleException;

    public function __construct()
    {
        $this->userRuleException = new \Model\UserRuleException();
    }

    public function render()
    {
        $message = '';
        $name = $this->getParameter(self::$name);
        $password = $this->getParameter(self::$password);
        $passwordRepeat = $this->getParameter(self::$passwordRepeat);

        try {
            if ($this->getRegisterPostback()) {
                $this->userRuleException->checkUserRules($name, $password, $passwordRepeat);
            }
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
        }

        return $this->generateRegisterFormHTML($message);
    }

    private function generateRegisterFormHTML(string $message): string
    {
        return '
    <form method="post" >
      <fieldset>
        <legend>Register a new user - Write username and password</legend>
        <p id="' . self::$messageId . '">' . $message . '</p>

        <label for="' . self::$name . '">Username :</label>
        <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . \Model\Util::removeBadCharacters($this->getParameter(self::$name)) . '" />

        <label for="' . self::$password . '">Password :</label>
        <input type="password" id="' . self::$password . '" name="' . self::$password . '" />

        <label for="' . self::$passwordRepeat . '">Repeat password :</label>
        <input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />

        <input type="submit" name="' . self::$register . '" value="register" />
      </fieldset>
    </form>
  ';
    }

    private function getParameter(string $param): string
    {
        return $_POST[$param] ?? '';
    }

    public function getRegisterButtonName(): string
    {
        return self::$register;
    }

    public function getRegisterPostback(): bool
    {
        return isset($_POST[self::$register]);
    }

    public function getRegisterUsername(): string
    {
        return $this->getParameter(self::$name);
    }

    public function getRegisterPassword(): string
    {
        return $this->getParameter(self::$password);
    }
}
