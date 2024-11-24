<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['username']) || $_SESSION['role_id'] !== 1) {
    header('Location: login.php'); // Arahkan ke login jika bukan admin
    exit();
}

// Koneksi ke database
include 'config.php';

// Query untuk mengambil data berita
$query_berita = "SELECT * FROM berita ORDER BY tanggal DESC";
$result_berita = mysqli_query($conn, $query_berita);

// Menambahkan berita baru
if (isset($_POST['submit_berita'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image = $_FILES['image']['name'];

    $target_dir = "IMG/Berita/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    $insert_query = "INSERT INTO berita (title, content, image, tanggal) VALUES ('$title', '$content', '$image', NOW())";

    if (mysqli_query($conn, $insert_query)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Menghapus berita
if (isset($_GET['delete_berita'])) {
    $id = $_GET['delete_berita'];
    $delete_query = "DELETE FROM berita WHERE id = '$id'";
    mysqli_query($conn, $delete_query);
    header("Location: admin.php");
    exit();
}

// Query untuk mengambil data pesan dari tabel 'kontak'
$query_kontak = "SELECT * FROM kontak ORDER BY tanggal ASC";
$result_kontak = mysqli_query($conn, $query_kontak);

// Menghapus pesan kontak
if (isset($_GET['delete_kontak'])) {
    $id = $_GET['delete_kontak'];
    $delete_query_kontak = "DELETE FROM kontak WHERE id = '$id'";
    mysqli_query($conn, $delete_query_kontak);
    header("Location: admin.php");
    exit();
}

// Hitung jumlah total berita dan pesan
$total_berita = mysqli_num_rows($result_berita);
$total_kontak = mysqli_num_rows($result_kontak);

// Update berita logic
if (isset($_POST['update_berita'])) {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    // Handle image upload if a new image is selected
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "IMG/Berita/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $update_query = "UPDATE berita SET title = '$title', content = '$content', image = '$image' WHERE id = '$id'";
    } else {
        $update_query = "UPDATE berita SET title = '$title', content = '$content' WHERE id = '$id'";
    }
    
    if (mysqli_query($conn, $update_query)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Berita dan Pesan Kontak</title>
    <link href="bootstrap/CSS/bootstrap.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="IMG/SMPN5.png" rel="icon">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover {
            background-color: #343a40;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
        }
        .main-content {
            padding: 20px;
        }
        .dashboard-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .news-card {
            height: 100%;
            transition: transform 0.2s;
        }
        .news-card:hover {
            transform: translateY(-5px);
        }
        .table-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="text-center mb-4">
                    <img src="IMG/SMPN5.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
                    <h4 class="text-white mt-3">Admin Dashboard</h4>
                </div>
                <div class="nav flex-column">
                    <a href="#dashboard" class="nav-link active" data-bs-toggle="pill">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a href="#berita" class="nav-link" data-bs-toggle="pill">
                        <i class="fas fa-newspaper me-2"></i> Kelola Berita
                    </a>
                    <a href="#pesan" class="nav-link" data-bs-toggle="pill">
                        <i class="fas fa-envelope me-2"></i> Pesan Kontak
                    </a>
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="tab-content">
                    <!-- Dashboard Overview -->
                    <div class="tab-pane fade show active" id="dashboard">
                        <h2 class="mb-4">Dashboard Overview</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="dashboard-card bg-primary text-white">
                                    <h3><i class="fas fa-newspaper me-2"></i> Total Berita</h3>
                                    <h2 class="display-4"><?= $total_berita ?></h2>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="dashboard-card bg-success text-white">
                                    <h3><i class="fas fa-envelope me-2"></i> Total Pesan</h3>
                                    <h2 class="display-4"><?= $total_kontak ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kelola Berita -->
                    <div class="tab-pane fade" id="berita">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Kelola Berita</h2>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewsModal">
                                <i class="fas fa-plus me-2"></i>Tambah Berita
                            </button>
                        </div>

                        <div class="row">
                            <?php while ($row_berita = mysqli_fetch_assoc($result_berita)): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card news-card shadow">
                                        <img src="IMG/Berita/<?= $row_berita['image']; ?>" class="card-img-top" alt="<?= $row_berita['title']; ?>" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $row_berita['title']; ?></h5>
                                            <p class="card-text"><?= substr($row_berita['content'], 0, 100); ?>...</p>
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#readNewsModal" 
                                                    data-id="<?= $row_berita['id']; ?>" 
                                                    data-title="<?= $row_berita['title']; ?>" 
                                                    data-content="<?= $row_berita['content']; ?>" 
                                                    data-image="<?= $row_berita['image']; ?>">
                                                    <i class="fas fa-eye me-2"></i>Baca
                                                </a>
                                                <a href="?delete_berita=<?= $row_berita['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                    <i class="fas fa-trash me-2"></i>Hapus
                                                </a>
                                                <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editNewsModal"
                                                    data-id="<?= $row_berita['id']; ?>"
                                                    data-title="<?= $row_berita['title']; ?>"
                                                    data-content="<?= htmlspecialchars($row_berita['content']); ?>">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <!-- Pesan Kontak -->
                    <div class="tab-pane fade" id="pesan">
                        <h2 class="mb-4">Daftar Pesan Kontak</h2>
                        <div class="table-container">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Pesan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($row_kontak = mysqli_fetch_assoc($result_kontak)): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row_kontak['nama']; ?></td>
                                            <td><?= $row_kontak['email']; ?></td>
                                            <td><?= substr($row_kontak['pesan'], 0, 50); ?>...</td>
                                            <td><?= $row_kontak['tanggal']; ?></td>
                                            <td>
                                                <!-- Open Modal for Contact Details -->
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#contactModal" data-id="<?= $row_kontak['id']; ?>" data-nama="<?= $row_kontak['nama']; ?>" data-email="<?= $row_kontak['email']; ?>" data-pesan="<?= $row_kontak['pesan']; ?>" data-tanggal="<?= $row_kontak['tanggal']; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="?delete_kontak=<?= $row_kontak['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Berita -->
    <div class="modal fade" id="addNewsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Berita Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Berita</label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Konten Berita</label>
                            <textarea name="content" class="form-control" id="content" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Berita</label>
                            <input type="file" name="image" class="form-control" id="image" required>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="submit_berita" class="btn btn-primary">Tambah Berita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal untuk Baca Berita -->
    <div class="modal fade" id="readNewsModal" tabindex="-1" aria-labelledby="readNewsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="readNewsModalLabel">Detail Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newsTitle" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control" id="newsTitle" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="newsContent" class="form-label">Konten Berita</label>
                        <textarea class="form-control" id="newsContent" rows="5" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="newsImage" class="form-label">Gambar Berita</label>
                        <img id="newsImage" src="" alt="Gambar Berita" class="img-fluid">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Inisialisasi modal dengan data dari tombol
        var readNewsModal = document.getElementById('readNewsModal');
        readNewsModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // tombol yang mengaktifkan modal
            var id = button.getAttribute('data-id');
            var title = button.getAttribute('data-title');
            var content = button.getAttribute('data-content');
            var image = button.getAttribute('data-image');

            // Set nilai modal dengan data yang diteruskan
            document.getElementById('newsTitle').value = title;
            document.getElementById('newsContent').value = content;
            document.getElementById('newsImage').src = 'IMG/Berita/' + image;
        });
    </script>

    <!-- Modal Edit Berita -->
    <div class="modal fade" id="editNewsModal" tabindex="-1" aria-labelledby="editNewsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNewsModalLabel">Edit Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="admin.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="editNewsId">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Judul Berita</label>
                            <input type="text" name="title" class="form-control" id="editTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editContent" class="form-label">Konten Berita</label>
                            <textarea name="content" class="form-control" id="editContent" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editImage" class="form-label">Gambar Berita</label>
                            <input type="file" name="image" class="form-control" id="editImage">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="update_berita" class="btn btn-primary">Perbarui Berita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Initialize the modal with data from the edit button
    var editNewsModal = document.getElementById('editNewsModal');
    editNewsModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var id = button.getAttribute('data-id');
        var title = button.getAttribute('data-title');
        var content = button.getAttribute('data-content');
        
        // Populate the modal with the selected news data
        document.getElementById('editNewsId').value = id;
        document.getElementById('editTitle').value = title;
        document.getElementById('editContent').value = content;
    });

    </script>

    <!-- Modal Detail Pesan Kontak -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Detail Pesan Kontak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contactName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="contactName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="contactEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="contactEmail" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="contactMessage" class="form-label">Pesan</label>
                        <textarea class="form-control" id="contactMessage" rows="5" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="contactDate" class="form-label">Tanggal</label>
                        <input type="text" class="form-control" id="contactDate" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="?delete_kontak=" class="btn btn-danger" id="deleteContactBtn" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">Hapus Pesan</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the script to handle the modal data passing -->
    <script>
        // Initialize the modal with data from the table row
        var contactModal = document.getElementById('contactModal');
        contactModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var email = button.getAttribute('data-email');
            var pesan = button.getAttribute('data-pesan');
            var tanggal = button.getAttribute('data-tanggal');

            // Set modal content
            document.getElementById('contactName').value = nama;
            document.getElementById('contactEmail').value = email;
            document.getElementById('contactMessage').value = pesan;
            document.getElementById('contactDate').value = tanggal;
            
            // Set the delete button link with the correct contact id
            document.getElementById('deleteContactBtn').href = "?delete_kontak=" + id;
        });
    </script>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>