<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect ke login jika belum login atau bukan admin
    exit();
}

// Koneksi ke database
include 'config.php';

// Ambil ID pesan yang dipilih
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM kontak WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Pesan tidak ditemukan.";
        exit();
    }
} else {
    echo "ID pesan tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesan Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Detail Pesan Kontak</h1>
        <a href="admin_pesan.php" class="btn btn-secondary">Kembali ke Daftar Pesan</a>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5><?= $row['nama']; ?> (<?= $row['email']; ?>)</h5>
            </div>
            <div class="card-body">
                <h6>Pesan:</h6>
                <p><?= nl2br($row['pesan']); ?></p>
                <hr>
                <h6>Tanggal: <?= $row['tanggal']; ?></h6>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">Hapus Pesan</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
