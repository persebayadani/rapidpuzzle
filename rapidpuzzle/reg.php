<?php
session_start();
include 'koneksi2.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$level = "user";

$query_insert = "INSERT INTO reg_op (username, email, password, level)
                VALUES ('$username', '$email', '$password', '$level')";

if (mysqli_query($koneksi, $query_insert)) {
    $query_select = "SELECT * FROM reg_op WHERE username='$username'";
    $result = mysqli_query($koneksi, $query_select);

    if ($result) {
        $data = mysqli_fetch_assoc($result);

        if ($data['level'] == "admin") {
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['level'] = "admin";
            header("location:login.php");
        } else {
            header("location:index.php?pesan=gagal");
        }

        if ($data['level'] == "user") {
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['level'] = "admin";
            header("location:login.php");
        } else {
            header("location:index.php?pesan=gagal");
        }
        

        
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Pendaftaran Gagal : " . mysqli_error($koneksi);
}
?>