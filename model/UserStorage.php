<?php

namespace Model;

require_once 'DatabaseHandler.php';
require_once 'User.php';

class UserStorage extends DatabaseHandler
{
    public function addUser(string $name, string $password): int
    {
        $name = $this->removeWhitespace($name);
        $password = $this->removeWhitespace($password);

        $query = 'INSERT INTO user (Username, Password) VALUES (?, ?)';

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        if ($statement = $this->getConnection()->prepare($query)) {
            $statement->bind_param('ss', $name, $passwordHash);
            $statement->execute();
            $userId = $statement->insert_id;
            $statement->close();
        }
        $this->getConnection()->close();

        return $userId;
    }

    private function removeWhitespace(string $str): string
    {
        return trim($str);
    }

    public function findUserId(string $username)
    {
        $query = "SELECT UserId FROM user WHERE username=?";
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

    public function findOneUser(string $username)
    {
        $query = "SELECT username, password FROM user WHERE username=?";
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
}
