<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION["user_id"])) {
    if (!empty($_COOKIE["remember_token"])) {
        $token = trim($_COOKIE["remember_token"]);

        $stmt = $conn->prepare("SELECT id, username FROM users WHERE remember_token = ? LIMIT 1");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
        } else {
            setcookie("remember_token", "", time() - 3600, "/");
            header("Location: login.php");
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
    }
}

$stmt = $conn->prepare("SELECT gambar FROM barang ORDER BY id ASC");
$stmt->execute();
$result = $stmt->get_result();

$images = [];
while ($row = $result->fetch_assoc()) {
    if (!empty($row["gambar"])) {
        $images[] = $row["gambar"];
    }
}

$stmt = $conn->prepare("SELECT * FROM barang ORDER BY id ASC");
$stmt->execute();
$data = $stmt->get_result();
?>

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
    vertical-align:middle;
}

tr:hover{
    background:#f7f9fc;
}

.img-table{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:6px;
    cursor:pointer;
}

.action{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:8px;
}

.action a{
    width:32px;
    height:32px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
    color:white;
    text-decoration:none;
}

.edit{
    background:#f4b400;
}

.delete{
    background:#e74c3c;
}

.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.85);
    justify-content:center;
    align-items:center;
}

.modal img{
    max-width:80%;
    max-height:80%;
    border-radius:10px;
    animation:zoom 0.3s;
}

@keyframes zoom{
    from{
        transform:scale(0.5);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

.close{
    position:absolute;
    top:20px;
    right:30px;
    font-size:30px;
    color:white;
    cursor:pointer;
}

.nav{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    font-size:40px;
    color:white;
    cursor:pointer;
}

.prev{left:20px;}
.next{right:20px;}
</style>
</head>

<body>

<div class="sidebar">
    <div>
        <h2>Monitoring</h2>
        <ul class="menu">
            <li><a href="index.php" class="active">📦 Data Barang</a></li>
            <li><a href="tambah.php">✚ Tambah Barang</a></li>
        </ul>
    </div>

    <div class="logout-container">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="main">

<div class="header">
    <div>Sistem Manajemen Barang</div>
    <div>👋 Selamat Datang, <?= htmlspecialchars($_SESSION["username"]); ?></div>
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

<?php $index = 0; while ($row = $data->fetch_assoc()): ?>

<tr>
<td><?= $row["id"]; ?></td>

<td>
    <?php if (!empty($row["gambar"])): ?>
        <img src="uploads/<?= $row["gambar"]; ?>" class="img-table" onclick="openModal(<?= $index++; ?>)">
    <?php endif; ?>
</td>

<td><?= htmlspecialchars($row["nama_barang"]); ?></td>
<td><?= $row["jumlah"]; ?></td>
<td><?= $row["harga"]; ?></td>
<td><?= $row["tanggal_masuk"]; ?></td>
<td><?= htmlspecialchars($row["kategori"]); ?></td>

<td>
    <div class="action">
        <a href="edit.php?id=<?= $row["id"]; ?>" class="edit">✎</a>
        <a href="hapus.php?id=<?= $row["id"]; ?>" class="delete" onclick="return confirm('Hapus data ini?')">🗑</a>
    </div>
</td>

</tr>

<?php endwhile; ?>

</table>

</div>
</div>

</div>

<div class="modal" id="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <span class="nav prev" onclick="prev()">❮</span>
    <img id="modalImg">
    <span class="nav next" onclick="next()">❯</span>
</div>

<script>
let images = <?= json_encode($images); ?>;
let current = 0;

function openModal(i){
    current = i;
    document.getElementById("modal").style.display = "flex";
    show();
}

function closeModal(){
    document.getElementById("modal").style.display = "none";
}

function show(){
    document.getElementById("modalImg").src = "uploads/" + images[current];
}

function next(){
    current = (current + 1) % images.length;
    show();
}

function prev(){
    current = (current - 1 + images.length) % images.length;
    show();
}
</script>

</body>
</html>