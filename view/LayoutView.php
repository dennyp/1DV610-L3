<?php

namespace View;

require_once 'model/Cookie.php';
require_once 'model/User.php';
require_once 'model/DateTimeGenerator.php';

class LayoutView
{
    private $loginView;
    private $registerView;
    private $date;
    private $dateTimeView;
    private $cookie;
    private static $cookieName = 'PHPSESSID';
    private $session;
    private static $registerName = 'register';

    public function __construct(\View\LoginView $view)
    {
        $this->loginView = $view;

        $this->dateTime = new \Model\DateTimeGenerator();
        $this->dateTimeView = new DateTimeView($this->dateTime->getTime());

        $this->registerView = new \View\RegisterView();

        $this->session = new \Model\Auth();
    }

    public function render($message = '')
    {
        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->isLoggedInHTML() . '

          <div class="container">
              ' . $this->getHTMLBasedOnLoggedInOrRegister($message) . '

              ' . $this->dateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
    }

    private function isLoggedInHTML()
    {
        $html = '';
        if ($this->isLoggedIn()) {
            $html = '<h2>Logged in</h2>';
        } else {
            $html = $this->renderLink();
            $html .= '<h2>Not logged in</h2>';
        }
        return $html;
    }

    private function getHTMLBasedOnLoggedInOrRegister($message)
    {
        if ($this->isRegistering()) {
            return $this->registerView->render();
        } else if ($this->isLoggedIn()) {
            return $this->loginView->renderLoggedIn($message);
        } else {
            return $this->loginView->renderLogin($message);
        }
    }

    private function isLoggedIn()
    {
        return $this->session->checkValidSession();
    }

    public function getLogout()
    {
        return $this->loginView->getLogout();
    }

    public function getPassword()
    {
        return $this->loginView->getPassword();
    }

    public function isRegistering(): bool
    {
        return isset($_GET[self::$registerName]);
    }

    public function getUsername()
    {
        return $this->loginView->getUsername();
    }

    public function getUsernamePostback()
    {
        return $this->registerView->getRegisterUsername();
    }

    public function getPasswordPostBack()
    {
        return $this->registerView->getRegisterPassword();
    }

    public function isLoggingOut()
    {
        return $this->loginView->getLogout();
    }

    public function isRegisteringUser()
    {
        return $this->registerView->getRegisterPostback();
    }

    private function renderLink()
    {
        if (!isset($_GET[self::$registerName])) {
            return '<a href="./index.php?' . self::$registerName . '">Register a new user</a>';
        }

        return '<a href=?>Back to login</a>';
    }

    public function goToMainPage()
    {
        header('Location: ./');
        exit;
    }
}
