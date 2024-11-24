<?php
// Koneksi ke database
include 'config.php';
session_start(); // Mulai session di awal skrip

$username = $_POST['username'] ?? ''; // Gunakan null coalescing operator untuk menghindari error jika POST kosong
$password = $_POST['password'] ?? ''; 

// Jika form login disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $kategori = $_POST['kategori']; // Kategori yang dipilih (misalnya Kelas 7, 8, 9)
    $kelas = $_POST['kelas']; // Kelas yang dipilih oleh user
    
    // Cek apakah username adalah 'admin' dan password sesuai
    if ($username === 'admin' && $password === 'admin123') {
        // Admin login
        $_SESSION['username'] = 'admin';
        $_SESSION['role_id'] = 1; // Admin role
        $_SESSION['kelas'] = null; // Admin tidak memiliki kelas khusus

        // Arahkan ke halaman admin
        header("Location: admin.php");
        exit;
    }

    // Cek apakah username ada dalam database untuk pengguna lain
    $queryCheckUser = $conn->prepare("SELECT id, username, password, role_id, kelas FROM users WHERE username = ?");
    $queryCheckUser->bind_param("s", $username);
    $queryCheckUser->execute();
    $resultUser = $queryCheckUser->get_result();

    // Debugging: Check if the query returned any results
    if ($resultUser->num_rows === 0) {
        echo "<script>alert('Username tidak ditemukan!'); window.location.href = 'index.php?page=login';</script>";
        exit;
    }

    $user = $resultUser->fetch_assoc();
    
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Verifikasi kategori dan kelas jika tidak login sebagai admin
        if ($username != 'admin') {
            if ($user['kelas'] !== $kelas || ($kategori && $kategori !== $user['kelas'][0])) {
                echo "<script>alert('Kelas atau kategori tidak sesuai!'); window.location.href = 'index.php?page=login';</script>";
                exit;
            }
        }

        // Set session untuk login user
        $_SESSION['username'] = $user['username'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['kelas'] = $user['kelas']; // Menyimpan kelas user dalam session

        // Arahkan ke halaman yang sesuai berdasarkan role (misalnya dashboard)
        if ($user['role_id'] == 1) { // Admin
            header("Location: admin.php");
        } else { // User biasa
            header("Location: index.php?page=beranda");
        }
        exit;

    } else {
        echo "<script>alert('Password salah!'); window.location.href = 'index.php?page=login';</script>";
    }
}

// Tutup koneksi
$conn->close();
?>