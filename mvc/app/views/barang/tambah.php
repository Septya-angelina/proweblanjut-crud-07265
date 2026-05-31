<!DOCTYPE html>
<html>
<head>
<title>Tambah Barang</title>

<style>

body{
    font-family:Arial;
    background:#eef2f7;
}

.container{
    width:420px;
    margin:auto;
    margin-top:60px;
}

.card{
    background:white;
    padding:30px;
    border-radius:14px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

h2{
    margin-bottom:20px;
    color:#2c3e50;
}

label{
    font-weight:600;
    color:#555;
}

input{
    width:100%;
    padding:10px;
    margin-top:6px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:6px;
}

.form-action{
    text-align:right;
    margin-top:15px;
}

button{
    background:#6c8ecf;
    color:white;
    padding:10px 18px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

button:hover{
    background:#5a78b5;
}

.back{
    margin-left:10px;
    text-decoration:none;
    color:#555;
    font-weight:500;
}

</style>
</head>

<body>

<div class="container">

<div class="card">

<h2>Tambah Barang</h2>

<form method="POST" enctype="multipart/form-data">

<label>Nama Barang</label>
<input
type="text"
name="nama_barang"
required
>

<label>Jumlah</label>
<input
type="number"
name="jumlah"
required
>

<label>Harga</label>
<input
type="number"
name="harga"
required
>

<label>Tanggal Masuk</label>
<input
type="date"
name="tanggal_masuk"
required
>

<label>Kategori</label>
<input
type="text"
name="kategori"
required
>

<label>Gambar</label>
<input
type="file"
name="gambar"
required
>

<div class="form-action">

<button type="submit" name="simpan">
💾 Simpan
</button>

<a href="index.php" class="back">
↩ Kembali
</a>

</div>

</form>

</div>

</div>

</body>
</html>