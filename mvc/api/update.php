<?php

header("Content-Type: application/json");

require 'koneksi.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$id       = $data['id'];
$nama     = $data['nama_barang'];
$jumlah   = $data['jumlah'];
$harga    = $data['harga'];
$tanggal  = $data['tanggal_masuk'];
$kategori = $data['kategori'];

$sql = "UPDATE barang SET

    nama_barang   = '$nama',
    jumlah        = '$jumlah',
    harga         = '$harga',
    tanggal_masuk = '$tanggal',
    kategori      = '$kategori'

WHERE id = '$id'";

if ($conn->query($sql)) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data berhasil diupdate"
    ]);

} else {

    echo json_encode([
        "status"  => "error",
        "message" => "Data gagal diupdate"
    ]);

}

?>