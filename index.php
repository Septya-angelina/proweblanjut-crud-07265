<?php
include "koneksi.php";

$data = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Barang</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:#eef2f7;
    margin:0;
}

.container{
    width:85%;
    margin:auto;
    margin-top:40px;
}

.card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

h2{
    margin-top:0;
    color:#34495e;
}

.button{
    background:linear-gradient(90deg,#6f8cc4,#5f7fb8);
    color:white;
    padding:8px 14px;
    text-decoration:none;
    border-radius:8px;
    font-size:14px;
}

.button:hover{
    opacity:0.9;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th{
    background:#8ea9db;
    color:white;
    padding:12px;
    text-align:left;
}

td{
    padding:12px;
    border-bottom:1px solid #eaeaea;
}

tr:hover{
    background:#f7f9fc;
}

th:nth-child(1),
th:nth-child(3),
th:nth-child(4),
th:nth-child(5),
th:nth-child(6),
th:nth-child(7){
    text-align:center;
}

td:nth-child(1),
td:nth-child(3),
td:nth-child(4),
td:nth-child(5),
td:nth-child(6){
    text-align:center;
}

.action{
    display:flex;
    justify-content:center;
    gap:8px;
}

.action a{
    text-decoration:none;
    padding:6px 12px;
    border-radius:6px;
    font-size:13px;
    color:white;
}

.edit{
    background:#6f8cc4;
}

.edit:hover{
    background:#5f7fb8;
}

.delete{
    background:#e74c3c;
}

.delete:hover{
    background:#c0392b;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h2>Data Barang</h2>

<a href="tambah.php" class="button">+ Tambah Barang</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Tanggal Masuk</th>
        <th>Kategori</th>
        <th>Aksi</th>
    </tr>

<?php foreach($data as $row){ ?>

<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['nama_barang']; ?></td>
    <td><?= $row['jumlah']; ?></td>
    <td><?= $row['harga']; ?></td>
    <td><?= $row['tanggal_masuk']; ?></td>
    <td><?= $row['kategori']; ?></td>
    
    <td class="action">
        <a href="edit.php?id=<?= $row['id']; ?>" class="edit">Edit</a>
        <a href="hapus.php?id=<?= $row['id']; ?>" class="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
    </td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>