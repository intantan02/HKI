<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hki";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => true, 'message' => 'Koneksi gagal: ' . $conn->connect_error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete_id = $_POST['delete_id'];
    $role = $_POST['role'];

    if ($role == 'Dosen') {
        $sql_delete = "DELETE FROM data_pribadi_dosen WHERE id = ?";
    } else {
        $sql_delete = "DELETE FROM data_pribadi_mahasiswa WHERE id = ?";
    }

    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);

    if ($stmt_delete->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data berhasil dihapus!']);
    } else {
        echo json_encode(['error' => true, 'message' => 'Gagal menghapus data!']);
    }

    $stmt_delete->close();
}
$conn->close();
?>