<?php
include "koneksi.php";

$data = $conn->query("SELECT * FROM barang");
?>

<h2>Data Barang</h2>

<a href="tambah.php">Tambah Barang</a>

<table border="1" cellpadding="10">
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

<td>
<a href="edit.php?id=<?= $row['id']; ?>">Edit</a> |
<a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
</td>
</tr>

<?php } ?>

</table>