<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hki";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses penyimpanan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataid = $_POST['dataid'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kode_pos = $_POST['kode_pos'];
    $nomer_telepon = $_POST['nomer_telepon'];
    $fakultas = $_POST['fakultas'];
    $role = $_POST['role'];
    $email = $_POST['email'];

    if ($role === 'Dosen') {
        $sql = "INSERT INTO data_pribadi_dosen (dataid, Nama, Alamat, Kode_Pos, Nomor_Telepon, Fakultas, Email) VALUES (?, ?, ?, ?, ?, ?, ?)";
    } else {
        $sql = "INSERT INTO data_pribadi_mahasiswa (dataid, Nama, Alamat, Kode_Pos, Nomor_Telepon, Fakultas, Email) VALUES (?, ?, ?, ?, ?, ?, ?)";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $dataid, $nama, $alamat, $kode_pos, $nomer_telepon, $fakultas, $email);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data berhasil disimpan!');
            window.location.href = '../Frontend/dataid.php?dataid=$dataid';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyimpan data!');
            window.history.back();
        </script>";
    }

    $stmt->close();
}

// Proses pengambilan data berdasarkan dataid
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['dataid'])) {
    $dataid = $_GET['dataid'];
    $data = [];

    $sql = "SELECT * FROM data_pribadi_dosen WHERE dataid = ? UNION ALL SELECT * FROM data_pribadi_mahasiswa WHERE dataid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $dataid, $dataid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    echo json_encode(['success' => true, 'data' => $data]);
    $stmt->close();
}

$conn->close();
?>