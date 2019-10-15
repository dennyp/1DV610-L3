<?php

namespace View;

require_once 'model/Cookie.php';
require_once 'model/User.php';
require_once 'model/DateTimeGenerator.php';

class LayoutView
{

    private $loginView;
    private $date;
    private $dateTimeView;
    private $cookie;
    private static $cookieName = 'PHPSESSID';

    public function __construct(\View\LoginView $view)
    {
        $this->loginView = $view;

        $this->dateTime = new \Model\DateTimeGenerator();
        $this->dateTimeView = new DateTimeView($this->dateTime->getTime());
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
              ' . $this->getHTMLBasedOnLoggedIn($message) . '

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
            $html = '<h2>Not logged in</h2>';
        }
        return $html;
    }

    private function getHTMLBasedOnLoggedIn($message)
    {
        if ($this->isLoggedIn()) {
            return $this->loginView->renderLoggedIn($message);
        } else {
            return $this->loginView->renderLogin($message);
        }
    }

    private function isLoggedIn()
    {
        return $_COOKIE[self::$cookieName] ?? null;
    }

    public function getUsername()
    {
        return $this->loginView->getUsername();
    }

    public function getPassword()
    {
        return $this->loginView->getPassword();
    }

    public function setLoggedIn()
    {
        $this->cookie = new \Model\Cookie(self::$cookieName, 'validated', time() + (60 * 60 * 24 * 30));
        $this->refreshPage();
    }

    private function refreshPage()
    {
        header("Location: ./");
        exit();
    }
}
