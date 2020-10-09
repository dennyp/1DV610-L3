<?php

namespace View;

class LayoutView
{
    private static $registerName = 'register';

    public function render($isUserLoggedIn, $loginView, $registerView, $dateTimeView, $message = '')
    {
        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderLoggedInHTML($isUserLoggedIn) . '

          <div class="container">
              ' . $this->getHTMLBasedOnLoggedInOrRegister($loginView, $registerView, $message) . '

              ' . $dateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
    }

    private function renderLoggedInHTML($isUserLoggedIn)
    {
        $html = '';
        if ($isUserLoggedIn) {
            $html = '<h2>Logged in</h2>';
        } else {
            $html = $this->renderLink();
            $html .= '<h2>Not logged in</h2>';
        }
        return $html;
    }

    private function getHTMLBasedOnLoggedInOrRegister($loginView, $registerView, $message)
    {
        if ($this->isRegistering()) {
            return $registerView->render();
        } else {
            return $loginView->render($message);
        }
    }

    public function isRegistering(): bool
    {
        return isset($_GET[self::$registerName]);
    }


    private function renderLink()
    {
        if (!isset($_GET[self::$registerName])) {
            return '<a href="./index.php?' . self::$registerName . '">Register a new user</a>';
        }

        return '<a href=?>Back to login</a>';
    }
}
