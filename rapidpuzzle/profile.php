<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Mengarahkan ke login jika belum login
    exit();
}

// Mengambil data pengguna dari database menggunakan `user_id`
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM reg_op WHERE id_login = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <style>
        /* Reset styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Kontainer Utama */
.main-container {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100vh;
}

/* Kontainer Profil */
.profile-container {
    background-color: #fff;
    width: 100%;
    max-width: 400px;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    text-align: center;
    position: relative;
    transition: transform 0.3s ease;
}

.profile-container:hover {
    transform: translateY(-5px);
}

/* Gambar Profil */
.profile-image {
    margin-bottom: 15px;
}

.profile-image img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    object-fit: cover; /* Pastikan gambar tidak terdistorsi */
}

/* Heading */
.profile-container h2 {
    color: #333;
    font-size: 28px;
    margin-bottom: 20px;
    font-weight: bold;
}

/* Informasi Profil */
.profile-info {
    margin: 20px 0;
    text-align: left;
    background-color: #f4f8fc;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.profile-info p {
    font-size: 16px;
    color: #333;
    margin: 10px 0;
    line-height: 1.6;
}

.profile-info p strong {
    color: #0044cc;
}

/* Tombol */
.btn-container {
    margin-top: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #4a90e2;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    text-decoration: none;
    margin: 5px;
    transition: background-color 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 10px rgba(74, 144, 226, 0.3);
}

.btn:hover {
    background-color: #357ab7;
    box-shadow: 0 6px 15px rgba(74, 144, 226, 0.4);
}

/* Tombol Kembali */
.back-btn {
    position: absolute;
    top: 15px;
    left: 15px;
    color: #4a90e2;
    font-size: 18px;
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: color 0.3s;
}

.back-btn i {
    margin-right: 8px;
}

.back-btn:hover {
    color: #357ab7;
}

    </style>
</head>
<body>
    <div class="main-container">
        <div class="profile-container">
            <!-- Back button to go back to home -->
            <a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>

            <!-- Profile Image -->
            <div class="profile-image">
                <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" 
                     alt="Profile Image">
            </div>

            <!-- User Profile Heading -->
            <h2>User Profile</h2>

            <!-- Profile Information -->
            <div class="profile-info">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            </div>

            <!-- Buttons -->
            <div class="btn-container">
                <a href="edit_profile.php" class="btn">Edit Profile</a>
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
