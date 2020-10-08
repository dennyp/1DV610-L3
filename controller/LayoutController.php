<?php

namespace Controller;

require_once 'model/Auth.php';
require_once 'model/Auth.php';
require_once 'model/UserStorage.php';
require_once 'view/RegisterView.php';
require_once 'model/Util.php';

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
        $this->userStorage = new \Model\UserStorage();
        $this->session = new \Model\Auth();
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

    private function checkInputFields()
    {
        if ($this->isUsernameNotNull() && $this->isUsernameEmpty()) {
            $this->setMessage('Username is missing');
        } else if ($this->isPasswordNotNull() && $this->isPasswordEmpty()) {
            $this->setMessage('Password is missing');
        } else if ($this->isUsernameNotNull() && $this->isPasswordNotNull()) {
            $validated = $this->validateUser();
            $this->setSessionIfValidated($validated);
        }
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

    private function isUsernameNotNull(): bool
    {
        return !is_null($this->view->getUsername());
    }

    private function isUsernameEmpty(): bool
    {
        return empty($this->view->getUsername());
    }

    private function isPasswordNotNull(): bool
    {
        return !is_null($this->view->getPassword());
    }

    private function isPasswordEmpty(): bool
    {
        return empty($this->view->getPassword());
    }

    private function validateUser(): bool
    {
        $user = new \Model\User($this->view->getUsername(),
            $this->view->getPassword());
        $validated = $this->session->authUser($user);
        $this->setValidationMessage($validated);
        return $validated;
    }

    private function setValidationMessage(bool $validated)
    {
        if (!$validated) {
            $this->setMessage('Wrong name or password');
        } else {
            $this->setMessage('Welcome');
        }
    }

    private function setSessionIfValidated(bool $validated)
    {
        if ($validated) {
            $userStorage = new \Model\UserStorage();
            $userId = $userStorage->findUserId($this->view->getUsername());
            $this->session->setSession($userId);
        }
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
