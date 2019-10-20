<?php

namespace Model;

require_once 'DatabaseHandler.php';
require_once 'User.php';
require_once 'UserRule.php';
require_once 'Util.php';

class UserStorage extends DatabaseHandler
{
    private $userRule;

    public function __construct()
    {
        parent::__construct();
        $this->userRule = new \Model\UserRule();
    }

    public function addUser(\Model\User $user)
    {
        $name = Util::removeWhitespace($user->getUsername());
        $password = Util::removeWhitespace($user->getPassword());

        if (Util::isNotNullOrEmpty($name) &&
            Util::isNotNullOrEmpty($password) &&
            Util::hasNoBadCharacters($name) &&
            Util::hasNoBadCharacters($password) &&
            $this->userRule->isAboveMinimumUsernameLength($name) &&
            $this->userRule->isAboveMinimumPasswordLength($password)) {

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

    public function findUserId(string $username): string
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
            $this->getConnection()->close();

            return new \Model\User($dbUsername, $dbPassword);
        }
    }

    private function getAllUsers(string $username): array
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
        return !is_null($user);
    }
}
