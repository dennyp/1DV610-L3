<?php

namespace Model;

require_once 'DatabaseHandler.php';

class Session extends DatabaseHandler
{
    private $sessionId;
    private static $sessionName = 'SessionId';

    public function __construct()
    {
        parent::__construct();
        $this->sessionId = session_id();
    }

    public function setSession(string $userId)
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
}
