<?php

namespace Controller;

require_once 'model/Auth.php';
require_once 'model/UserStorage.php';
require_once 'model/Util.php';

class LoginController
{
    private $view;
    private $session;
    private $message;
    private $userStorage;

    public function __construct(\View\LoginView $loginView)
    {
        $this->view = $loginView;
        $this->session = new \Model\Auth();
        $this->message = '';
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
        if ($this->view->isRegistering()) {
            $this->view->render();
            $this->saveUserOnPost();
        } else {
            if ($this->isNoValidSession()) {
                $this->checkInputFields();
            } else if ($this->view->isLoggingOut()) {
                $this->logout();
            }

            $this->view->render($this->getMessage());
        }
    }

    private function isNoValidSession(): bool
    {
        return !$this->session->checkValidSession();
    }



    private function logout()
    {
        $this->setMessage('Bye bye!');
        $this->session->removeSession();
    }

    private function isUserNotNull(\Model\User $user): bool
    {
        return \Model\Util::isNotNull($user->getUsername()) && \Model\Util::isNotNull($user->getPassword());
    }

    private function saveUserOnPost()
    {
        if ($this->view->isRegisteringUser()) {
            $user = new \Model\User($this->view->getUsernamePostback(),
                $this->view->getPasswordPostback());
            if ($this->isUserNotNull($user)) {
                $this->userStorage->addUser($user);
                $this->setMessage('Registered new user.');
                // TODO: Should redirect to index $this->view->goToMainPage();
            }
        }
    }
}
