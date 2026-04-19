<?php
session_start();
include "koneksi.php";

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (!empty($_COOKIE["remember_token"])) {
    $token = trim($_COOKIE["remember_token"]);

    $stmt = $conn->prepare("SELECT id, username FROM users WHERE remember_token = ? LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        $_SESSION["user_id"]  = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: index.php");
        exit();
    }
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        die("Akses tidak sah");
    }

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        $error = "Username dan password tidak boleh kosong!";
    } elseif (!preg_match("/[a-zA-Z0-9]/", $username)) {
        $error = "Username tidak boleh hanya simbol atau spasi!";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                session_regenerate_id(true);

                $_SESSION["user_id"]  = $user["id"];
                $_SESSION["username"] = $user["username"];

                if (isset($_POST["remember"])) {
                    $token = bin2hex(random_bytes(16));

                    $stmt2 = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                    $stmt2->bind_param("si", $token, $user["id"]);
                    $stmt2->execute();

                    setcookie("remember_token", $token, time() + 20, "/", "", false, true);
                } else {
                    setcookie("remember_token", "", time() - 3600, "/");
                }

                header("Location: index.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
body{
    font-family: Arial;
    background:#f4f6fb;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    background:white;
    padding:30px;
    border-radius:12px;
    width:320px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    color:#5a78b5;
}

.input-group{
    margin-bottom:15px;
}

.input-group input{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:6px;
}

.remember{
    display:flex;
    align-items:center;
    gap:6px;
    margin-bottom:15px;
}

button{
    width:100%;
    padding:10px;
    background:#6c8ecf;
    color:white;
    border:none;
    border-radius:6px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#5a78b5;
}

.error{
    color:red;
    text-align:center;
    margin-bottom:10px;
}

.link{
    text-align:center;
    margin-top:10px;
}
</style>
</head>

<body>

<div class="box">
<h2>Login</h2>

<?php if ($error): ?>
<div class="error"><?= htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="POST">

<input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">

<div class="input-group">
<input type="text" name="username" placeholder="Username" required>
</div>

<div class="input-group">
<input type="password" name="password" placeholder="Password" required>
</div>

<div class="remember">
<input type="checkbox" name="remember">
<label>Ingat Saya</label>
</div>

<button type="submit">Login</button>

</form>

<div class="link">
Belum punya akun? <a href="register.php">Register</a>
</div>

</div>

</body>
</html>