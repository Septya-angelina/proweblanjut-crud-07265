<?php
include "koneksi.php";

if(isset($_POST['simpan'])){

$nama = $_POST['nama_barang'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];
$tanggal = $_POST['tanggal_masuk'];
$kategori = $_POST['kategori'];

$sql = "INSERT INTO barang(nama_barang,jumlah,harga,tanggal_masuk,kategori)
VALUES (?,?,?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->execute([$nama,$jumlah,$harga,$tanggal,$kategori]);

header("Location:index.php");
}
?>

<h2>Tambah Barang</h2>

<form method="POST">

Nama Barang <br>
<input type="text" name="nama_barang"><br><br>

Jumlah <br>
<input type="number" name="jumlah"><br><br>

Harga <br>
<input type="number" name="harga"><br><br>

Tanggal Masuk <br>
<input type="date" name="tanggal_masuk"><br><br>

Kategori <br>
<input type="text" name="kategori"><br><br>

<button type="submit" name="simpan">Simpan</button>

</form>