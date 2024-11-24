<?php
// Koneksi ke database
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    $role = 'user';  // Default role adalah 'user', bisa disesuaikan jika ada logika untuk admin
    $kelas = $_POST['kelas'];  // Menambahkan kelas dari form

    // Validasi password
    if ($password !== $konfirmasi_password) {
        echo "<script>alert('Password dan Konfirmasi Password tidak cocok!'); window.location.href = 'index.php?page=daftar';</script>";
        exit;
    }

    // Cek apakah email sudah terdaftar
    $queryCheckEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $queryCheckEmail->bind_param("s", $email);
    $queryCheckEmail->execute();
    $resultEmail = $queryCheckEmail->get_result();

    if ($resultEmail->num_rows > 0) {
        echo "<script>alert('Email sudah terdaftar! Silakan gunakan email lain.'); window.location.href = 'index.php?page=daftar';</script>";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk mengambil id role, misalnya untuk user (bisa diganti jika perlu)
    $queryRole = $conn->prepare("SELECT id FROM roles WHERE role_name = ?");
    $queryRole->bind_param("s", $role);
    $queryRole->execute();
    $resultRole = $queryRole->get_result();
    $roleData = $resultRole->fetch_assoc();
    $role_id = $roleData['id']; // Mengambil ID role berdasarkan role name

    // Query untuk menyimpan data pengguna ke dalam database, termasuk kelas yang dipilih
    $queryInsert = $conn->prepare("INSERT INTO users (nama, email, username, password, role_id, kelas) VALUES (?, ?, ?, ?, ?, ?)");
    $queryInsert->bind_param("ssssis", $nama, $email, $username, $hashed_password, $role_id, $kelas);

    if ($queryInsert->execute()) {
        echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location.href = 'index.php?page=login';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat mendaftar.'); window.location.href = 'index.php?page=daftar';</script>";
    }
}

// Tutup koneksi
$conn->close();
?>
