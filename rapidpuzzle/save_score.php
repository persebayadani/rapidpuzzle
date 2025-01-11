<?php
include 'koneksi.php';

$username = $_POST['username'];
$score = $_POST['score'];
$accuracy = $_POST['accuracy'];
$difficulty = $_POST['difficulty'];

$query = "INSERT INTO leaderboard (username, score, accuracy, difficulty) VALUES ('$username', '$score', '$accuracy', '$difficulty')";
mysqli_query($conn, $query);
?>
