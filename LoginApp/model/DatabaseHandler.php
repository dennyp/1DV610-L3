<?php

namespace Model;

class DatabaseHandler
{
    private $server;
    private $username;
    private $password;
    private $db;
    private $conn;

    public function __construct()
    {
        $this->setupDatabaseVariables();
    }

    protected function getConnection()
    {
        $this->conn = new \mysqli($this->server, $this->username, $this->password, $this->db);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    private function setupDatabaseVariables()
    {
        $url = parse_url(getenv('DATABASE_URL'));
        $this->server = $url["host"];
        $this->username = $url["user"];
        $this->password = $url["pass"];
        $this->db = substr($url["path"], 1);
    }
}
