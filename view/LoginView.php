<?php

namespace View;

class LoginView
{

    private $view;
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $keepLoggedIn = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    public function __construct()
    {
        $this->user = new \model\User();

    }

    public function render($message)
    {
        return $this->generateLoginFormHTML($message);
    }

    private function generateLoginFormHTML(string $message)
    {
        return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getPostParameter(self::$name) . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keepLoggedIn . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keepLoggedIn . '" name="' . self::$keepLoggedIn . '" />

                    <input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }

    private function generateLogoutButtonHTML($message)
    {
        return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
    }

    public function getPostParameter($param)
    {
        return $_POST[$param] ?? null;
    }
}
