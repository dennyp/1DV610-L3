<?php

namespace View;

require_once 'LoginApp/model/Auth.php';
require_once 'LoginApp/model/LoginCredentials.php';
require_once 'LoginApp/view/exceptions/LoginCredentialsException.php';

class LoginView
{
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $keepLoggedIn = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';
    private $message = '';

    public function render()
    {
        if ($this->isUserLoggedIn()) {
            return $this->generateLogoutButtonHTML($this->message);
        } else {
            return $this->generateLoginFormHTML($this->message);
        }
    }

    public function isUserLoggedIn(): bool
    {
        $auth = new \Model\Auth();
        return $auth->isUserLoggedIn();
    }

    public function getUsername()
    {
        return $_POST[self::$name] ?? null;
    }

    public function getPassword()
    {
        return $_POST[self::$password] ?? null;
    }

    public function getRememberLogin()
    {
        return $_POST[self::$keepLoggedIn] ?? null;
    }

    public function isLoggingIn(): bool
    {
        return isset($_POST[self::$login]);
    }

    public function isLoggingOut(): bool
    {
        return isset($_POST[self::$logout]);
    }

    public function getLoginCredentials(): \Model\LoginCredentials
    {
        if ($this->isLoggingIn()) {
            $this->isValidFields();
            return new \Model\LoginCredentials($this->getUsername(), $this->getPassword());
        } else {
            // TODO: Get values from cookie
        }
    }

    private function isValidFields()
    {
        if ($this->isUsernameNotNull() && $this->isUsernameEmpty()) {
            throw new MissingUsernameException();
        } else if ($this->isPasswordNotNull() && $this->isPasswordEmpty()) {
            throw new MissingPasswordException();
        }
    }

    private function isUsernameNotNull(): bool
    {
        return !is_null($this->getUsername());
    }

    private function isUsernameEmpty(): bool
    {
        return empty($this->getUsername());
    }

    private function isPasswordNotNull(): bool
    {
        return !is_null($this->getPassword());
    }

    private function isPasswordEmpty(): bool
    {
        return empty($this->getPassword());
    }

    public function setUsernameMissingMessage()
    {
        $this->message = 'Username is missing';
    }

    public function setPasswordMissingMessage()
    {
        $this->message = 'Password is missing';
    }

    public function setWrongUsernameOrPasswordMessage()
    {
        $this->message = 'Wrong name or password';
    }

    public function setWelcomeMessage()
    {
        $this->message = 'Welcome';
    }

    public function setLogoutMessage()
    {
        $this->message = 'Bye bye!';
    }

    private function generateLoginFormHTML(string $message): string
    {
        return '
			<form method="post">
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getUsername() . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keepLoggedIn . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keepLoggedIn . '" name="' . self::$keepLoggedIn . '" />

                    <input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }

    private function generateLogoutButtonHTML(string $message): string
    {
        return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
    }
}
