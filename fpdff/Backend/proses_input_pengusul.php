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
    $dataid = $_POST['dataid'];
    $role = $_POST['role'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kode_pos = $_POST['kode_pos'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $email = $_POST['email'];
    $fakultas = $_POST['fakultas'];

    if ($role == 'Dosen') {
        $sql_insert = "INSERT INTO data_pribadi_dosen (dataid, Nama, Alamat, Kode_Pos, Nomor_Telepon, Email, Fakultas) VALUES (?, ?, ?, ?, ?, ?, ?)";
    } else {
        $sql_insert = "INSERT INTO data_pribadi_mahasiswa (dataid, Nama, Alamat, Kode_Pos, Nomor_Telepon, Email, Fakultas) VALUES (?, ?, ?, ?, ?, ?, ?)";
    }

    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssss", $dataid, $nama, $alamat, $kode_pos, $nomor_telepon, $email, $fakultas);

    if ($stmt_insert->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data berhasil ditambahkan!']);
    } else {
        echo json_encode(['error' => true, 'message' => 'Gagal menambahkan data!']);
    }

    $stmt_insert->close();
}
$conn->close();
?>