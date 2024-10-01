<?php
session_start(); // Memulai session untuk menyimpan data sementara

// Memeriksa apakah indeks tugas ada dalam list
if (isset($_GET['index'])) {
    $index = $_GET['index'];
    // Menghapus tugas dari daftar
    unset($_SESSION['todos'][$index]);
    // Mengatur ulang indeks tugas
    $_SESSION['todos'] = array_values($_SESSION['todos']);
    // Mengatur notifikasi pesan tugas berhasil dihapus dari daftar
    $_SESSION['success_message'] = "Tugas berhasil dihapus!";
}

// Mengalihkan kembali ke halaman index
header("Location: index.php");
exit;
?>
