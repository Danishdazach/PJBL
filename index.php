<?php
// Memulai session agar bisa mengakses session variables
session_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'beranda'; // Default ke halaman 'home' jika tidak ada parameter 'page'
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMP Negeri 5 Malang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="stylenav.css">
    <link rel="stylesheet" href="stylesprofil.css">
    <link href="IMG/SMPN5.png" rel="icon">
</head>
<body>
    <!-- Hero Section untuk halaman Home -->
    <section class="position-relative d-flex align-items-center min-vh-100 bg-dark text-white">
        <div id="heroCarousel" class="carousel slide position-absolute top-0 start-0 w-100 h-100" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner h-100">
                <div class="carousel-item active" style="background-image: url('IMG/Hero/02.jpg'); background-size: cover; background-position: center; height: 100%;"></div>
                <div class="carousel-item" style="background-image: url('IMG/Hero/03.jpg'); background-size: cover; background-position: center; height: 100%;"></div>
                <div class="carousel-item" style="background-image: url('IMG/Hero/1726622545613.jpg'); background-size: cover; background-position: center; height: 100%;"></div>
                <div class="carousel-item" style="background-image: url('IMG/Hero/BANNER.JPG'); background-size: cover; background-position: center; height: 100%;"></div>
            </div>
            <div class="carousel-indicators mb-4">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
        </div>
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
        <div class="container position-relative z-3">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold">Selamat Datang di Sekolah Kami</h1>
                    <p class="lead">Jaya, jaya, jaya luar biasa</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container-fluid px-lg-5">
            <a class="navbar-brand d-flex align-items-center text-white" href="index.php?page=beranda">
                <img src="IMG/SMPN5.png" alt="Logo" height="60" class="me-2">
                <span class="brand-font">SMP Negeri 5 Malang</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white <?= ($page == 'beranda') ? 'active-custom' : '' ?>" href="index.php?page=beranda">Beranda</a></li>   
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white <?= ($page == 'profil') ? 'active-custom' : '' ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profil Sekolah</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-white <?= ($page == '1sambutan_kepala_sekolah') ? 'active-custom' : '' ?>" href="index.php?page=1sambutan_kepala_sekolah#sambutan">Kepala Sekolah</a></li>
                            <li><a class="dropdown-item text-white <?= ($page == '1visidanmisisekolah') ? 'active-custom' : '' ?>" href="index.php?page=1visidanmisisekolah#visimisisekolah">Visi dan Misi</a></li>
                            <li><a class="dropdown-item text-white <?= ($page == '1sejarah') ? 'active-custom' : '' ?>" href="index.php?page=1sejarah#sejarah">Sejarah Sekolah</a></li>
                            <li><a class="dropdown-item text-white <?= ($page == '1gurudankaryawan') ? 'active-custom' : '' ?>" href="index.php?page=1gurudankaryawan#karyawan">Guru dan Karyawan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white <?= ($page == 'kesiswaan') ? 'active-custom' : '' ?>" href="index.php?page=kesiswaan#osis">Kesiswaan</a></li>
                    <li class="nav-item"><a class="nav-link text-white <?= ($page == 'fasilitas') ? 'active-custom' : '' ?>" href="index.php?page=fasilitas#fasilitas">Fasilitas</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white <?= ($page == 'perpustakaan') ? 'active-custom' : '' ?>" href="#" role="button" data-bs-toggle="dropdown">Perpustakaan</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-white <?= ($page == '2profilperpustakaan') ? 'active-custom' : '' ?>" href="index.php?page=2profilperpustakaan#perpus">Profil Perpustakaan</a></li>
                            <li><a class="dropdown-item text-white <?= ($page == '2visimisiperpustakaan') ? 'active-custom' : '' ?>" href="index.php?page=2visimisiperpustakaan#visimisiperpus">Visi dan Misi Perpustakaan</a></li>
                            <li><a class="dropdown-item text-white <?= ($page == '2galeriperpustakaan') ? 'active-custom' : '' ?>" href="index.php?page=2galeriperpustakaan#galeriperpus">Galeri Perpustakaan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white <?= ($page == 'portalsiswa') ? 'active-custom' : '' ?>" href="#" role="button" data-bs-toggle="dropdown">Portal Siswa</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-white <?= ($page == '3informasiujian') ? 'active-custom' : '' ?>" href="index.php?page=3informasiujian#ujian">Informasi Ujian</a></li>
                            <li><a class="dropdown-item text-white <?= ($page == '3jadwalpelajaran') ? 'active-custom' : '' ?>" href="index.php?page=3jadwalpelajaran#jadwal">Jadwal Pelajaran</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white <?= ($page == 'kontak') ? 'active-custom' : '' ?>" href="index.php?page=kontak#kontak">Hubungi Kami</a></li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['username'])): ?>
                            <!-- If user is logged in, show Logout link -->
                            <a class="nav-link text-white" href="logout.php">Logout</a>
                        <?php else: ?>
                            <!-- If user is not logged in, show Login link -->
                            <a class="nav-link text-white <?= ($page == 'login') ? 'active-custom' : '' ?>" href="index.php?page=login#login">Login</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Dinamis Berdasarkan Halaman -->
    <div class="container mt-5">
        <?php
        // Memuat halaman sesuai dengan parameter 'page'
        switch ($page) {
            case 'login':
                include 'database/login.php';
                break;
            case 'daftar':
                include 'database/daftar.php';
                break;     
            case 'beranda':
                include 'pages/beranda.php';
                break;
            case '1sambutan_kepala_sekolah':
                include 'pages/1sambutan_kepala_sekolah.php';
                break;
            case '1visidanmisisekolah':
                include 'pages/1visidanmisisekolah.php';
                break;
            case '1sejarah':
                include 'pages/1sejarah.php';
                break;
            case '1struktur':
                include 'pages/1struktur.php';
                break;
            case '1gurudankaryawan':
                include 'pages/1gurudankaryawan.php';
                break;
            case 'kesiswaan':
                include 'pages/kesiswaan.php';
                break;
            case 'fasilitas':
                include 'pages/fasilitas.php';
                break;
            case '2profilperpustakaan':
                include 'pages/2profilperpustakaan.php';
                break;
            case '2visimisiperpustakaan':
                include 'pages/2visimisiperpustakaan.php';
                break;
            case '2galeriperpustakaan':
                include 'pages/2galeriperpustakaan.php';
                break;
            case '3informasiujian':
                include 'pages/3informasiujian.php';
                break;
            case '3jadwalpelajaran':
                include 'pages/3jadwalpelajaran.php';
                break;
            case 'kontak':
                include 'pages/kontak.php';
                break;
            default:
                echo "<h1>Halaman Tidak Ditemukan</h1>";
                break;
        }
        ?>
    </div>

    <!-- Footer -->
    <footer id="Kontak" class="bg-purple text-white pt-5 pb-3" style="background-color: #6f42c1;">
        <div class="container">
            <div class="row gy-4">
                <!-- Kolom Sekolah -->
                <div class="col-lg-4 text-center">
                    <div class="pe-lg-4">
                        <h5 class="mb-3 fw-bold">SMP Negeri 5 Malang</h5>
                        <p class="mb-3">"KRIDA BAKTI SATRIA HANORAGA"</p>
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d493.9141612548797!2d112.63810564521722!3d-7.966530779396892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62836b3e501ef%3A0x62fe7872d354c212!2sSMP%20Negeri%205%20Malang!5e0!3m2!1sid!2sid!4v1730781586007!5m2!1sid!2sid" 
                            width="325" 
                            height="200" 
                            style="border: none; border-radius: 20px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            alt="Map">
                        </iframe>
                    </div>
                </div>
    
                <!-- Kolom Kontak -->
                <div class="col-lg-4">
                    <div class="px-lg-4">
                        <h5 class="mb-3 fw-bold">Kontak Kami</h5>
                        <ul class="list-unstyled footer-links">
                            <li class="mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-telephone-fill me-3"></i>
                                    <span>(0341) 482713</span>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-envelope-fill me-3"></i>
                                    <span>surat@smpn5-mlg.sch.id</span>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <i class="bi bi-geo-alt-fill me-3 mt-1"></i>
                                    <span>Jl. W.R. Supratman No.12, RT.3/RW.3, Rampal Celaket, 
                                        Kec. Klojen, Kota Malang, Jawa Timur 65111</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Kolom Sosial Media -->
                <div class="col-lg-4">
                    <div class="ps-lg-4">
                        <h5 class="mb-3 fw-bold">Sosial Media</h5>
                        <p class="mb-3">Ikuti kami di media sosial untuk informasi terbaru:</p>
                        <div class="d-flex justify-content-start flex-wrap">
                            <div class="d-flex align-items-center me-4">
                                <a href="https://www.instagram.com/smpn5kotamalang?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-white me-2 social-icon">
                                    <i class="bi bi-instagram" style="font-size: 1.5rem;"></i>
                                </a>
                                <span class="text-white">Instagram</span>
                            </div>
                            <div class="d-flex align-items-center me-4">
                                <a href="https://youtube.com/@smpn5malang647?si=GiC5_MmS68H1fYZi" class="text-white me-2 social-icon">
                                <i class="bi bi-youtube" style="font-size: 1.5rem;"></i>
                                </a>
                                <span class="text-white">YouTube</span>
                            </div>
                            <div class="d-flex align-items-center me-4">
                                <a href="#" class="text-white me-2 social-icon">
                                    <i class="bi bi-facebook" style="font-size: 1.5rem;"></i>
                                </a>
                                <span class="text-white">Facebook</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="text-white me-2 social-icon">
                                    <i class="bi bi-twitter" style="font-size: 1.5rem;"></i>
                                </a>
                                <span class="text-white">Twitter</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Copyright -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
                    <small>&copy; 2024 SMP Negeri 5 Malang. All rights reserved.</small>
                    <small>Desain oleh Kelompok 9</small> <!-- Tambahkan nama Anda di sini -->
                </div>
            </div>
        </div>
    </footer>

    <script src="nav.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
