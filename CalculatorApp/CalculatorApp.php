<?php

require_once 'CalculatorApp/view/CalculatorView.php';
require_once 'CalculatorApp/controller/CalculatorController.php';

class CalculatorApp
{
  private $calculatorView;
  private $calculatorController;

  public function __construct()
  {
    $this->calculatorView = new \View\CalculatorView();
    $this->calculatorController = new \Controller\CalculatorController();
  }

  public function run()
  {
    // $this->calculatorView->generateCalculatorHTML();
  }

  public function getCalculatorView()
  {
    return $this->calculatorView;
  }
}