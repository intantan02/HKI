<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "hki");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$judul = $_POST['judul'] ?? '';
$jenis_permohonan = $_POST['jenis_permohonan'] ?? '';
// ambil data lain sesuai form

// Validasi data (contoh sederhana)
if (empty($judul) || empty($jenis_permohonan)) {
    die("Data tidak lengkap");
}

// Query insert ke tabel detail_permohonan (contoh)
$sql = "INSERT INTO detail_permohonan (judul, jenis_permohonan) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $judul, $jenis_permohonan);
if ($stmt->execute()) {
    echo "Data berhasil disimpan";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
