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

    public function render($message)
    {
        if ($this->isUserLoggedIn()) {
            return $this->generateLogoutButtonHTML($message);
        } else {
            return $this->generateLoginFormHTML($message);
        }
    }

    public function isUserLoggedIn(): bool
    {
        $auth = new \Model\Auth();
        return $auth->isUserLoggedIn();
    }

    private function checkInputFields()
    {
        if ($this->isUsernameNotNull() && $this->isUsernameEmpty()) {
            $this->setMessage('Username is missing');
        } else if ($this->isPasswordNotNull() && $this->isPasswordEmpty()) {
            $this->setMessage('Password is missing');
        } else if ($this->isUsernameNotNull() && $this->isPasswordNotNull()) {
            $validated = $this->validateUser();
            $this->setSessionIfValidated($validated);
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

    private function validateUser(): bool
    {
        $user = new \Model\User(
            $this->view->getUsername(),
            $this->view->getPassword()
        );
        $validated = $this->session->authUser($user);
        $this->setValidationMessage($validated);
        return $validated;
    }

    private function setValidationMessage(bool $validated)
    {
        if (!$validated) {
            $this->setMessage('Wrong name or password');
        } else {
            $this->setMessage('Welcome');
        }
    }

    private function setSessionIfValidated(bool $validated)
    {
        if ($validated) {
            $userStorage = new \Model\UserStorage();
            $userId = $userStorage->findUserId($this->view->getUsername());
            $this->session->setSession($userId);
        }
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

    public function getUsername()
    {
        return $_POST[self::$name] ?? null;
    }

    public function getPassword()
    {
        return $_POST[self::$password] ?? null;
    }

    public function getKeepMeLoggedIn()
    {
        return $_POST[self::$keepLoggedIn] ?? null;
    }

    public function getLogout()
    {
        return $_POST[self::$logout] ?? null;
    }
}
