<?php
include 'config.php';

// Pastikan tabel roles dan users sudah ada
// Tambahkan data role admin jika belum ada
$checkRole = $conn->query("SELECT * FROM roles WHERE role_name = 'admin'");
if ($checkRole->num_rows == 0) {
    $conn->query("INSERT INTO roles (role_name) VALUES ('admin')");
    echo "Role admin berhasil ditambahkan ke tabel roles.<br>";
}

// Tambahkan akun admin default jika belum ada
$checkAdmin = $conn->query("SELECT * FROM users WHERE username = 'admin'");
if ($checkAdmin->num_rows == 0) {
    $adminPassword = password_hash('admin123', PASSWORD_BCRYPT); // Password default
    $roleIdResult = $conn->query("SELECT id FROM roles WHERE role_name = 'admin'");
    $roleId = $roleIdResult->fetch_assoc()['id'];

    $conn->query("INSERT INTO users (nama, email, username, password, role_id) 
                  VALUES ('Administrator', 'admin@example.com', 'admin', '$adminPassword', $roleId)");
    echo "Akun admin default berhasil dibuat.<br>";
} else {
    echo "Akun admin sudah ada.<br>";
}

// Tutup koneksi
$conn->close();
?>