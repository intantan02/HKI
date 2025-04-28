<?php
session_start();

// Ambil dataid dari session
$dataid = $_SESSION['dataid'] ?? null;

// Cek apakah semua data terkirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && $dataid) {
    $jenis_permohonan = $_POST['jenis_permohonan'] ?? '';
    $jenis_ciptaan = $_POST['jenis_ciptaan'] ?? '';
    $sub_jenis_ciptaan = $_POST['sub_jenis_ciptaan'] ?? '';
    $judul = $_POST['judul'] ?? '';
    $uraian_singkat = $_POST['uraian_singkat'] ?? '';
    $tanggal_pertama_kali_diumumkan = $_POST['tanggal_pertama_kali_diumumkan'] ?? '';
    $negara_pertama_kali_diumumkan = $_POST['negara_pertama_kali_diumumkan'] ?? '';
    $kota_pertama_kali_diumumkan = $_POST['kota_pertama_kali_diumumkan'] ?? '';
    $jenis_pendanaan = $_POST['jenis_pendanaan'] ?? '';
    $jenis_hibah = $_POST['jenis_hibah'] ?? '';
    $created_at = date("Y-m-d H:i:s");

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "hki");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query insert
    $stmt = $conn->prepare("INSERT INTO detail_permohonan 
        (jenis_permohonan, jenis_ciptaan, sub_jenis_ciptaan, judul, uraian_singkat, 
        tanggal_pertama_kali_diumumkan, negara_pertama_kali_diumumkan, kota_pertama_kali_diumumkan, 
        jenis_pendanaan, jenis_hibah, created_at, dataid) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssss", 
        $jenis_permohonan, $jenis_ciptaan, $sub_jenis_ciptaan, $judul, $uraian_singkat,
        $tanggal_pertama_kali_diumumkan, $negara_pertama_kali_diumumkan, $kota_pertama_kali_diumumkan,
        $jenis_pendanaan, $jenis_hibah, $created_at, $dataid);

    if ($stmt->execute()) {
        // Redirect ke halaman berikutnya
        header("Location: input.php?dataid=" . $dataid);
        exit();
    } else {
        echo "Gagal menyimpan data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Data tidak lengkap atau session dataid hilang.";
}
?>
