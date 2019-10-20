<?php

namespace View;

class LoginView
{
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $keepLoggedIn = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    public function renderLogin($message)
    {
        return $this->generateLoginFormHTML($message);
    }

    public function renderLoggedIn($message)
    {
        return $this->generateLogoutButtonHTML($message);
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
