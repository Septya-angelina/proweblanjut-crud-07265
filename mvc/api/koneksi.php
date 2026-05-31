<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "pwl_07265";

$conn = new mysqli(
    $host,
    $user,
    $pass,
    $db
);

if ($conn->connect_error) {
    die("Koneksi gagal");
}

?>