<?php

namespace Controller;

require_once 'model/UserStorage.php';


class RegisterController
{
  private $userStorage;
  
  private function saveUser()
  {
    if ($this->view->isRegisteringUser()) {
      $user = new \Model\User(
        $this->view->getUsernamePostback(),
        $this->view->getPasswordPostback()
      );
      if ($this->isUserNotNull($user)) {
        $this->userStorage->addUser($user);
        $this->setMessage('Registered new user.');
        // TODO: Should redirect to index $this->view->goToMainPage();
      }
    }
  }

  private function isUserNotNull(\Model\User $user): bool
  {
    return \Model\Util::isNotNull($user->getUsername()) && \Model\Util::isNotNull($user->getPassword());
  }

  private function setMessage($message)
  {
      $this->message = $message;
  }
}
