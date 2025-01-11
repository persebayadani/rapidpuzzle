<?php
session_start();
include 'koneksi.php';

// Mengambil data input dari form
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Query untuk memeriksa kecocokan username dan password
$login = mysqli_query($conn, "SELECT * FROM reg_op WHERE username='$username' AND password='$password'");
if (!$login) {
    die("Query failed: " . mysqli_error($conn));
}

// Memeriksa jika username dan password sesuai
if (mysqli_num_rows($login) > 0) {
    $data = mysqli_fetch_assoc($login);

    // Menyimpan id_login dalam sesi untuk identifikasi unik
    $_SESSION['user_id'] = $data['id_login'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['level'] = $data['level'];

    header("Location: index.php");
    exit();
} else {
    header("Location: login.php?pesan=gagal");
    exit();
}

?>
