<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hki";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['error' => true, 'message' => 'Koneksi gagal: ' . $conn->connect_error]));
}

// Proses update status dan upload sertifikat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Cek apakah ID tersedia di detail_permohonan
    $check_id = $conn->query("SELECT id FROM detail_permohonan WHERE id = '$id'");
    if ($check_id->num_rows > 0) {
        // Proses sertifikat jika ada file yang diupload
        $sertifikatFile = null;
        if (isset($_FILES['sertifikat']) && $_FILES['sertifikat']['error'] === 0) {
            $ext = pathinfo($_FILES['sertifikat']['name'], PATHINFO_EXTENSION);
            $sertifikatFile = 'uploads/sertifikat_' . $id . '.' . $ext;
            move_uploaded_file($_FILES['sertifikat']['tmp_name'], $sertifikatFile);
        }

        // Cek apakah data sudah ada di review_ad
        $check = $conn->query("SELECT * FROM review_ad WHERE detailpermohonan_id = '$id'");
        if ($check->num_rows > 0) {
            if ($sertifikatFile) {
                $stmt = $conn->prepare("UPDATE review_ad SET status = ?, sertifikat = ? WHERE detailpermohonan_id = ?");
                $stmt->bind_param("ssi", $status, $sertifikatFile, $id);
            } else {
                $stmt = $conn->prepare("UPDATE review_ad SET status = ? WHERE detailpermohonan_id = ?");
                $stmt->bind_param("si", $status, $id);
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO review_ad (status, sertifikat, detailpermohonan_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $status, $sertifikatFile, $id);
        }

        $stmt->execute();
        $stmt->close();
    }
    echo json_encode(['success' => true, 'message' => 'Data berhasil diperbarui']);
    exit();
}

// Ambil data untuk ditampilkan di tabel
$sql = "
    SELECT dp.id, dp.judul, up.file_ktp, up.file_contoh_karya, up.file_sp, up.file_sph, up.file_bukti_pembayaran,
           ra.status, ra.sertifikat
    FROM detail_permohonan dp
    LEFT JOIN uploads up ON dp.dataid = up.dataid
    LEFT JOIN review_ad ra ON dp.id = ra.detailpermohonan_id
    ORDER BY dp.id DESC";

$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['success' => true, 'data' => $data]);
$conn->close();
?>