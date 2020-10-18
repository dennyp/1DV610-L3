<?php

require_once 'LoginApp/LoginApp.php';
require_once 'CalculatorApp/CalculatorApp.php';

class App
{
  private $loginApp;
  private $calculatorApp;

  public function __construct()
  {
    $this->loginApp = new LoginApp();
    $this->calculatorApp = new CalculatorApp();
    $this->calculatorView = $this->calculatorApp->getCalculatorView();
  }

  public function run()
  {
    session_start();

    $this->loginApp->run($this->calculatorView);

    if ($this->loginApp->isUserLoggedIn()) {
      $this->calculatorApp->run();
    }
  }
}