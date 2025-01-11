<?php
include 'koneksi.php';

$difficulty = $_GET['difficulty'];
$whereClause = $difficulty !== 'all' ? "WHERE difficulty = '$difficulty'" : '';
$query = "SELECT username, score, accuracy, difficulty FROM leaderboard $whereClause ORDER BY score DESC LIMIT 10";
$result = mysqli_query($conn, $query);

echo "<table border='1'><tr><th>Username</th><th>Score</th><th>Accuracy</th><th>Difficulty</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>{$row['username']}</td><td>{$row['score']}</td><td>{$row['accuracy']}%</td><td>{$row['difficulty']}</td></tr>";
}
echo "</table>";
?>
