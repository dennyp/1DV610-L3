<?php

namespace View;

require_once 'LoginApp/model/UserRuleException.php';

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
            if ($this->isRegisterPostback()) {
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

    private function isRegisterPostback(): bool
    {
        return isset($_POST[self::$register]);
    }
}
