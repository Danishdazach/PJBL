<?php
include 'config.php';

// Tentukan berapa banyak berita yang ditampilkan per halaman
$limit = 7;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk mengambil berita dengan paginasi
$query = "SELECT * FROM berita ORDER BY tanggal DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Array untuk menyimpan berita
$news = [];

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

while ($row = mysqli_fetch_assoc($result)) {
    // Format tanggal menggunakan PHP
    $date = date('d F Y', strtotime($row['tanggal']));
    $day_english = date('l', strtotime($row['tanggal'])); // Mengambil hari dalam bahasa Inggris
    $day = $days_in_indonesia[$day_english]; // Mengganti hari dalam bahasa Inggris ke bahasa Indonesia
    $time = date('H:i', strtotime($row['tanggal'])); // Menyimpan waktu

    // Menambahkan berita ke dalam array
    $news[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'image' => $row['image'],
        'content' => $row['content'],
        'date' => $date,
        'day' => $day, // Menggunakan nama hari dalam bahasa Indonesia
        'time' => $time
    ];
}

// Menghitung total berita
$count_query = "SELECT COUNT(*) AS total FROM berita";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_news = $count_row['total'];
$total_pages = ceil($total_news / $limit); // Menghitung total halaman

// Mengirimkan data berita dan total halaman
echo json_encode(['news' => $news, 'total_pages' => $total_pages]);
?>
