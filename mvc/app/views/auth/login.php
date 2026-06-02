<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>

body{
    font-family:Arial;
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

<?php if (!empty($error)): ?>
<div class="error">
    <?= $error; ?>
</div>
<?php endif; ?>

<form method="POST">

<div class="input-group">
    <input
        type="text"
        name="username"
        placeholder="Username"
        required
    >
</div>

<div class="input-group">
    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >
</div>

<div class="remember">
    <input type="checkbox" name="remember">
    <label>Ingat Saya</label>
</div>

<button type="submit">
    Login
</button>

</form>

<div class="link">
    Belum punya akun?
    <a href="register.php">Register</a>
</div>

</div>

</body>
</html>