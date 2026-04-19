<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION["user_id"]) && isset($_COOKIE["remember_token"])) {

    $token = $_COOKIE["remember_token"];

    $stmt = $conn->prepare("SELECT id FROM users WHERE remember_token=?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION["user_id"] = $user["id"];
    }
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT gambar FROM barang WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!empty($data['gambar']) && file_exists("uploads/" . $data['gambar'])) {
    unlink("uploads/" . $data['gambar']);
}

$stmt = $conn->prepare("DELETE FROM barang WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit();
?>