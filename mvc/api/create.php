<?php

header("Content-Type: application/json");

require 'koneksi.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$nama     = $data['nama_barang'];
$jumlah   = $data['jumlah'];
$harga    = $data['harga'];
$tanggal  = $data['tanggal_masuk'];
$kategori = $data['kategori'];

$sql = "INSERT INTO barang
(
    nama_barang,
    jumlah,
    harga,
    tanggal_masuk,
    kategori
)
VALUES
(
    '$nama',
    '$jumlah',
    '$harga',
    '$tanggal',
    '$kategori'
)";

if ($conn->query($sql)) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data berhasil ditambahkan"
    ]);

} else {

    echo json_encode([
        "status"  => "error",
        "message" => "Data gagal ditambahkan"
    ]);

}

?>