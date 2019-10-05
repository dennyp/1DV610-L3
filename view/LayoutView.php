<?php

namespace View;

require_once 'model/User.php';

class LayoutView
{
    private $user;
    private $view;
    private $dateTimeView;

    public function __construct($view)
    {
        $this->user = new \model\User();
        $this->view = $view;
        $this->dateTimeView = new DateTimeView();
    }

    public function render()
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
              ' . $this->view->render('') . '

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
