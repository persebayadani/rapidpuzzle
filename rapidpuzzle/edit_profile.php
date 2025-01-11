<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM reg_op WHERE id_login = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);

    if (!empty($_FILES['profile_image']['name'])) {
        $image_name = $_FILES['profile_image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image_name);

        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file);



        $update_query = "UPDATE reg_op SET username = '$new_username', email = '$new_email', profile_image = '$target_file' WHERE id_login = '$user_id'";
    } else {
        $update_query = "UPDATE reg_op SET username = '$new_username', email = '$new_email' WHERE id_login = '$user_id'";
    }
    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
        echo "File uploaded successfully!";
    } else {
        echo "Error uploading file.";
    }
    

    if (mysqli_query($conn, $update_query)) {
        $_SESSION['username'] = $new_username;
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
    background: linear-gradient(135deg, #f093fb, #f5576c); /* Background gradient */
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Kontainer Form */
.form-container {
    background-color: #fff;
    width: 100%;
    max-width: 400px;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    text-align: center;
    position: relative;
    transition: transform 0.3s ease;
    animation: fadeIn 0.5s ease-out;
}

.form-container:hover {
    transform: translateY(-5px);
}

/* Animasi smooth untuk form */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.form-container h2 {
    color: #333;
    font-size: 28px;
    margin-bottom: 20px;
    font-weight: bold;
}

/* Styling setiap grup input */
.form-group {
    margin-bottom: 15px;
    text-align: left;
    width: 100%;
}

.form-group label {
    display: block;
    font-size: 16px;
    color: #333;
    margin-bottom: 8px;
}

.form-group input {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    color: #333;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s ease-in-out;
}

.form-group input:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 5px rgba(74, 144, 226, 0.5);
}

/* Styling tombol aksi */
.btn-container {
    margin-top: 20px;
}

.btn {
    display: inline-block;
    padding: 12px 25px;
    font-size: 16px;
    color: #fff;
    background-color: #4a90e2; /* Warna tombol biru */
    border: none;
    border-radius: 25px;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 10px rgba(74, 144, 226, 0.3);
}

.btn:hover {
    background-color: #357ab7;
    box-shadow: 0 6px 15px rgba(74, 144, 226, 0.4);
}

/* Styling tombol kembali */
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

/* Styling untuk input file */
input[type="file"] {
    display: block;
    margin-top: 10px;
    margin-bottom: 20px;
}

/* Responsif untuk layar kecil */
@media (max-width: 480px) {
    .form-container {
        padding: 30px;
    }

    .form-container h2 {
        font-size: 24px;
    }

    .btn {
        padding: 10px 20px;
    }
}

    </style>
</head>
<body>
<div class="form-container">
        <!-- Back button -->
        <a href="profile.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Profile
        </a>

        <h2>Edit Profile</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" 
                       value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" id="profile_image" name="profile_image">
            </div>

            <div class="btn-container">
                <button type="submit" class="btn">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>
