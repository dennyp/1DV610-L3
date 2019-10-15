<?php

namespace Controller;

class LayoutController
{

    private $view;
    private $user;
    private $message;

    public function __construct(\View\LayoutView $view)
    {
        $this->view = $view;
        $this->user = new \Model\User();
        $this->message = '';
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
            $validated = $this->user->validateUser
                ($this->view->getUsername(), $this->view->getPassword());

            $this->setValidatedMessage($validated);

            if ($validated) {
                $this->view->setLoggedIn();
            }
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

    private function setValidatedMessage($validated)
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
