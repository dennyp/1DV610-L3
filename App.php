<?php

require_once 'LoginApp/LoginApp.php';

class App
{
  private $loginApp;
  private $calculatorApp;

  public function __construct()
  {
    $this->loginApp = new LoginApp();
  }

  public function run()
  {
    session_start();
    
    $this->loginApp->run();
  }
}
