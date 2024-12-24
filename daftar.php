<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Situs Cipanten</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
  </head>
  <body>
	<!-- Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="index.html">SitusCipanten.Com</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#DAFTAR_PEMESANAN">DAFTAR PEMESANAN</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


  
	<!-- Header -->
  <header id="home" style="text-align: center; background-color:rgb(116, 113, 113); padding: 50px 0;">
	<div class="container">
		<h1 style="color: rgb(255, 255, 255);">SELAMAT DATANG DI WISATA<br> SITU CIPANTEN</h1>
		<p class="lead">Nikmati keindahan alam dan pengalaman yang menyenangkan di Situ Cipanten!</p>
	</div>
  </header>
</head>
<body>
   
<div class="container my-5">
        <main id="DAFTAR_PEMESANAN">
        <h3 class="text-center mb-4">Daftar Pemesanan</h3>
        <?php
        // Koneksi ke database
        $host = "localhost"; // Host database Anda
        $user = "root"; // Username database Anda
        $password = ""; // Password database Anda
        $database = "wisatacipanten"; // Nama database Anda

        $conn = new mysqli($host, $user, $password, $database);

        // Periksa koneksi
        if ($conn->connect_error) {
            die("<div class='alert alert-danger text-center'>Koneksi ke database gagal: " . $conn->connect_error . "</div>");
        }

        // Aktifkan error reporting untuk debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Tampilkan data pemesanan dalam tabel
        $result = $conn->query("SELECT * FROM pemesanan");

        if ($result->num_rows > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-hover table-bordered align-middle text-center'>";
            echo "<thead class='table-dark'>";
            echo "<tr>";
            echo "<th style='width: 5%;'>ID</th>";
            echo "<th style='width: 15%;'>Nama Pemesanan</th>";
            echo "<th style='width: 10%;'>No. HP</th>";
            echo "<th style='width: 12%;'>Tanggal Pemesanan</th>";
            echo "<th style='width: 10%;'>Kategori</th>";
            echo "<th style='width: 10%;'>Destinasi</th>";
            echo "<th style='width: 10%;'>Kulineran</th>";
            echo "<th style='width: 8%;'>Jumlah Peserta</th>";
            echo "<th style='width: 10%;'>Total Harga</th>";

            // Cek apakah ada data "Nomor Kursi" di setidaknya satu baris
            $hasSeatNumber = false;
            while ($row = $result->fetch_assoc()) {
                if (!empty($row['seat_number'])) {
                    $hasSeatNumber = true;
                    break;
                }
            }
            // Jika ada, tambahkan kolom "Nomor Kursi" di header
            if ($hasSeatNumber) {
                echo "<th style='width: 8%;'>Nomor Kursi</th>";
            }

            echo "<th style='width: 20%;'>Aksi</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Reset ulang pointer hasil query
            $result->data_seek(0);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_pemesanan']) . "</td>";
                echo "<td>" . htmlspecialchars($row['hp_pemesan']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tanggal_pemesanan']) . "</td>";
                echo "<td>" . htmlspecialchars($row['kategori']) . "</td>";
                echo "<td>" . htmlspecialchars($row['destinasi']) . "</td>";

                // Perbaiki tampilan "Kulineran"
                echo "<td>" . (!empty($row['kulineran']) ? htmlspecialchars($row['kulineran']) : "Tidak Memilih") . "</td>";

                echo "<td>" . htmlspecialchars($row['jumlah_peserta']) . "</td>";
                echo "<td>Rp." . number_format($row['total_harga'], 0, ',', '.') . "</td>";

                // Tampilkan data "Nomor Kursi" hanya jika ada
                if ($hasSeatNumber) {
                    echo "<td>" . (!empty($row['seat_number']) ? htmlspecialchars($row['seat_number']) : "Kosong") . "</td>";
                }

                echo "<td>";
                echo "<a href='invoice.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Detail</a> ";
                echo "<a href='hapus.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-warning text-center'>Belum ada data pemesanan.</div>";
        }

        // Tutup koneksi
        $conn->close();
        ?>
    </main>

	  <footer class="footer" >
		<div class="container">
		  <div class="row align-items-center">
			<!-- Kolom 1: Logo -->
			<div class="col-md-4">
			  <div class="footer-logo">
				<img src="img/logo.png" alt="Logo" class="footer-logo-img">
			  </div>
			</div>
	  
			<!-- Kolom 2: Layanan dan Dukungan -->
			<div class="col-md-4 d-flex justify-content-between">
			  <!-- Bagian Layanan -->
			  <div class="footer-links">
				<h5>LAYANAN</h5>
				<ul>
				  <li><a href="#">Saran Destinasi</a></li>
				  <li><a href="#">Hubungi Kami</a></li>
				</ul>
			  </div>
	  
			  <!-- Bagian Dukungan -->
			  <div class="footer-links">
				<h5>DUKUNGAN</h5>
				<ul>
				  <li><a href="#">Tentang Situ Cipanten</a></li>
				  <li><a href="#">Ketentuan</a></li>
				  <li><a href="#">Kebijakan Privasi</a></li>
				</ul>
			  </div>
			</div>
	  
			<!-- Kolom 3: Ikuti Kami di Instagram -->
			<div class="col-md-4 text-md-end d-flex justify-content-between">
			  <div class="footer-follow">
				<h5>IKUTI KAMI DI</h5>
				<a href="https://instagram.com/situcipanten_mjlk" target="_blank" class="social-link">
				  <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" class="social-icon">
				  @situcipanten_mjlk
				</a>
			  </div> 
			</div>
		  </div>
		</div>
	  </footer>
	  
		<!-- Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	  </body>
	  </html>
	  
	  </main>
</body>
</html>