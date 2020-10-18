<?php

namespace View;

class LayoutView
{
    private static $registerName = 'register';
    private $bootstrapCDN = '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';

    public function render($isUserLoggedIn, $view, DateTimeView $dateTimeView, \View\CalculatorView $calculatorView)
    {
        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          ' . $this->bootstrapCDN . '
          <title>Login Example</title>
        </head>
        <body>
            <div class="container">
                <h1>Assignment 2</h1>
                ' . $this->renderLoggedInHTML($isUserLoggedIn) . '

                    ' . $view->render() . '
                    ' . $calculatorView->generateCalculatorHTML($isUserLoggedIn) . '
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
