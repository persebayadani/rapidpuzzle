<?php
session_start();
include 'koneksi.php';

// Ambil data leaderboard dari database dengan pagination
$filter = isset($_GET['difficulty']) ? $_GET['difficulty'] : 'all';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Jumlah data per halaman
$offset = ($page - 1) * $limit;

// Total data
$totalQuery = $filter === 'all' 
    ? "SELECT COUNT(*) AS total FROM leaderboard" 
    : "SELECT COUNT(*) AS total FROM leaderboard WHERE difficulty = '$filter'";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$total = $totalRow['total'];

// Hitung total halaman
$totalPages = ceil($total / $limit);

$query = $filter === 'all'
    ? "SELECT username, score, accuracy, difficulty FROM leaderboard ORDER BY score DESC, accuracy DESC LIMIT $limit OFFSET $offset"
    : "SELECT username, score, accuracy, difficulty FROM leaderboard WHERE difficulty = '$filter' ORDER BY score DESC, accuracy DESC LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);
$leaderboard = [];
while ($row = mysqli_fetch_assoc($result)) {
    $leaderboard[] = $row;
}

// Cek apakah user sudah login dan ambil data user
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM reg_op WHERE id_login = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - Aim Trainer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <style>
        /* Header CSS */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

body {
    margin: 0;
    padding: 0;
    font-family: "Poppins", sans-serif;
    background-color: #5e5f60;
    color: #fff;
}

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

.leaderboard-button, .back-to-game-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #f1c40f;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    font-size: 1rem;
    transition: background-color 0.3s, transform 0.2s;
    margin-right: 20px;
}

.leaderboard-button:hover, .back-to-game-button:hover {
    background-color: #e1b90e;
    transform: scale(1.05);
}

.leaderboard-button i, .back-to-game-button i {
    margin-right: 8px;
}

.navigation-items {
    display: flex;
    align-items: center;
}

.user-menu {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}

.user-menu img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.user-menu img:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.user-menu span {
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
}

.leaderboard-container {
    margin-top: 100px;
    padding: 20px;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    background-color: #444;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.leaderboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.leaderboard-header h2 {
    font-size: 1.5rem;
    margin: 0;
}

.tabs {
    display: flex;
    gap: 10px;
}

.tab {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.tab.active {
    background-color: #f1c40f;
    color: #333;
}

.leaderboard-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.leaderboard-table th, .leaderboard-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #666;
}

.leaderboard-table th {
    background-color: #555;
}

.leaderboard-table tbody tr:hover {
    background-color: #666;
}

.pagination {
    margin-top: 20px;
    text-align: center;
    font-size: 1rem;
}

.pagination a {
    display: inline-block;
    margin: 0 5px;
    padding: 8px 12px;
    background-color: #333;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.pagination a:hover {
    background-color: #f1c40f;
    color: #333;
    transform: scale(1.05);
}

.pagination span {
    display: inline-block;
    margin: 0 5px;
    padding: 8px 12px;
    background-color: #666;
    color: #fff;
    border-radius: 5px;
}

footer {
    text-align: center;
    margin-top: 20px;
    color: #ccc;
}

    </style>
</head>
<body>
<header>
    <a href="aimtrainer.php" class="brand">AIM TRAINER</a>
    <div class="navigation">
        <div class="navigation-items">
            <a href="aimtrainer.php" class="back-to-game-button"><i class="fas fa-arrow-left"></i> Back to Game</a>
            <a href="leaderboard.php" class="leaderboard-button"><i class="fas fa-trophy"></i> Leaderboard</a>
            <?php if (isset($user)): ?>
                <div class="user-menu">
                    <img src="<?php echo htmlspecialchars(!empty($user['profile_image']) ? $user['profile_image'] : 'uploads/default-profile.png'); ?>" alt="Profile Image">
                    <span><?php echo htmlspecialchars($user['username']); ?></span>
                </div>
            <?php else: ?>
                <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<div class="leaderboard-container">
    <div class="leaderboard-header">
        <h2>Leaderboard</h2>
        <div class="tabs">
            <button class="tab <?php echo $filter === 'all' ? 'active' : ''; ?>" onclick="window.location.href='leaderboard.php?difficulty=all'">All</button>
            <button class="tab <?php echo $filter === 'easy' ? 'active' : ''; ?>" onclick="window.location.href='leaderboard.php?difficulty=easy'">Easy</button>
            <button class="tab <?php echo $filter === 'medium' ? 'active' : ''; ?>" onclick="window.location.href='leaderboard.php?difficulty=medium'">Medium</button>
            <button class="tab <?php echo $filter === 'hard' ? 'active' : ''; ?>" onclick="window.location.href='leaderboard.php?difficulty=hard'">Hard</button>
        </div>
    </div>
    <table class="leaderboard-table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Score</th>
                <th>Accuracy</th>
                <th>Difficulty</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($leaderboard) > 0): ?>
                <?php foreach ($leaderboard as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['username']); ?></td>
                        <td><?php echo htmlspecialchars($entry['score']); ?></td>
                        <td><?php echo htmlspecialchars($entry['accuracy']); ?>%</td>
                        <td><?php echo htmlspecialchars($entry['difficulty']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="leaderboard.php?difficulty=<?php echo $filter; ?>&page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>
        <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
        <?php if ($page < $totalPages): ?>
            <a href="leaderboard.php?difficulty=<?php echo $filter; ?>&page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</div>
<footer>
    &copy; <?php echo date('Y'); ?> Aim Trainer Game. All Rights Reserved.
</footer>
</body>
</html>
