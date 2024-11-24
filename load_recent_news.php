<?php
include 'config.php';

// Tentukan berapa banyak berita terbaru yang ditampilkan per halaman
$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$excludeId = isset($_GET['excludeId']) ? (int)$_GET['excludeId'] : 0; // ID berita yang sedang dibuka
$offset = ($page - 1) * $limit;

// Array untuk mengganti nama hari dalam bahasa Inggris ke bahasa Indonesia
$days_in_indonesia = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];

// Query untuk mengambil berita terbaru, mengecualikan berita yang sedang dibuka
$query = "SELECT * FROM berita 
          WHERE id != $excludeId 
          ORDER BY tanggal DESC 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Periksa jika query gagal
if (!$result) {
    echo json_encode(['error' => 'Terjadi kesalahan pada query: ' . mysqli_error($conn)]);
    exit;
}

// Array untuk menyimpan berita terbaru
$news = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Format tanggal dan waktu
    $date = date('d F Y', strtotime($row['tanggal']));
    $day_english = date('l', strtotime($row['tanggal'])); // Nama hari dalam bahasa Inggris
    $day = $days_in_indonesia[$day_english]; // Ganti ke bahasa Indonesia
    $time = date('H:i', strtotime($row['tanggal'])); // Format waktu

    // Tambahkan berita ke array
    $news[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'image' => $row['image'],
        'content' => $row['content'],
        'date' => $date,
        'day' => $day,
        'time' => $time
    ];
}

// Query untuk menghitung total berita yang tidak termasuk berita yang sedang dibuka
$total_query = "SELECT COUNT(*) AS total FROM berita WHERE id != $excludeId";
$total_result = mysqli_query($conn, $total_query);
$total_rows = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_rows / $limit);

// Kirimkan data berita dalam format JSON
echo json_encode([
    'news' => $news,
    'total_pages' => $total_pages
]);
?>
