<?php

require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';
require_once 'view/LoginView.php';
require_once 'model/User.php';
require_once 'controller/LoginController.php';
require_once 'controller/LayoutController.php';

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
        $this->loginController = new \Controller\LoginController($this->loginView);
    }

    public function run()
    {
        $this->layoutController->render();
    }
}
