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

// Ambil data dari form dan validasi
$nama_pemesanan = isset($_POST['nama_pemesanan']) ? $conn->real_escape_string(trim($_POST['nama_pemesanan'])) : '';
$hp_pemesan = isset($_POST['hp_pemesan']) ? $conn->real_escape_string(trim($_POST['hp_pemesan'])) : '';
$tanggal_pemesanan = isset($_POST['tanggal_pemesanan']) ? $conn->real_escape_string($_POST['tanggal_pemesanan']) : null;
$kategori = isset($_POST['kategori']) ? json_encode($_POST['kategori'], JSON_UNESCAPED_UNICODE) : '[]';
$destinasi = isset($_POST['destinasi']) ? json_encode($_POST['destinasi'], JSON_UNESCAPED_UNICODE) : '[]';
$kulineran = isset($_POST['kulineran']) ? json_encode($_POST['kulineran'], JSON_UNESCAPED_UNICODE) : '[]';
$seat_number = isset($_POST['seat_number']) ? $conn->real_escape_string(trim($_POST['seat_number'])) : null;
$jumlah_peserta = isset($_POST['jumlah_peserta']) ? intval($_POST['jumlah_peserta']) : 1;
$total_harga = isset($_POST['total_harga']) ? preg_replace('/[^0-9]/', '', $_POST['total_harga']) : 0; // Hapus format Rp.

// Validasi input
if (empty($nama_pemesanan) || empty($hp_pemesan) || empty($tanggal_pemesanan)) {
    die("Nama pemesanan, nomor HP, dan tanggal pemesanan wajib diisi!");
}

// Query untuk menyimpan data
$sql = "INSERT INTO pemesanan (nama_pemesanan, hp_pemesan, tanggal_pemesanan, kategori, destinasi, kulineran, seat_number, jumlah_peserta, total_harga) 
        VALUES ('$nama_pemesanan', '$hp_pemesan', '$tanggal_pemesanan', '$kategori', '$destinasi', '$kulineran', " . 
        ($seat_number ? "'$seat_number'" : "NULL") . ", $jumlah_peserta, $total_harga)";

// Eksekusi query
if ($conn->query($sql) === TRUE) {
    $id_pemesanan = $conn->insert_id; // Ambil ID pemesanan terakhir
    header("Location: pesan.php?id=" . $id_pemesanan); // Redirect ke invoice
    exit;
} else {
    echo "<div style='color:red;'>Terjadi kesalahan: " . $conn->error . "</div>";
    echo "<div>Query: " . htmlspecialchars($sql) . "</div>";
}

// Tombol kembali ke beranda
echo "<br><br>";
echo "<a href='index.html' style='display:inline-block;padding:10px 20px;background-color:#28a745;color:white;text-decoration:none;border-radius:5px;'>Kembali ke Beranda</a>";

// Tutup koneksi
$conn->close();
?>
