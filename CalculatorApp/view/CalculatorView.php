<?php

namespace View;

class CalculatorView
{
  private static $clearEntry = 'CE';
  private static $clear = 'C';
  private static $division = '÷';
  private static $multiplication = '×';
  private static $subtraction = '-';
  private static $addition = '+';
  private static $equals = '=';

  public function generateCalculatorHTML($isUserLoggedIn)
  {
    if ($isUserLoggedIn) {
      return '
    <h3>Superduper Calculator 3000</h3>
    <div class="row">
      <div class="col">
        <button type="button" class="btn btn-primary">' . self::$clearEntry . '</button>
      </div>
    </div>
    ';
    }
  }
}
