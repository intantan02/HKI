<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hki";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$dataid = $_SESSION['dataid'] ?? '';

$sql = "SELECT dp.judul, up.file_ktp, up.file_contoh_karya, up.file_sp, up.file_sph 
        FROM detail_permohonan dp
        JOIN uploads up ON dp.dataid = up.dataid
        WHERE dp.dataid = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dataid);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

// Kirim data dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
