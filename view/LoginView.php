<?php

namespace View;

require_once 'model/Auth.php';

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
            return $this->generateLogoutButtonHTML();
        } else {
            return $this->generateLoginFormHTML();
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

    public function isLoggingOut()
    {
        return $_POST[self::$logout] ?? null;
    }

    public function checkInputFields()
    {
        if ($this->isUsernameNotNull() && $this->isUsernameEmpty()) {
            $this->setMessage('Username is missing');
        } else if ($this->isPasswordNotNull() && $this->isPasswordEmpty()) {
            $this->setMessage('Password is missing');
        } else if ($this->isUsernameNotNull() && $this->isPasswordNotNull()) {
            $authenticated = $this->authenticateUser();
            $this->setSessionIfAuthenticated($authenticated);
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

    private function setMessage($message)
    {
        $this->message = $message;
    }

    private function isPasswordNotNull(): bool
    {
        return !is_null($this->view->getPassword());
    }

    private function isPasswordEmpty(): bool
    {
        return empty($this->view->getPassword());
    }

    private function authenticateUser(): bool
    {
        $user = new \Model\User(
            $this->getUsername(),
            $this->getPassword()
        );
        $authenticated = $this->session->authUser($user);
        $this->setAuthenticationMessage($authenticated);
        return $authenticated;
    }

    private function setAuthenticationMessage(bool $authenticated)
    {
        if (!$authenticated) {
            $this->setMessage('Wrong name or password');
        } else {
            $this->setMessage('Welcome');
        }
    }

    private function setSessionIfAuthenticated(bool $authenticated)
    {
        if ($authenticated) {
            $userStorage = new \Model\UserStorage();
            $userId = $userStorage->findUserId($this->view->getUsername());
            $this->session->setSession($userId);
        }
    }

    private function generateLoginFormHTML(string $message = ''): string
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

    private function generateLogoutButtonHTML(string $message = ''): string
    {
        return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
    }
}
