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
include 'config.php'; // Menghubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $kewarganegaraan = $_POST['kewarganegaraan'];
    $alamat = $_POST['alamat'];
    $negara = $_POST['negara'];
    $provinsi = $_POST['provinsi'];
    $kota = $_POST['kota'];
    $kecamatan = $_POST['kecamatan'];
    $pemegang_hakcipta = $_POST['pemegang_hakcipta'];

    $sql = "INSERT INTO pencipta_alamat (alamat, negara, provinsi, kota, kecamatan, pemegang_hakcipta) 
            VALUES ('$alamat', '$negara', '$provinsi', '$kota', '$kecamatan', '$pemegang_hakcipta')";

if ($stmt->execute()) {
    echo "<script>alert('Data berhasil disimpan!');</script>";
    header("location:daftar_user.php");
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
        Halaman Input Alamat
    </div>
    <br>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-5 rounded-lg shadow-lg w-full max-w-3xl"> 
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">TAMBAH PENCIPTA (ALAMAT)</h1>
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form>
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex items-center">
                        <label class="w-1/4 text-gray-700">Alamat</label>
                        <input type="text" name="alamat" placeholder="Masukan Alamat lengkap Pencipta" class="w-3/4 p-2 border border-gray-300 rounded">
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-gray-700">Negara</label>
                        <select name="negara" class="w-3/4 p-2 border border-gray-300 rounded">
                            <option value=""></option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="">blabla</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-gray-700">Provinsi</label>
                        <select name="provinsi" class="w-3/4 p-2 border border-gray-300 rounded">
                            <option value=""></option>
                            <option value="DIY">DIY</option>
                            <option value="">blabla</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-gray-700">Kabupaten/ Kota</label>
                        <select name="kota" class="w-3/4 p-2 border border-gray-300 rounded">
                            <option value=""></option>
                            <option value="sleman">SlEMAN</option>
                            <option value="">blabla</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-gray-700">Kecamatan</label>
                        <select name="kecamatan" class="w-3/4 p-2 border border-gray-300 rounded">
                            <option value=""></option>
                            <option value="apa">apa ya</option>
                            <option value="">blabla</option>
                        </select>
                    </div>
                    <br>
                    <div class="flex items-center">
                        <label name="pemegang_hakcipta" class="w-1/4 text-gray-700">Apakah data pencipta diatas merupakan data pemegang hakcipta ?</label>
                        <select class="w-3/4 p-2 border border-gray-300 rounded">
                            <option value="YAY">IYA</option>
                            <option value="NAY">TIDAK</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="flex justify-between mt-6">
                    <a href="tambah_pencipta.php">
                        <button type="button" class="bg-green-700 text-white px-4 py-2 rounded">SEBELUMNYA</button>
                    </a>
                    <a href="inputawal.php">

                        <button type="button" class="bg-green-700 text-white px-4 py-2 rounded">TAMBAH</button>
                    </a>
            </div>
            </form>
        </div>
    </div>
</body>
</html>