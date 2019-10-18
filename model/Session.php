<?php

namespace Model;

require_once 'DatabaseHandler.php';

class Session extends DatabaseHandler
{

    private static $sessionName;

    public function __construct()
    {
        parent::__construct();
    }

    public function setSession(string $sessionId, string $userId)
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            $query = "REPLACE INTO session (SessionId, UserId) Values (?,?)";

            if ($statement = $this->getConnection()->prepare($query)) {
                $statement->bind_param('ss', $sessionId, $userId);
                $statement->execute();
                $statement->close();
            }
            $this->getConnection()->close();
        }
    }

    public function startNewSession($name)
    {
        session_regenerate_id();
        $_SESSION[self::$sessionName] = $name;
    }
}
