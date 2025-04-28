<?php
session_start(); include 'koneksi.php';
if (\$_SERVER['REQUEST_METHOD'] === 'POST') {
    \$idp = \$_SESSION['id_permohonan'];
    \$nama  = \$conn->real_escape_string(\$_POST['nama']);
    \$alamat= \$conn->real_escape_string(\$_POST['alamat']);
    \$table = (\$_SESSION['role_data']==='dosen'? 'data_pribadi_dosen':'data_pribadi_mahasiswa');
    \$conn->query("INSERT INTO \$table (id_permohonan, nama, alamat) VALUES ('\$idp','\$nama','\$alamat')");
    header('Location: ../frontend/dataid.php'); exit();
}
?>