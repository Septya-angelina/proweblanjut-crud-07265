<?php

require_once '../config/database.php';
require_once '../app/models/user.php';

class AuthController {

    private $user;

    public function __construct($db)
    {
        $this->user = new User($db);
    }

    public function login()
    {
        session_start();

        $error = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $result = $this->user->login($username);

            if ($result->num_rows == 1) {

                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    if (isset($_POST['remember'])) {

                        $token = bin2hex(random_bytes(16));

                        $this->user->updateRemember(
                            $token,
                            $user['id']
                        );

                        setcookie(
                            "remember_token",
                            $token,
                            time() + 86400,
                            "/"
                        );
                    }

                    header('Location: index.php');
                    exit();
                }
                else {
                    $error = "Password salah";
                }
            }
            else {
                $error = "Username tidak ditemukan";
            }
        }

        require '../app/views/auth/login.php';
    }

    public function register()
    {
        session_start();

        $message = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $confirm  = trim($_POST['confirm']);

            if ($password != $confirm) {

                $message = "Password tidak sama";
            }
            else {

                $check = $this->user->checkUsername(
                    $username
                );

                if ($check->num_rows > 0) {

                    $message = "Username sudah digunakan";
                }
                else {

                    if (
                        $this->user->register(
                            $username,
                            $password
                        )
                    ) {

                        $message = "Register berhasil";
                    }
                }
            }
        }

        require '../app/views/auth/register.php';
    }

    public function logout()
    {
        session_start();

        session_destroy();

        setcookie(
            "remember_token",
            "",
            time() - 3600,
            "/"
        );

        header('Location: login.php');
    }
}

?>