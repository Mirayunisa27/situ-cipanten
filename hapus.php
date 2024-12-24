<?php
// Koneksi ke database
$host = "localhost"; // Host database Anda
$user = "root"; // Username database Anda
$password = ""; // Password database Anda
$database = "wisatacipanten"; // Nama database Anda

$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Periksa apakah ID valid
if ($id > 0) {
    // Query untuk menghapus data
    $query = "DELETE FROM pemesanan WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect ke halaman daftar pemesanan dengan pesan sukses
        header("Location: daftar.php?status=success");
    } else {
        // Redirect ke halaman daftar pemesanan dengan pesan gagal
        header("Location: daftar.php?status=error");
    }
    $stmt->close();
} else {
    // Jika ID tidak valid, redirect dengan pesan error
    header("Location: daftar.php?status=invalid");
}

// Tutup koneksi
$conn->close();
?>
