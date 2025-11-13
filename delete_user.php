<?php
include "conn.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php?page=login");
    exit();
}

$id = $_GET['id'];

// Pastikan user dengan ID tersebut ada
$check = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
if (mysqli_num_rows($check) == 0) {
    echo "<script>alert('User tidak ditemukan!'); window.location='index.php?page=user';</script>";
    exit;
}

$delete = mysqli_query($conn, "DELETE FROM users WHERE id='$id'");

if ($delete) {
    echo "<script>alert('User berhasil dihapus!'); window.location='index.php?page=user';</script>";
} else {
    echo "<script>alert('Gagal menghapus user!'); window.location='index.php?page=user';</script>";
}
?>
