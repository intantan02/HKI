<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['upload_session_id'])) {
    $_SESSION['upload_session_id'] = uniqid('sess_', true);
}
$session_id = $_SESSION['upload_session_id'];

// Cek apakah dataid tersedia
if (!isset($_POST['dataid']) || empty($_POST['dataid'])) {
    header("Location: upload.php?status=error&msg=" . urlencode("DataID tidak ditemukan!"));
    exit;
}

$dataid = $_POST['dataid'];
$targetDir = "uploads/";

function uploadFile($inputName, $session_id) {
    global $targetDir;
    if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] === 4) {
        return null;
    }

    $originalName = basename($_FILES[$inputName]["name"]);
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    $newFileName = $session_id . "_" . $inputName . "." . $extension;
    $targetFile = $targetDir . $newFileName;

    if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFile)) {
        return $newFileName;
    }
    return null;
}

// Upload semua file
$file_sp = uploadFile('file_sp', $session_id);
$file_sph = uploadFile('file_sph', $session_id);
$file_contoh_karya = uploadFile('file_contoh_karya', $session_id);
$file_ktp = uploadFile('file_ktp', $session_id);
$file_bukti_pembayaran = uploadFile('file_bukti_pembayaran', $session_id);
$file_npwp = uploadFile('file_npwp', $session_id);
$file_akta_pendirian = uploadFile('file_akta_pendirian', $session_id);
$contoh_ciptaan_link = isset($_POST['contoh_ciptaan_link']) ? $_POST['contoh_ciptaan_link'] : null;

// Cek kelengkapan file wajib
if (!$file_sp || !$file_sph || !$file_contoh_karya || !$file_ktp || !$file_bukti_pembayaran) {
    header("Location: upload.php?status=error&msg=" . urlencode("File wajib belum lengkap!"));
    exit;
}

// Simpan ke database
$sql = "INSERT INTO uploads (
    session_id, dataid, file_sp, file_sph, file_contoh_karya, file_ktp,
    contoh_ciptaan_link, file_npwp, file_akta_pendirian, file_bukti_pembayaran, uploaded_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssss",
    $session_id,
    $dataid,
    $file_sp,
    $file_sph,
    $file_contoh_karya,
    $file_ktp,
    $contoh_ciptaan_link,
    $file_npwp,
    $file_akta_pendirian,
    $file_bukti_pembayaran
);

if ($stmt->execute()) {
    header("Location: upload.php?status=success");
} else {
    header("Location: upload.php?status=error&msg=" . urlencode("Gagal menyimpan data!"));
}
exit;
?>
