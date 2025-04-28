<?php
$host = "localhost"; // Sesuaikan dengan host database
$user = "root"; // Sesuaikan dengan user database
$pass = ""; // Sesuaikan dengan password database
$dbname = "hki"; // Sesuaikan dengan nama database

$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $kewarganegaraan = $_POST['kewarganegaraan'];

    $sql = "INSERT INTO pencipta (nama, email, no_telp, kewarganegaraan) 
            VALUES ('$nama', '$email', '$no_telp', '$kewarganegaraan')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $jenis_permohonan, $jenis_ciptaan, $sub_jenis_ciptaan, $judul, $uraian_singkat, $tanggal_pertama_kali_diumumkan, $negara_pertama_kali_diumumkan, $kota_pertama_kali_diumumkan, $jenis_pendanaan, $jenis_hibah);

if ($stmt->execute()) {
    echo "<script>alert('Data berhasil disimpan!');</script>";
    header("location: tb2.php");
} else {
    echo "<script>alert('Gagal menyimpan data: " . $stmt->error . "');</script>";
}
$stmt->close();

    $conn->close();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pencipta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-green-800 flex items-center justify-center min-h-screen">
    <div class="bg-green-700 text-green-300 absolute top-0 left-0 w-full p-4">
        Halaman Input seluruh Pencipta
    </div>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">TAMBAH PENCIPTA</h1>
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form>
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex items-center">
                        <label class="w-1/4 text-gray-700">Nama</label>
                        <input type="text" name="nama" placeholder="Masukan Nama Pencipta" class="w-3/4 p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-gray-700">Email</label>
                        <input type="email" name="email" placeholder="Masukan Email Pencipta" class="w-3/4 p-2 border border-gray-300 rounded">
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-gray-700">No. Telp</label>
                        <input type="text" name="no_telp" placeholder="Masukkan nomor telepon Pencipta" class="w-3/4 p-2 border border-gray-300 rounded">
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-gray-700">Kewarganegaraan</label>
                        <select name="kewarganegaraan" class="w-3/4 p-2 border border-gray-300 rounded">
                            <option value="Indonesia">Indonesia</option>
                            <option value="">blabla</option>
                        </select>
                    </div>
                    
                </div>
                <div class="flex justify-end mt-6">
                        
                        <button class="bg-green-800 text-white px-4 py-2 rounded"><a href="tb2.php">SELANJUTNYA</a></button>
                    
                    </div>
            </form>
        </div>
    </div>
</body>
</html>