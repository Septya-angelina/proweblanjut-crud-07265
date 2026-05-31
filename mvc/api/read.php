<?php

header("Content-Type: application/json");

require 'koneksi.php';

$sql    = "SELECT * FROM barang";
$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

?>