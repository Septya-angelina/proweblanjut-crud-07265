<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'pwl_07265';

$pdo = new PDO(
    dsn: "mysql:host=$host;dbname=$dbname",
    username:"$user",
    password: "$pass"
);
if (!$pdo){
    die("koneksi gagal");
}
$conn = mysqli_connect(hostname: $host, username: $user, password: $pass, database: $dbname);
if ($conn->connect_error){
    die("koneksi tak berhasil" . $conn->connect_error);
}
?>