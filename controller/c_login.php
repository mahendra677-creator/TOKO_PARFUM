<?php
session_start();
include_once '../model/m_koneksi.php';

if (empty($_POST['nama']) || empty($_POST['password'])) {
    echo "<script>alert('Silakan isi username/email dan password'); window.location='../view/v_login.php'</script>";
    exit;
}

$userInput     = $_POST['nama'];
$passwordInput = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM user WHERE nama = ? OR email = ? LIMIT 1");
$stmt->bind_param("ss", $userInput, $userInput);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {

    if (password_verify($passwordInput, $data['password'])) {

        // Simpan session
        $_SESSION['data'] = $data;

        // Cek role pengguna
        if ($data['role'] === 'admin') {
            // ADMIN masuk ke tampil data pelanggan
            header("Location: ../view/v_tampil_data_pelanggan.php");
            exit;

        } elseif ($data['role'] === 'user') {
            // USER masuk ke form pembelian
            header("Location: ../view/v_form_pembelian.php");
            exit;

        } else {
            echo "<script>alert('Role tidak dikenali'); window.location='../view/v_login.php'</script>";
            exit;
        }

    } else {
        echo "<script>alert('Password salah'); window.location='../view/v_login.php'</script>";
        exit;
    }

} else {
    echo "<script>alert('Username atau email tidak ditemukan'); window.location='../view/v_login.php'</script>";
    exit;
}
