<?php

namespace Controller;

class CalculatorController
{
  private $result = '0';


  public function addToResult(string $newValue)
  {
    $this->result .= $newValue;
  }

  public function getResult(): string
  {
    return $this->result;
  }

  public function add(float $num1, float $num2)
  {
    return $num1 + $num2;
  }
}
