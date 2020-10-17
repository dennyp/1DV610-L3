<?php

namespace Controller;

require_once 'model/Auth.php';
require_once 'model/Util.php';
require_once 'model/exceptions/LoginException.php';

class LoginController
{
    private $view;
    private $auth;

    public function __construct(\View\LoginView $loginView)
    {
        $this->view = $loginView;
        $this->auth = new \Model\Auth();
    }

    public function tryToLogin()
    {
        try {
            if ($this->view->isLoggingIn()) {
                $loginCredentials = $this->view->getLoginCredentials();
                $this->auth->loginWithCredentials($loginCredentials);
                $this->view->setWelcomeMessage();
            } else if ($this->view->isLoggingOut()) {
                $this->logout();
            }
        } catch (\View\MissingUsernameException $error) {
            $this->view->setUsernameMissingMessage();
        } catch (\View\MissingPasswordException $error) {
            $this->view->setPasswordMissingMessage();
        } catch (\Model\WrongUsernameOrPasswordException $error) {
            $this->view->setWrongUsernameOrPasswordMessage();
        }
    }

    private function isNoValidSession(): bool
    {
        return !$this->session->checkValidSession();
    }

    private function logout()
    {
        $this->view->setLogoutMessage();
        $this->auth->removeSession();
    }
}
