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

            $_SESSION["user_id"]  = $user["id"];
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

$data = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistem Pendataan Barang</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial;
        }

        body {
            display: flex;
            background: #f4f6fb;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            background: white;
            border-right: 1px solid #e5e8f0;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar h2 {
            text-align: center;
            color: #6c8bd8;
            margin-bottom: 30px;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            margin: 10px 15px;
        }

        .menu li a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px;
            text-decoration: none;
            color: #555;
            border-radius: 8px;
        }

        .menu li a:hover {
            background: #eef3ff;
        }

        .active {
            background: linear-gradient(90deg, #7fa1ff, #9ab2ff);
            color: white !important;
        }

        .logout-container {
            padding: 20px;
        }

        .logout-btn {
            display: block;
            text-align: center;
            background: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        .main {
            flex: 1;
        }

        .header {
            background: #8fa8d6;
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            padding: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #8ea9db;
            color: white;
            padding: 12px;
            text-align: center;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        tr:hover {
            background: #f7f9fc;
        }

        .action {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .action a {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-size: 14px;
        }

        .edit {
            background: #f4b400;
        }

        .delete {
            background: #e74c3c;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div>
        <h2>Monitoring</h2>

        <ul class="menu">
            <li>
                <a href="index.php" class="active">📦 Data Barang</a>
            </li>
            <li>
                <a href="tambah.php">✚ Tambah Barang</a>
            </li>
        </ul>
    </div>

    <div class="logout-container">
        <a href="logout.php"
           class="logout-btn"
           onclick="return confirm('Apakah Anda yakin ingin logout?')">
            Logout
        </a>
    </div>
</div>

<div class="main">

    <div class="header">
        <div>Sistem Manajemen Barang</div>
        <div>
            👋 Selamat datang,
            <b><?= $_SESSION["username"]; ?></b>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2>Data Barang</h2>

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

                <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= $row["id"]; ?></td>
                    <td><?= $row["nama_barang"]; ?></td>
                    <td><?= $row["jumlah"]; ?></td>
                    <td><?= $row["harga"]; ?></td>
                    <td><?= $row["tanggal_masuk"]; ?></td>
                    <td><?= $row["kategori"]; ?></td>

                    <td class="action">
                        <a href="edit.php?id=<?= $row["id"]; ?>" class="edit">✎</a>
                        <a href="hapus.php?id=<?= $row["id"]; ?>"
                           class="delete"
                           onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                            🗑
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>

</div>

</body>
</html>