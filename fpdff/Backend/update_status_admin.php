<?php
session_start(); include 'koneksi.php';
if (\$_SERVER['REQUEST_METHOD']==='POST') {
    \$idp = \$_POST['id_permohonan'];
    \$status = \$conn->real_escape_string(\$_POST['status']);
    \$conn->query("UPDATE review_ad SET status='\$status' WHERE id_permohonan='\$idp'");
    if (\$status==='Terdaftar' && !empty(\$_FILES['sertifikat'])) {
        \$file=addslashes(file_get_contents(\$_FILES['sertifikat']['tmp_name']));
        \$conn->query("UPDATE review_ad SET sertifikat='\$file' WHERE id_permohonan='\$idp'");
    }
    header('Location: ../frontend/review_ad.php'); exit();
}
?>