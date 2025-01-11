<?php
session_start();
include 'koneksi.php';

// Ambil data leaderboard dari database
$query = "SELECT * FROM leaderboard2 ORDER BY skor DESC";
$result = mysqli_query($conn, $query);
$leaderboard = [];
while ($row = mysqli_fetch_assoc($result)) {
    $leaderboard[] = $row;
}

// Data per halaman
$data_per_page = 5;

// Hitung total halaman
$total_data = count($leaderboard);
$total_pages = ceil($total_data / $data_per_page);

// Ambil data sesuai halaman
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, min($current_page, $total_pages)); // Pastikan halaman valid
$start_index = ($current_page - 1) * $data_per_page;
$leaderboard_page = array_slice($leaderboard, $start_index, $data_per_page);

// Cek apakah user sudah login dan ambil data user
$user = null;
$profile_image = 'uploads/default-profile.png'; // Gambar default

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM reg_op WHERE id_login = '$user_id'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Periksa apakah gambar profil tersedia
        if (!empty($user['profile_image'])) {
            $profile_image = $user['profile_image'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #8e44ad, #3498db);
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 30px;
        }

        /* Table Styling */
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #2c3e50;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        table th, table td {
            padding: 15px 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #34495e;
            color: #f39c12;
            font-size: 1.1rem;
            text-transform: uppercase;
        }

        table td {
            font-size: 1rem;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #2c3e50;
        }

        table tr:hover {
            background-color: #34495e;
            cursor: pointer;
        }

        table tr td:hover {
            background-color: #f39c12;
            color: #fff;
        }

        /* Header Styling */
        header {
            z-index: 999;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            background: #353738;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .brand {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: none;
        }

        .brand:hover {
            color: #2d3335;
            transition: 0.3s ease;
        }

        .navigation {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .button {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #f1c40f;
            color: #333333;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .button:hover {
            background-color: #e1b90e;
            transform: scale(1.05);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-menu img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .user-menu span {
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
        }

        /* Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 5px;
        }

        .pagination-button {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #34495e;
            color: #f39c12;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .pagination-button:hover {
            background-color: #f39c12;
            color: #333;
            transform: scale(1.05);
        }

        .pagination-button.active {
            background-color: #f39c12;
            color: #333;
            pointer-events: none;
        }
    </style>
</head>
<body>
<header>
    <a href="math.php" class="brand">Leaderboard</a>
    <div class="navigation">
        <a href="math.php" class="button back-to-game">
            <i class="fas fa-arrow-left"></i> Back to Game
        </a>
        <a href="leaderboard2.php" class="button leaderboard">
            <i class="fas fa-trophy"></i> Leaderboard
        </a>
        <?php if ($user): ?>
            <div class="user-menu">
                <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image">
                <span><?php echo htmlspecialchars($user['username']); ?></span>
            </div>
        <?php else: ?>
            <a href="login.php" class="button">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        <?php endif; ?>
    </div>
</header>

<h1>Leaderboard</h1>
<table>
    <tr>
        <th>Rank</th>
        <th>Nama</th>
        <th>Skor</th>
    </tr>
    <?php
    $rank = $start_index + 1; // Perhitungan rank berdasarkan halaman
    foreach ($leaderboard_page as $row) {
        echo "<tr>";
        echo "<td>" . $rank++ . "</td>";
        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
        echo "<td>" . $row['skor'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<!-- Pagination -->
<div class="pagination">
    <?php if ($current_page > 1): ?>
        <a href="?page=<?php echo $current_page - 1; ?>" class="pagination-button">&laquo; Previous</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="pagination-button <?php echo $i == $current_page ? 'active' : ''; ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
    <?php if ($current_page < $total_pages): ?>
        <a href="?page=<?php echo $current_page + 1; ?>" class="pagination-button">Next &raquo;</a>
    <?php endif; ?>
</div>
</body>
</html>
