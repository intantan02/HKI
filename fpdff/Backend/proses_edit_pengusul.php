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
    $id = $_POST['id'];
    $role = $_POST['role'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kode_pos = $_POST['kode_pos'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $email = $_POST['email'];
    $fakultas = $_POST['fakultas'];

    if ($role == 'Dosen') {
        $sql_update = "UPDATE data_pribadi_dosen SET Nama = ?, Alamat = ?, Kode_Pos = ?, Nomor_Telepon = ?, Email = ?, Fakultas = ? WHERE id = ?";
    } else {
        $sql_update = "UPDATE data_pribadi_mahasiswa SET Nama = ?, Alamat = ?, Kode_Pos = ?, Nomor_Telepon = ?, Email = ?, Fakultas = ? WHERE id = ?";
    }

    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssssi", $nama, $alamat, $kode_pos, $nomor_telepon, $email, $fakultas, $id);

    if ($stmt_update->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data berhasil diperbarui!']);
    } else {
        echo json_encode(['error' => true, 'message' => 'Gagal memperbarui data!']);
    }

    $stmt_update->close();
}
$conn->close();
?>