<?php
$server = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "toko_mouse"; // Ganti dengan nama database Anda

// Membuat koneksi
$koneksi = mysqli_connect($server, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
