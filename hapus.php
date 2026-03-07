<?php
include "koneksi.php";

$id = $_GET['id'];

$sql = "DELETE FROM barang WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

header("Location:index.php");
?>