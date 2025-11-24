<?php
session_start();

// Jika session login ada, hapus semuanya
if (isset($_SESSION['login'])) {
    session_unset();
    session_destroy();
}

// Redirect kembali ke halaman login
header("Location: ../view/v_login.php");
exit();
?>
