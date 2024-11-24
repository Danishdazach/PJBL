<?php
// Menghubungkan ke database
include('config.php');

if (isset($_POST['submit_berita'])) {
    // Ambil data dari formulir
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Proses upload gambar
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = "IMG/Berita/" . basename($image_name);

    // Pindahkan gambar ke folder tujuan
    move_uploaded_file($image_tmp, $image_path);

    // Menyimpan konten dengan pemisahan paragraf
    $content_paragraphs = '';
    $content_lines = explode("\n", $content);  // Pisahkan setiap baris berdasarkan newline
    foreach ($content_lines as $line) {
        $content_paragraphs .= "<p>" . htmlspecialchars(trim($line)) . "</p>";
    }

    // Query untuk menyimpan berita ke database
    $query = "INSERT INTO berita (title, content, image) VALUES ('$title', '$content_paragraphs', '$image_name')";
    
    if (mysqli_query($conn, $query)) {
        // Redirect atau pesan sukses
        echo "<script>alert('Berita berhasil ditambahkan'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan berita'); window.location='admin_dashboard.php';</script>";
    }
}
?>
