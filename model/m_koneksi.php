<?php

class Koneksi {
    private $host = "localhost",
            $username = "root",
            $pass = "",
            $db = "parfum",
            $port = "";

    public $koneksi;

    function __construct() {
        $this->koneksi = mysqli_connect(
            $this->host,
            $this->username,
            $this->pass,
            $this->db
        );

        if (!$this->koneksi) {
            echo "Koneksi ke database gagal";
        }
    }
}

// buat objek
$koneksi = new Koneksi();

// buat variabel $conn untuk dipakai di file lain
$conn = $koneksi->koneksi;
