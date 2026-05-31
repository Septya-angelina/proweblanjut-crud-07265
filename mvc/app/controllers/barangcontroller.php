<?php

require_once '../config/database.php';
require_once '../app/models/Barang.php';

class BarangController {

    private $barang;

    public function __construct($db)
    {
        $this->barang = new Barang($db);
    }

    public function index()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {

            header('Location: login.php');
            exit();
        }

        $data = $this->barang->getAll();

        require '../app/views/barang/index.php';
    }

    public function tambah()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {

            header('Location: login.php');
            exit();
        }

        if (isset($_POST['simpan'])) {

            $nama     = trim($_POST['nama_barang']);
            $jumlah   = trim($_POST['jumlah']);
            $harga    = trim($_POST['harga']);
            $tanggal  = $_POST['tanggal_masuk'];
            $kategori = trim($_POST['kategori']);

            $gambar = "";

            if (
                isset($_FILES['gambar']) &&
                $_FILES['gambar']['error'] == 0
            ) {

                $ext = strtolower(
                    pathinfo(
                        $_FILES['gambar']['name'],
                        PATHINFO_EXTENSION
                    )
                );

                $gambar = uniqid() . '.' . $ext;

                move_uploaded_file(
                    $_FILES['gambar']['tmp_name'],
                    '../app/assets/uploads/' . $gambar
                );
            }

            $this->barang->tambah(
                $nama,
                $jumlah,
                $harga,
                $tanggal,
                $kategori,
                $gambar
            );

            header('Location: index.php');
            exit();
        }

        require '../app/views/barang/tambah.php';
    }

    public function edit($id)
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {

            header('Location: login.php');
            exit();
        }

        $result = $this->barang->getById($id);
        $row = $result->fetch_assoc();

        if (!$row) {

            header('Location: index.php');
            exit();
        }

        if (isset($_POST['update'])) {

            $nama     = trim($_POST['nama_barang']);
            $jumlah   = trim($_POST['jumlah']);
            $harga    = trim($_POST['harga']);
            $tanggal  = $_POST['tanggal_masuk'];
            $kategori = trim($_POST['kategori']);

            $gambar = $row['gambar'];

            if (
                isset($_FILES['gambar']) &&
                $_FILES['gambar']['error'] == 0
            ) {

                $ext = strtolower(
                    pathinfo(
                        $_FILES['gambar']['name'],
                        PATHINFO_EXTENSION
                    )
                );

                $gambar = uniqid() . '.' . $ext;

                move_uploaded_file(
                    $_FILES['gambar']['tmp_name'],
                    '../app/assets/uploads/' . $gambar
                );
            }

            $this->barang->update(
                $id,
                $nama,
                $jumlah,
                $harga,
                $tanggal,
                $kategori,
                $gambar
            );

            header('Location: index.php');
            exit();
        }

        require '../app/views/barang/edit.php';
    }

    public function hapus($id)
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {

            header('Location: login.php');
            exit();
        }

        $this->barang->delete($id);

        header('Location: index.php');
    }
}

?>