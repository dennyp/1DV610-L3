<?php

namespace Model;

require_once 'DatabaseHandler.php';
require_once 'UserStorage.php';

class Auth extends DatabaseHandler
{
    private $sessionId;
    private static $sessionName = 'SessionId';
    private $userStorage;
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->sessionId = session_id();
        $this->userStorage = new UserStorage();
    }

    public function loginWithCredentials(LoginCredentials $credentials)
    {
        $userId = $this->userStorage->findUserId($credentials->getUsername());

        if (!$userId || !$this->verifyUserPassword($credentials)) {
            throw new WrongUsernameOrPasswordException();
        }

        $this->setSessionInClient();
        $this->setSessionInDb($userId);
    }

    private function verifyUserPassword(LoginCredentials $credentials): bool
    {
        $this->user = $this->userStorage->findOneUser($credentials->getUsername());
        return password_verify($credentials->getPassword(), $this->user->getPassword());
    }

    private function setSessionInClient()
    {
        session_regenerate_id();
        $_SESSION[self::$sessionName] = $this->user->getUsername();
    }

    public function setSessionInDb(string $userId)
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            $query = "REPLACE INTO session (SessionId, UserId) Values (?,?)";

            if ($statement = $this->getConnection()->prepare($query)) {
                $statement->bind_param('ss', $this->sessionId, $userId);
                $statement->execute();
                $statement->close();
            }
            $this->getConnection()->close();
        }
    }

    public function checkValidSession(): bool
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            $query = "SELECT * FROM session WHERE SessionId=?";
            if ($statement = $this->getConnection()->prepare($query)) {
                $statement->bind_param('s', $this->sessionId);
                $statement->execute();
                $queryResult = $statement->get_result();
                $statement->close();
            }
            $this->getConnection()->close();

            while ($row = $queryResult->fetch_assoc()) {
                return $row[self::$sessionName] === $this->sessionId;
            }
        }
        return false;
    }

    public function removeSession()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            $query = "DELETE FROM session WHERE SessionId=?";
            if ($statement = $this->getConnection()->prepare($query)) {
                $statement->bind_param('s', $this->sessionId);
                $statement->execute();
                $statement->close();
            }
            $this->getConnection()->close();
        }
    }

    public function isUserLoggedIn(): bool
    {
        return isset($_SESSION[self::$sessionName]);
    }
}
