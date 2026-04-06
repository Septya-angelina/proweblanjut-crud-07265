<?php
session_start();
include "koneksi.php";

$message = "";
$class = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm  = trim($_POST["confirm"]);

    if (empty($username) || empty($password) || empty($confirm)) {
        $message = "Semua field wajib diisi!";
        $class = "error";
    }
    elseif (!preg_match("/[a-zA-Z0-9]/", $username)) {
        $message = "Username tidak boleh hanya simbol atau spasi!";
        $class = "error";
    }
    elseif (strlen($password) < 6) {
        $message = "Password minimal 6 karakter!";
        $class = "error";
    }
    elseif ($password !== $confirm) {
        $message = "Password tidak sama!";
        $class = "error";
    }
    else {
        // cek username
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Username sudah digunakan!";
            $class = "error";
        } else {
            // hash password
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hash);

            if ($stmt->execute()) {
                $message = "Registrasi Berhasil! Silakan Login";
                $class = "success";
            } else {
                $message = "Terjadi Kesalahan!";
                $class = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<style>
body {
    font-family: Arial;
    background-color: #f4f6fb;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.register-box {
    background: white;
    padding: 30px;
    border-radius: 12px;
    width: 320px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    color: #5a78b5;
}

.input-group {
    margin-bottom: 15px;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-top: 5px;
}

button {
    width: 100%;
    background: #6c8ecf;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 6px;
    font-weight: bold;
}

button:hover {
    background: #5a78b5;
}

.message {
    text-align: center;
    font-size: 13px;
    margin-bottom: 10px;
}

.error {
    color: red;
}

.success {
    color: green;
}

.link-login {
    text-align: center;
    margin-top: 10px;
    font-size: 13px;
}
</style>
</head>

<body>

<div class="register-box">
<h2>Register</h2>

<?php if ($message) echo "<div class='message $class'>$message</div>"; ?>

<form method="POST">
    <div class="input-group">
    <input type="text" name="username" placeholder="Username" required>
    </div>

    <div class="input-group">
    <input type="password" name="password" placeholder="Password" required>
    </div>

    <div class="input-group">
    <input type="password" name="confirm" placeholder="Konfirmasi Password" required>
    </div>

    <button type="submit">Register</button>

</form>

<div class="link-login"> Sudah punya akun? <a href="login.php">Login</a>
</div>

</div>

</body>
</html>