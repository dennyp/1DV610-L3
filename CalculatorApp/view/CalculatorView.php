<?php

namespace View;

class CalculatorView
{
  private $result;
  private $previousValue = 0;
  private static $clearEntry = 'CE';
  private static $clear = 'C';
  private static $division = 'division';
  private static $multiplication = 'multiplication';
  private static $subtraction = 'subtraction';
  private static $addition = 'addition';
  private static $equals = '=';
  private static $plusminus = '-/+';
  private static $number1 = '1';
  private static $number2 = '2';
  private static $number3 = '3';
  private static $number4 = '4';
  private static $number5 = '5';
  private static $number6 = '6';
  private static $number7 = '7';
  private static $number8 = '8';
  private static $number9 = '9';
  private static $number0 = '0';

  public function setDisplayResult($result)
  {
    $this->result = $this->result . $result;
  }

  public function isClearingLastEntry(): bool
  {
    return isset($_POST[self::$clearEntry]);
  }

  public function isClearingResult(): bool
  {
    return isset($_POST[self::$clear]);
  }

  public function isDividing(): bool
  {
    return isset($_POST[self::$division]);
  }

  public function isMultiplying(): bool
  {
    return isset($_POST[self::$multiplication]);
  }

  public function isSubtracting(): bool
  {
    return isset($_POST[self::$subtraction]);
  }

  public function isAdding(): bool
  {
    return isset($_POST[self::$addition]);
  }

  public function isChangingSign(): bool
  {
    return isset($_POST[self::$plusminus]);
  }

  public function isNumberOneSet(): bool
  {
    return isset($_POST[self::$number1]);
  }

  public function isNumberTwoSet(): bool
  {
    return isset($_POST[self::$number2]);
  }

  public function previousValue(): float
  {
    return $this->previousValue;
  }

  public function isNumber()
  {
    return isset($_POST[self::$number1]) || isset($_POST[self::$number2]) || isset($_POST[self::$number3]) ||
      isset($_POST[self::$number4]) || isset($_POST[self::$number5]) || isset($_POST[self::$number6]) ||
      isset($_POST[self::$number7]) || isset($_POST[self::$number8]) || isset($_POST[self::$number9]);
  }

  public function isOperator()
  {
    return isset($_POST[self::$division]) || isset($_POST[self::$multiplication]) ||
      isset($_POST[self::$addition]) || isset($_POST[self::$subtraction]);
  }

  public function getNumberValue(): string
  {
    foreach ($_POST as $key => $value) {
      return $_POST[$key];
    }
  }

  public function generateDisplay(): string
  {
    return '    
      <div class="row col-6">
        <span>' . $this->result . '</span>
      </div>
      ';
  }

  public function generateCalculatorHTML($isUserLoggedIn)
  {
    if ($isUserLoggedIn) {
      return '
    <form method="post">
      <h3>Superduper Calculator 3000</h3>
      ' . $this->generateDisplay() . '
      <div class="row">
        <div class="btn-group col-6" role="group">
          <button type="submit" class="btn btn-primary border-secondary">' . self::$plusminus . '</button>
          <button type="submit" class="btn btn-primary border-secondary">' . self::$clearEntry . '</button>
          <button type="submit" class="btn btn-primary border-secondary">' . self::$clear . '</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$division . '">÷</button>
        </div>
      </div>
      <div class="row">
        <div class="btn-group col-6" role="group">
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$number7 . '" value="' . self::$number7 . '">7</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$number8 . '" value="' . self::$number8 . '">8</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$number9 . '" value="' . self::$number9 . '">9</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$multiplication . '">×</button>
        </div>
      </div>
      <div class="row">
        <div class="btn-group col-6" role="group">
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$number4 . '">4</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$number5 . '">5</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$number6 . '">6</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$subtraction . '">-</button>
        </div>
      </div>
      <div class="row">
        <div class="btn-group col-6" role="group">
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$number1 . '">1</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$number2 . '">2</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$number3 . '">3</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$addition . '">+</button>
        </div>
      </div>
      <div class="row">
        <div class="btn-group col-6" role="group">
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$number0 . '">0</button>
          <button type="submit" class="btn btn-primary border-secondary">,</button>
          <button type="submit" class="btn btn-primary border-secondary" name="' . self::$equals . '">=</button>
        </div>
      </div>
    </form>
    ';
    }
  }
}
