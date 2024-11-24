<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Redirect ke index.php setelah logout
header('Location: index.php');
exit();
?>
