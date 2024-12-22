<!DOCTYPE html>
<html lang="en">
<head>
<body>
<main id="invoice" class="flex-shrink-0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pemesanan</title>
    <!-- Bootstrap CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container-invoice {
            max-width: 800px;
            margin: 30px auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        p {
            margin: 5px 0 15px;
            font-size: 16px;
        }
        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    // Koneksi ke database
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'wisatacipanten';

    $conn = new mysqli($host, $user, $password, $db);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi ke database gagal: " . $conn->connect_error);
    }

    // Ambil ID dari URL
    $id_pemesanan = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Query data pemesanan
    $sql = "SELECT * FROM pemesanan WHERE id = $id_pemesanan";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $detail = $result->fetch_assoc();
    ?>
    <div class="container container-invoice">
        <h2>Invoice Pemesanan #<?= htmlspecialchars($detail['id']); ?></h2>
        <label for="nama">Nama:</label>
        <p><?= htmlspecialchars($detail['nama_pemesanan']); ?></p>

        <label for="no_hp">Nomor HP:</label>
        <p><?= htmlspecialchars($detail['hp_pemesan']); ?></p>

        <label for="tanggal">Tanggal Pemesanan:</label>
        <p><?= htmlspecialchars($detail['tanggal_pemesanan']); ?></p>

        <label for="kategori">Kategori:</label>
        <p><?= implode(', ', json_decode($detail['kategori'], true)); ?></p>

        <label for="destinasi">Destinasi:</label>
        <p><?= implode(', ', json_decode($detail['destinasi'], true)); ?></p>

        <label for="kulineran">Kulineran:</label>
        <p><?= implode(', ', json_decode($detail['kulineran'], true)); ?></p>

        <?php
        // Contoh: Tampilkan hanya jika 'kategori' mengandung 'VIP' atau kondisi lain
        if (!empty($detail['seat_number']) && in_array('VIP', json_decode($detail['kategori'], true))) {
        ?>
    <label for="seat_number">Nomor Kursi:</label>
    <p><?= htmlspecialchars($detail['seat_number']); ?></p>
<?php
}
?>


        <label for="jumlah_peserta">Jumlah Peserta:</label>
        <p><?= htmlspecialchars($detail['jumlah_peserta']); ?></p>

        <label for="total_harga">Total Harga:</label>
        <p>Rp. <?= number_format($detail['total_harga'], 0, ',', '.'); ?></p>

        <button onclick="window.print()">Cetak Invoice</button>
        <a href='index.php' style='display:inline-block;padding:10px 20px;background-color:#28a745;color:white;text-decoration:none;border-radius:5px;'>Kembali ke Beranda</a>

    </div>
    <?php
    } else {
        echo "<div class='container container-invoice'><p>Data pemesanan tidak ditemukan.</p></div>";
    }

    // Tutup koneksi
    $conn->close();
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>