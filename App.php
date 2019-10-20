<?php

require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';
require_once 'view/LoginView.php';
require_once 'model/User.php';
require_once 'controller/LayoutController.php';

session_start();

class App
{
    private $loginView;
    private $layoutView;

    private $user;

    private $loginController;
    private $layoutController;

    public function __construct()
    {
        $this->loginView = new \View\LoginView();
        $this->layoutView = new \View\LayoutView($this->loginView);

        $this->layoutController = new \Controller\LayoutController($this->layoutView);
    }

    public function run()
    {
        $this->layoutController->render();
    }
}
