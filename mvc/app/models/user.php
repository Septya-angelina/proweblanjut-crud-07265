<?php

class User {

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($username, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare(
            "INSERT INTO users(username,password)
            VALUES(?,?)"
        );

        $stmt->bind_param("ss", $username, $hash);

        return $stmt->execute();
    }

    public function checkUsername($username)
    {
        $stmt = $this->conn->prepare(
            "SELECT id FROM users WHERE username=?"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function login($username)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM users
            WHERE username=?
            LIMIT 1"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function updateRemember($token, $id)
    {
        $stmt = $this->conn->prepare(
            "UPDATE users
            SET remember_token=?
            WHERE id=?"
        );

        $stmt->bind_param("si", $token, $id);

        return $stmt->execute();
    }
}

?>