<?php
include "koneksi.php";

$id = $_GET['id'];

$data = $conn->prepare("SELECT * FROM barang WHERE id=?");
$data->execute([$id]);
$row = $data->fetch();

if(isset($_POST['update'])){
    $nama = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $tanggal = $_POST['tanggal_masuk'];
    $kategori = $_POST['kategori'];

$sql = "UPDATE barang SET 
nama_barang=?,
jumlah=?,
harga=?,
tanggal_masuk=?,
kategori=?
WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->execute([$nama,$jumlah,$harga,$tanggal,$kategori,$id]);

header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Barang</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:#eef2f7;
    margin:0;
}

.container{
    width:45%;
    margin:auto;
    margin-top:50px;
}

.card{
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

h2{
    margin-top:0;
    color:#34495e;
}

label{
    font-weight:600;
    color:#555;
}

input{
    width:100%;
    padding:10px;
    margin-top:6px;
    margin-bottom:18px;
    border:1px solid #ddd;
    border-radius:6px;
}

.button{
    background:linear-gradient(90deg,#6f8cc4,#5f7fb8);
    color:white;
    padding:10px 16px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:14px;
}

.button:hover{
    opacity:0.9;
}

.back{
    text-decoration:none;
    margin-left:12px;
    color:#555;
    font-weight:500;
}

.form-action{
    text-align:right;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h2>Edit Barang</h2>

<form method="POST">
    <label>Nama Barang</label>
    <input type="text" name="nama_barang" value="<?= $row['nama_barang']; ?>" required>
    
    <label>Jumlah</label>
    <input type="number" name="jumlah" value="<?= $row['jumlah']; ?>" required>
    
    <label>Harga</label>
    <input type="number" name="harga" value="<?= $row['harga']; ?>" required>
    
    <label>Tanggal Masuk</label>
    <input type="date" name="tanggal_masuk" value="<?= $row['tanggal_masuk']; ?>" required>
    
    <label>Kategori</label>
    <input type="text" name="kategori" value="<?= $row['kategori']; ?>" required>

<div class="form-action">
    <button type="submit" name="update" class="button">Update</button>
    <a href="index.php" class="back">Kembali</a>
</div>

</form>

</div>

</div>

</body>
</html>