<?php
include 'koneksi.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nama']) && isset($data['skor'])) {
    $nama = mysqli_real_escape_string($conn, $data['nama']);
    $skor = (int)$data['skor'];

    $query = "INSERT INTO leaderboard2 (nama, skor) VALUES ('$nama', '$skor')";
    if (mysqli_query($conn, $query)) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
} else {
    echo "Data tidak valid.";
}
?>
