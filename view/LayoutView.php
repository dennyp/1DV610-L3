<?php

namespace View;

require_once 'model/User.php';
require_once 'model/DateTimeGenerator.php';

class LayoutView
{

    private $user;
    private $view;
    private $date;
    private $dateTimeView;

    public function __construct($view)
    {
        $this->view = $view;
        $this->user = new \Model\User();

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
          ' . $this->isLoggedIn() . '

          <div class="container">
              ' . $this->view->render($message) . '

              ' . $this->dateTimeView->show() . '
          </div>
         </body>
      </html>
    ';
    }

    private function isLoggedIn()
    {
        if ($this->user->isLoggedIn()) {
            return '<h2>Logged in</h2>';
        } else {
            return '<h2>Not logged in</h2>';
        }
    }
}
