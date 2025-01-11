<?php
include 'koneksi.php';

if (isset($_POST['username']) && isset($_POST['score'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $score = intval($_POST['score']);

    $query = "INSERT INTO leaderboard2 (username, score) VALUES ('$username', '$score')";
    if (mysqli_query($conn, $query)) {
        echo "Score updated successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
