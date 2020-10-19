<?php

namespace View;

class CalculatorView
{
  private $result = 0;
  private static $clearEntry = 'CE';
  private static $clear = 'C';
  private static $division = '÷';
  private static $multiplication = '×';
  private static $subtraction = '-';
  private static $addition = '+';
  private static $equals = '=';
  private static $plusminus = '-/+';

  public function generateCalculatorHTML($isUserLoggedIn)
  {
    if ($isUserLoggedIn) {
      return '
    <h3>Superduper Calculator 3000</h3>
    <div class="row col-6">
      <span>' . $this->result . '</span>
    </div>
    <div class="row">
      <div class="btn-group col-6" role="group">
      <button type="button" class="btn btn-primary border-secondary">' . self::$plusminus . '</button>
        <button type="button" class="btn btn-primary border-secondary">' . self::$clearEntry . '</button>
        <button type="button" class="btn btn-primary border-secondary">' . self::$clear . '</button>
      </div>
    </div>
    <div class="row">
      <div class="btn-group col-6" role="group">
        <button type="button" class="btn btn-primary border-secondary">7</button>
        <button type="button" class="btn btn-primary border-secondary">8</button>
        <button type="button" class="btn btn-primary border-secondary">9</button>
        <button type="button" class="btn btn-primary border-secondary">' . self::$multiplication . '</button>
      </div>
    </div>
    <div class="row">
      <div class="btn-group col-6" role="group">
        <button type="button" class="btn btn-primary border-secondary">4</button>
        <button type="button" class="btn btn-primary border-secondary">5</button>
        <button type="button" class="btn btn-primary border-secondary">6</button>
        <button type="button" class="btn btn-primary border-secondary">' . self::$subtraction . '</button>
      </div>
    </div>
    <div class="row">
      <div class="btn-group col-6" role="group">
        <button type="button" class="btn btn-primary border-secondary">1</button>
        <button type="button" class="btn btn-primary border-secondary">2</button>
        <button type="button" class="btn btn-primary border-secondary">3</button>
        <button type="button" class="btn btn-primary border-secondary">' . self::$addition . '</button>
      </div>
    </div>
    <div class="row">
      <div class="btn-group col-6" role="group">
        <button type="button" class="btn btn-primary border-secondary">0</button>
        <button type="button" class="btn btn-primary border-secondary">,</button>
        <button type="button" class="btn btn-primary border-secondary">' . self::$equals . '</button>
      </div>
    </div>
    ';
    }
  }
}
