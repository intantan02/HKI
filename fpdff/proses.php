<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hki";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$kode_pos = $_POST['kode_pos'];
$telepon = $_POST['nomer_telepon'];
$fakultas = $_POST['fakultas'];
$role = $_POST['role'];
$email = $_POST['email'];
$dataid = intval($_POST['dataid']);

if ($role == "Dosen") {
    $sql = "INSERT INTO data_pribadi_dosen (Nama, Alamat, Kode_Pos, Nomor_Telepon, Fakultas, Email, dataid) VALUES (?, ?, ?, ?, ?, ?, ?)";
} else {
    $sql = "INSERT INTO data_pribadi_mahasiswa (Nama, Alamat, Kode_Pos, Nomor_Telepon, Fakultas, Email, dataid) VALUES (?, ?, ?, ?, ?, ?, ?)";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $nama, $alamat, $kode_pos, $telepon, $fakultas, $email, $dataid);

if ($stmt->execute()) {
    header("Location: input.php?dataid=$dataid");
    exit();
} else {
    echo "Gagal menambahkan data: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
