<?php
session_start();
include 'koneksi.php';
include 'generate_id.php';
if (\$_SERVER['REQUEST_METHOD'] === 'POST') {
    // generate id otomatis
    \$idp = generate_id(\$conn);
    \$_SESSION['id_permohonan'] = \$idp;
    // ambil input form
    \$judul = \$conn->real_escape_string(\$_POST['judul']);
    \$jenis = \$conn->real_escape_string(\$_POST['jenis_ciptaan']);
    \$email  = trim(\$_POST['email']);
    \$sql = "INSERT INTO detail_permohonan (id_permohonan, username, email, judul, jenis_ciptaan)
            VALUES ('\$idp', '\$_SESSION[username]', '\$email', '\$judul', '\$jenis')";
    \$conn->query(\$sql);
    header('Location: ../frontend/input.php'); exit();
} else header('Location: ../frontend/inputawal.php');
?>