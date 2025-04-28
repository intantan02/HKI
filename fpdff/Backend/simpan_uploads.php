<?php
session_start(); include 'koneksi.php';
if (isset(\$_FILES['file'])) {
    \$idp = \$_SESSION['id_permohonan'];
    \$file = addslashes(file_get_contents(\$_FILES['file']['tmp_name']));
    \$conn->query("INSERT INTO uploads (id_permohonan, nama_file, data_file)
                  VALUES ('\$idp', '\$_FILES[file][name]', '\$file')");
    // reset id untuk permohonan baru
    unset(\$_SESSION['id_permohonan']);
    header('Location: ../frontend/daftar_user.php'); exit();
}
?>