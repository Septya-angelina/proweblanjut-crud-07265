<?php
session_start();
include "koneksi.php";

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$errors = [];

if (isset($_POST['simpan'])) {

    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        die("Akses tidak sah");
    }

    $nama     = trim($_POST['nama_barang']);
    $jumlah   = trim($_POST['jumlah']);
    $harga    = trim($_POST['harga']);
    $tanggal  = $_POST['tanggal_masuk'];
    $kategori = trim($_POST['kategori']);

    if (empty($nama)) {
        $errors['nama'] = "Nama wajib diisi";
    }

    if (empty($jumlah)) {
        $errors['jumlah'] = "Jumlah wajib diisi";
    } elseif (!is_numeric($jumlah)) {
        $errors['jumlah'] = "Jumlah harus berupa angka";
    } elseif ($jumlah <= 0) {
        $errors['jumlah'] = "Jumlah harus > 0";
    }

    if (empty($harga)) {
        $errors['harga'] = "Harga wajib diisi";
    } elseif (!is_numeric($harga)) {
        $errors['harga'] = "Harga harus berupa angka";
    } elseif ($harga <= 0) {
        $errors['harga'] = "Harga harus > 0";
    }

    if (empty($tanggal)) {
        $errors['tanggal'] = "Tanggal wajib diisi";
    }

    if (empty($kategori)) {
        $errors['kategori'] = "Kategori wajib diisi";
    }

    $gambar = "";

    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== 0) {
        $errors['gambar'] = "Gambar wajib diupload";
    } else {

        $allowed = ['jpg','jpeg','png'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $mime = mime_content_type($_FILES['gambar']['tmp_name']);

        if (!in_array($ext, $allowed)) {
            $errors['gambar'] = "Format harus JPG / PNG";
        } elseif (!in_array($mime, ['image/jpeg','image/png'])) {
            $errors['gambar'] = "File bukan gambar valid";
        } elseif (!getimagesize($_FILES['gambar']['tmp_name'])) {
            $errors['gambar'] = "File bukan gambar asli";
        } elseif ($_FILES['gambar']['size'] > 1000000) {
            $errors['gambar'] = "Max 1MB";
        } else {
            $gambar = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/" . $gambar);
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO barang (nama_barang, jumlah, harga, tanggal_masuk, kategori, gambar) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siisss", $nama, $jumlah, $harga, $tanggal, $kategori, $gambar);
        $stmt->execute();

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Barang</title>

<style>
body {
    font-family: Arial;
    background: #eef2f7;
}

.container {
    width: 420px;
    margin: auto;
    margin-top: 60px;
}

.card {
    background: white;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

h2 {
    margin-bottom: 20px;
    color: #2c3e50;
}

label {
    font-weight: 600;
    color: #555;
}

input {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.error {
    color: red;
    font-size: 13px;
    margin-bottom: 10px;
}

.form-action {
    text-align: right;
    margin-top: 15px;
}

button {
    background: #6c8ecf;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

button:hover {
    background: #5a78b5;
}

.back {
    margin-left: 10px;
    text-decoration: none;
    color: #555;
    font-weight: 500;
}
</style>
</head>

<body>

<div class="container">
    <div class="card">

        <h2>Tambah Barang</h2>

        <form method="POST" enctype="multipart/form-data">

            <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">

            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="<?= $_POST['nama_barang'] ?? '' ?>">
            <?php if (isset($errors['nama'])) echo "<div class='error'>{$errors['nama']}</div>"; ?>

            <label>Jumlah</label>
            <input type="text" name="jumlah" value="<?= isset($errors['jumlah']) ? '' : ($_POST['jumlah'] ?? '') ?>">
            <?php if (isset($errors['jumlah'])) echo "<div class='error'>{$errors['jumlah']}</div>"; ?>

            <label>Harga</label>
            <input type="text" name="harga" value="<?= isset($errors['harga']) ? '' : ($_POST['harga'] ?? '') ?>">
            <?php if (isset($errors['harga'])) echo "<div class='error'>{$errors['harga']}</div>"; ?>

            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" value="<?= $_POST['tanggal_masuk'] ?? '' ?>">
            <?php if (isset($errors['tanggal'])) echo "<div class='error'>{$errors['tanggal']}</div>"; ?>

            <label>Kategori</label>
            <input type="text" name="kategori" value="<?= $_POST['kategori'] ?? '' ?>">
            <?php if (isset($errors['kategori'])) echo "<div class='error'>{$errors['kategori']}</div>"; ?>

            <label>Gambar</label>
            <input type="file" name="gambar">
            <?php if (isset($errors['gambar'])) echo "<div class='error'>{$errors['gambar']}</div>"; ?>

            <div class="form-action">
                <button type="submit" name="simpan">💾 Simpan</button>
                <a href="index.php" class="back">↩ Kembali</a>
            </div>

        </form>

    </div>
</div>

</body>
</html>