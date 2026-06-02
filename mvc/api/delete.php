<?php

header("Content-Type: application/json");

require 'koneksi.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$id = $data['id'];

$sql = "DELETE FROM barang WHERE id = '$id'";

if ($conn->query($sql)) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data berhasil dihapus"
    ]);

} else {

    echo json_encode([
        "status"  => "error",
        "message" => "Data gagal dihapus"
    ]);

}

?>