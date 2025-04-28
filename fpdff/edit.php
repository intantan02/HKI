<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'hki';
$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Ambil data berdasarkan ID
$id = isset($_GET['id']) ? $_GET['id'] : null;
$role = isset($_GET['role']) ? $_GET['role'] : null;

if (!$id || !$role) {
    die("ID atau role tidak ditemukan!");
}

$table = $role === 'Mahasiswa' ? 'data_pribadi_mahasiswa' : 'data_pribadi_dosen';
$query = "SELECT * FROM $table WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    die("Data tidak ditemukan!");
}

$data = $result->fetch_assoc();

// Perbarui data jika formulir dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nama = $conn->real_escape_string($_POST['Nama']);
    $Alamat = $conn->real_escape_string($_POST['Alamat']);
    $Kode_Pos = $conn->real_escape_string($_POST['Kode_Pos']);
    $Nomer_Telepon = $conn->real_escape_string($_POST['Nomer_Telepon']);
    $Fakultas = $conn->real_escape_string($_POST['Fakultas']);
    $Email = $conn->real_escape_string($_POST['Email']);

    $updateQuery = "UPDATE $table SET 
                    nama = '$Nama', 
                    alamat = '$Alamat', 
                    kode_pos = '$Kode_Pos', 
                    nomor_telepon = '$Nomer_Telepon', 
                    fakultas = '$Fakultas', 
                    email = '$Email' 
                    WHERE id = $id";

    if ($conn->query($updateQuery) === TRUE) {
        header("Location: input.php?message=Data berhasil diperbarui");
        exit();
    } else {
        $error = "Gagal memperbarui data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet"/>
    <title>Edit Data</title>
    <!-- <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2e7d32;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 50%;
            background-color: #e0e0e0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #000;
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .form-group label {
            font-weight: bold;
            flex: 1;
        }

        .form-group input,
        .form-group select {
            flex: 2;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #1565c0;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0d47a1;
        }
    </style> -->
</head>
<body class="bg p-8 flex items-center justify-center min-h-screen">
    <div class="bg-gray-100 w-full max-w-5xl p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">
            Edit Data <?= $role ?>
        </h1>
        <div class="bg-white p-6 rounded-b-lg shadow-md mb-6">
         <div class="container">
            <div >

                <?php if (isset($error)): ?>
                    <p style="color: red; text-align: center; font-weight: bold;"><?= $error ?></p>
                <?php endif; ?>
                <form method="POST">
                    
                    <div class="form-group">
                                <div class="row">
                                    <div class="col-4" >
                                <label>Nama</label>
                            </div>
                            
                                <div class="col-8" >
                                    <input class="w-full mt-1 p-2 border rounded" type="text" name="Nama" value="<?= $data['nama'] ?>" required>
                                </div>
                           
                        </div>
                    </div>

                    <div class="form-group">
                <div class="row">
                    <div class="col-4" >
                        <label>Alamat</label>
                    </div>
                    <div class="col-8" >
                        <input class="w-full mt-1 p-2 border rounded" type="text" name="Alamat" value="<?= $data['alamat'] ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-4" >
                            <label>Kode Pos</label>
                        </div>
                        <div class="col-8" >
                            <input class="w-full mt-1 p-2 border rounded" type="text" name="Kode_Pos" value="<?= $data['kode_pos'] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-4" >
                            <label>Nomor Telepon</label>
                        </div>
                        <div class="col-8" >
                            <input class="w-full mt-1 p-2 border rounded" type="text" name="Nomer_Telepon" value="<?= $data['nomor_telepon'] ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-4" >
                            <label>Fakultas</label>
                        </div>
                        <div class="col-8" >
                            <select class="w-full mt-1 p-2 border rounded" name="Fakultas" required>
                                <option value="">Pilih Fakultas</option>
                                <option value="Fakultas Teknologi Mineral dan Energi" <?= $data['fakultas'] === 'Fakultas Teknologi Mineral dan Energi' ? 'selected' : '' ?>>Fakultas Teknologi Mineral dan Energi</option>
                                <option value="Fakultas Ekonomi dan Bisnis" <?= $data['fakultas'] === 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' ?>>Fakultas Ekonomi dan Bisnis</option>
                                <option value="Fakultas Pertanian" <?= $data['fakultas'] === 'Fakultas Pertanian' ? 'selected' : '' ?>>Fakultas Pertanian</option>
                                <option value="Fakultas Teknik Industri" <?= $data['fakultas'] === 'Fakultas Teknik Industri' ? 'selected' : '' ?>>Fakultas Teknik Industri</option>
                                <option value="Fakultas Ilmu Sosial dan Ilmu Politik" <?= $data['fakultas'] === 'Fakultas Ilmu Sosial dan Ilmu Politik' ? 'selected' : '' ?>>Fakultas Ilmu Sosial dan Ilmu Politik</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-4" >
                            <label>Email</label>
                        </div>
                        <div class="col-8" >
                            <input class="w-full mt-1 p-2 border rounded" type="email" name="Email" value="<?= $data['email'] ?>" required>
                        </div>
                    </div>
                </div>
        </div>
     </div>
     
    </div>
</div>
<div class="flex justify-between mt-4">
    <a href="input.php"><button type="button" class="bg-green-800 text-white px-4 py-2 rounded">SEBELUMNYA</button></a>
    <button class="bg-green-800 text-white px-4 py-2 rounded" type="submit" class="submit-btn">Simpan Perubahan</button>
</div>
</form>
</body>
</html>

<?php $conn->close(); ?>