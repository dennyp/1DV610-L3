<?php

namespace View;

class LayoutView
{
    private static $registerName = 'register';

    public function render($isUserLoggedIn, $view, DateTimeView $dateTimeView)
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
              ' . $view->render() . '

              ' . $dateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
    }

    private function renderLoggedInHTML($isUserLoggedIn): string
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

    private function renderLink(): string
    {
        if (!$this->isUserRegistering()) {
            return '<a href="./index.php?' . self::$registerName . '">Register a new user</a>';
        }

        return '<a href=?>Back to login</a>';
    }

    public function isUserRegistering(): bool
    {
        return isset($_GET[self::$registerName]);
    }
}
