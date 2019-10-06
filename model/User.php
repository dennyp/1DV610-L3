<?php

namespace Model;

require_once 'DatabaseHandler.php';

class User extends DatabaseHandler
{
    public function isLoggedIn()
    {
        // TODO : Check if user is logged in
        return false;
    }

    public function isUsernameExisting($username)
    {
        $stmt = $this->findUser($username);
        return \mysqli_stmt_num_rows($stmt) === 1;
    }

    public function validateUser($username, $password)
    {
        $user = $this->findOneUser($username);

        $dbUsername = $user['username'] ?? null;
        $dbPassword = $user['password'] ?? null;

        return $password === $dbPassword;
    }

    private function findUser($username)
    {
        $query = "SELECT * FROM user WHERE username=?";
        $stmt = \mysqli_stmt_init($this->getConnection());

        if (!\mysqli_stmt_prepare($stmt, $query)) {
            var_dump(\mysqli_error($this->getConnection()));
            exit();
        }

        \mysqli_stmt_bind_param($stmt, 's', $username);
        \mysqli_stmt_execute($stmt);
        \mysqli_stmt_store_result($stmt);
        return $stmt;
    }

    private function findOneUser(string $username)
    {
        $conn = $this->getConnection();
        $query = "SELECT username, password FROM user WHERE username=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($dbUsername, $dbPassword);
        $stmt->store_result();

        while ($stmt->fetch()) {
            $data = ["username" => $dbUsername, "password" => $dbPassword];
        }

        return $data ?? [];
    }

    private function getAllUsers($username)
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
