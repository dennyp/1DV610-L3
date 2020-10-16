<?php

namespace Controller;

require_once 'model/Auth.php';
require_once 'model/Util.php';

class LoginController
{
    private $view;
    private $session;

    public function __construct(\View\LoginView $loginView)
    {
        $this->view = $loginView;
        $this->session = new \Model\Auth();
        $this->userStorage = new \Model\UserStorage();
    }

    public function tryToLogin()
    {
        if ($this->view->isLoggingIn()) {
            $this->view->checkInputFields();
        } else if ($this->view->isLoggingOut()) {
            $this->logout();
        }
    }

    private function isNoValidSession(): bool
    {
        return !$this->session->checkValidSession();
    }

    private function logout()
    {
        $this->view->setLogoutMessage();
        $this->session->removeSession();
    }
}
