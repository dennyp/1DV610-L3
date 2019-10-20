<?php

namespace Model;

require_once 'DatabaseHandler.php';
require_once 'User.php';

class UserStorage extends DatabaseHandler
{
    public function addUser(string $name, string $password)
    {
        $name = $this->removeWhitespace($name);
        $password = $this->removeWhitespace($password);

        if ($this->isNotNullOrEmpty($name) &&
            $this->isNotNullOrEmpty($password)) {
            $query = 'INSERT INTO user (Username, Password) VALUES (?, ?)';

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            if ($statement = $this->getConnection()->prepare($query)) {
                $statement->bind_param('ss', $name, $passwordHash);
                $statement->execute();
                $userId = $statement->insert_id;
                $statement->close();
            }
            $this->getConnection()->close();
        }
    }

    private function removeWhitespace(string $str): string
    {
        return trim($str);
    }

    private function isNotNullOrEmpty($param)
    {
        return !is_null($param) && $param !== '';
    }

    public function findUserId(string $username)
    {
        $query = "SELECT UserId FROM user WHERE BINARY username=?";
        if ($statement = $this->getConnection()->prepare($query)) {
            $statement->bind_param('s', $username);
            $statement->execute();
            $statement->bind_result($userId);
            $statement->fetch();
            $statement->close();
        }
        $this->getConnection()->close();
        return $userId;
    }

    public function findOneUser(string $username): \Model\User
    {
        $query = "SELECT username, password FROM user WHERE BINARY username=?";
        if ($statement = $this->getConnection()->prepare($query)) {
            $statement->bind_param('s', $username);
            $statement->execute();
            $statement->bind_result($dbUsername, $dbPassword);
            $statement->fetch();
            $statement->close();

            $user = new \Model\User($dbUsername, $dbPassword);
        }
        $this->getConnection()->close();

        return $user;
    }

    private function getAllUsers(string $username)
    {
        $conn = $this->getConnection();
        $query = "SELECT * FROM user";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function isUsernameExisting(string $username): bool
    {
        $query = "SELECT username FROM user WHERE BINARY username=?";
        if ($statement = $this->getConnection()->prepare($query)) {
            $statement->bind_param('s', $username);
            $statement->execute();
            $statement->bind_result($user);
            $statement->fetch();
            $statement->close();
        }
        $this->getConnection()->close();
        var_dump($user);
        return !is_null($user);
    }
}
