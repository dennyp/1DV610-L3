<?php

namespace Controller;

require_once 'model/Auth.php';
require_once 'model/Session.php';

class LayoutController
{

    private $view;
    private $user;
    private $message;
    private $auth;
    private $session;

    public function __construct(\View\LayoutView $view)
    {
        $this->view = $view;
        $this->message = '';
        $this->auth = new \Model\Auth();
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
        if ($this->isUsernameNotNull() && $this->isUsernameEmpty()) {
            $this->setMessage('Username is missing');
        } else if ($this->isPasswordNotNull() && $this->isPasswordEmpty()) {
            $this->setMessage('Password is missing');
        } else if ($this->isUserNameNotNull() && $this->isPasswordNotNull()) {
            $user = new \Model\User($this->view->getUsername(), $this->view->getPassword());
            $validated = $this->auth->validateUser($user);
            $this->setValidationMessage($validated);

            if ($validated) {
                $userId = $user->findUserId($this->view->getUsername());

                session_start();
                $this->session = new \Model\Session();
                $this->session->setSession(session_id(), $userId);
            }
        } else if ($this->view->isLoggingOut()) {
            $this->setMessage('Bye bye!');
            $this->view->deleteLoggedInCookie();
        }

        $this->view->render($this->getMessage());
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

    private function validateUserAndSetSession()
    {
        $validated = $this->validateUser();

        $this->setValidationMessage($validated);

        if ($validated) {
            $this->view->setLoggedInCookie();
        }
    }

    private function setValidationMessage($validated)
    {
        if (!$validated) {
            $this->setMessage('Wrong name or password');
        } else {
            // TODO : This message must be shown when logging in.
            // As of now, we "refresh" the page and message is reset.
            $this->setMessage('Welcome');
        }
    }
}
