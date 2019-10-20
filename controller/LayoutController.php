<?php

namespace Controller;

require_once 'model/Auth.php';
require_once 'model/Session.php';
require_once 'model/UserStorage.php';
require_once 'view/RegisterView.php';

class LayoutController
{
    private $view;
    private $user;
    private $message;
    private $auth;
    private $session;
    private $userStorage;

    public function __construct(\View\LayoutView $view)
    {
        $this->view = $view;
        $this->message = '';
        $this->auth = new \Model\Auth();
        $this->userStorage = new \Model\UserStorage();
    }

    private function getMessage()
    {
        return $this->message;
    }

    private function setMessage($message)
    {
        $this->message = $message;
    }

    public function render()
    {
        $this->renderPage();
    }

    private function renderPage()
    {
        if ($this->view->getRegister()) {
            $this->view->render();
            if ($this->view->isRegisteringUser()) {
                $username = $this->view->getUsernamePostback();
                $password = $this->view->getPasswordPostback();
                if (!is_null($username) && !is_null($password)) {
                    $this->userStorage->addUser($username, $password);
                    $this->setMessage('Registered new user.');
                }
            }} else {
            $this->session = new \Model\Session();

            if (!$this->session->checkValidSession()) {
                if ($this->isUsernameNotNull() && $this->isUsernameEmpty()) {
                    $this->setMessage('Username is missing');
                } else if ($this->isPasswordNotNull() && $this->isPasswordEmpty()) {
                    $this->setMessage('Password is missing');
                } else if ($this->isUserNameNotNull() && $this->isPasswordNotNull()) {
                    $user = new \Model\User($this->view->getUsername(),
                        $this->view->getPassword());
                    $userStorage = new \Model\UserStorage();
                    $validated = $this->auth->validateUser($user);
                    $this->setValidationMessage($validated);

                    if ($validated) {
                        $userId = $userStorage->findUserId($this->view->getUsername());
                        $this->session->setSession($userId);
                    }
                }
            } else if ($this->view->isLoggingOut()) {
                $this->setMessage('Bye bye!');
                $this->session->removeSession();
            }

            $this->view->render($this->getMessage());
        }
    }

    private function isUserNameNotNull()
    {
        return !is_null($this->view->getUsername());
    }

    private function isUsernameEmpty()
    {
        return empty($this->view->getUsername());
    }

    private function isPasswordNotNull()
    {
        return !is_null($this->view->getPassword());
    }

    private function isPasswordEmpty()
    {
        return empty($this->view->getPassword());
    }

    private function setValidationMessage($validated)
    {
        if (!$validated) {
            $this->setMessage('Wrong name or password');
        } else {
            $this->setMessage('Welcome');
        }
    }
}
