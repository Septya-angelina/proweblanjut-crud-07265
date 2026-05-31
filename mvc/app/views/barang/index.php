<!DOCTYPE html>
<html>
<head>
<title>Sistem Pendataan Barang</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    display:flex;
    background:#f4f6fb;
}

.sidebar{
    width:220px;
    height:100vh;
    background:white;
    border-right:1px solid #e5e8f0;
    padding-top:20px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.sidebar h2{
    text-align:center;
    color:#6c8bd8;
    margin-bottom:30px;
}

.menu{
    list-style:none;
}

.menu li{
    margin:10px 15px;
}

.menu li a{
    display:flex;
    justify-content:center;
    padding:10px;
    text-decoration:none;
    color:#555;
    border-radius:8px;
}

.menu li a:hover{
    background:#eef3ff;
}

.active{
    background:linear-gradient(90deg,#7fa1ff,#9ab2ff);
    color:white!important;
}

.logout-container{
    padding:20px;
}

.logout-btn{
    display:block;
    text-align:center;
    background:#e74c3c;
    color:white;
    padding:10px;
    border-radius:8px;
    text-decoration:none;
}

.main{
    flex:1;
}

.header{
    background:#8fa8d6;
    color:white;
    padding:20px;
    display:flex;
    justify-content:space-between;
}

.container{
    padding:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.05);
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
    text-align:center;
}

td{
    padding:12px;
    border-bottom:1px solid #eee;
    text-align:center;
}

.img-table{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:6px;
}

.action{
    display:flex;
    justify-content:center;
    gap:8px;
}

.action a{
    padding:6px 10px;
    border-radius:6px;
    color:white;
    text-decoration:none;
}

.edit{
    background:#f4b400;
}

.delete{
    background:#e74c3c;
}

</style>
</head>

<body>

<div class="sidebar">

<div>

<h2>Monitoring</h2>

<ul class="menu">

<li>
<a href="index.php" class="active">
📦 Data Barang
</a>
</li>

<li>
<a href="tambah.php">
✚ Tambah Barang
</a>
</li>

</ul>

</div>

<div class="logout-container">
<a href="logout.php" class="logout-btn">
Logout
</a>
</div>

</div>

<div class="main">

<div class="header">

<div>
Sistem Manajemen Barang
</div>

<div>
👋 Selamat Datang,
<?= $_SESSION['username']; ?>
</div>

</div>

<div class="container">

<div class="card">

<h2>Data Barang</h2>

<table>

<tr>
    <th>ID</th>
    <th>Gambar</th>
    <th>Nama</th>
    <th>Jumlah</th>
    <th>Harga</th>
    <th>Tanggal</th>
    <th>Kategori</th>
    <th>Aksi</th>
</tr>

<?php while($row = $data->fetch_assoc()): ?>

<tr>

<td><?= $row['id']; ?></td>

<td>
    <img
    src="../app/assets/uploads/<?= $row['gambar']; ?>"
    class="img-table"
    >
</td>

<td><?= $row['nama_barang']; ?></td>
<td><?= $row['jumlah']; ?></td>
<td><?= $row['harga']; ?></td>
<td><?= $row['tanggal_masuk']; ?></td>
<td><?= $row['kategori']; ?></td>

<td>

<div class="action">

<a
href="edit.php?id=<?= $row['id']; ?>"
class="edit"
>
Edit
</a>

<a
href="hapus.php?id=<?= $row['id']; ?>"
class="delete"
onclick="return confirm('Hapus data?')"
>
Hapus
</a>

</div>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</div>

</body>
</html>