<?php

class Barang {

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM barang
            ORDER BY id ASC"
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM barang
            WHERE id=?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function tambah(
        $nama,
        $jumlah,
        $harga,
        $tanggal,
        $kategori,
        $gambar
    )
    {

        $stmt = $this->conn->prepare(
            "INSERT INTO barang
            (
                nama_barang,
                jumlah,
                harga,
                tanggal_masuk,
                kategori,
                gambar
            )
            VALUES(?,?,?,?,?,?)"
        );

        $stmt->bind_param(
            "siisss",
            $nama,
            $jumlah,
            $harga,
            $tanggal,
            $kategori,
            $gambar
        );

        return $stmt->execute();
    }

    public function update(
        $id,
        $nama,
        $jumlah,
        $harga,
        $tanggal,
        $kategori,
        $gambar
    )
    {

        $stmt = $this->conn->prepare(
            "UPDATE barang SET
            nama_barang=?,
            jumlah=?,
            harga=?,
            tanggal_masuk=?,
            kategori=?,
            gambar=?
            WHERE id=?"
        );

        $stmt->bind_param(
            "siisssi",
            $nama,
            $jumlah,
            $harga,
            $tanggal,
            $kategori,
            $gambar,
            $id
        );

        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM barang
            WHERE id=?"
        );

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>