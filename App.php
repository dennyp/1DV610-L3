<?php

require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';
require_once 'model/User.php';
require_once 'model/DateTimeGenerator.php';
require_once 'controller/LoginController.php';

class App
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

    private function isUserLoggedIn()
    {
        return $this->loginView->isUserLoggedIn();
    }

    public function run()
    {
        session_start();
        $this->layoutView->render($this->isUserLoggedIn(), $this->loginView, $this->registerView, $this->dateTimeView);
    }
}
