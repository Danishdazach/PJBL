<?php
include 'config.php';

// Ambil ID berita dari parameter GET
$newsId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($newsId > 0) {
    // Query untuk mengambil berita berdasarkan ID
    $query = "SELECT * FROM berita WHERE id = $newsId";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Format tanggal dan waktu
        $date = date('d F Y', strtotime($row['tanggal']));
        $day_english = date('l', strtotime($row['tanggal']));
        $days_in_indonesia = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $day = $days_in_indonesia[$day_english];
        $time = date('H:i', strtotime($row['tanggal']));

        // Kirimkan data berita dalam format JSON
        echo json_encode([
            'id' => $row['id'],
            'title' => $row['title'],
            'image' => $row['image'],
            'content' => $row['content'],
            'date' => $date,
            'day' => $day,
            'time' => $time
        ]);
    } else {
        echo json_encode(['error' => 'Berita tidak ditemukan']);
    }
} else {
    echo json_encode(['error' => 'ID berita tidak valid']);
}
?>
