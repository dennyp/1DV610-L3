<?php

require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';
require_once 'model/User.php';
require_once 'model/DateTimeGenerator.php';
require_once 'controller/LoginController.php';

class LoginApp
{
    private $loginView;
    private $layoutView;
    private $registerView;
    private $dateTimeView;

    private $loginController;

    public function __construct()
    {
        $this->loginView = new \View\LoginView();
        $this->layoutView = new \View\LayoutView($this->loginView);
        $this->registerView = new \View\RegisterView();

        $this->dateTime = new \Model\DateTimeGenerator();
        $this->dateTimeView = new \View\DateTimeView($this->dateTime->getTime());

        $this->loginController = new \Controller\LoginController($this->loginView);
    }

    public function run(\View\CalculatorView $calculatorView)
    {
        if ($this->isUserLoggingOut()) {
            $this->loginController->logout();
        } else {
            $this->loginController->tryToLogin();
        }

        if ($this->layoutView->isUserRegistering()) {
            $this->renderRegisterView($calculatorView);
        } else {
            $this->renderLoginView($calculatorView);
        }
    }

    public function isUserLoggedIn()
    {
        return $this->loginView->isUserLoggedIn();
    }

    private function isUserLoggingOut()
    {
        return $this->loginView->isLoggingOut();
    }

    private function renderRegisterView(\View\CalculatorView $calculatorView)
    {
        $this->layoutView->render($this->isUserLoggedIn(), $this->registerView, $this->dateTimeView, $calculatorView);
    }

    private function renderLoginView(\View\CalculatorView $calculatorView)
    {
        $this->layoutView->render($this->isUserLoggedIn(), $this->loginView, $this->dateTimeView, $calculatorView);
    }
}