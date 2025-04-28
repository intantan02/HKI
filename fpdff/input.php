<?php
session_start();
if (!isset($_SESSION['dataid'])) {
    $_SESSION['dataid'] = time() . rand(100, 999);
}
$dataid = isset($_GET['dataid']) ? $_GET['dataid'] : $_SESSION['dataid'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hki";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses penghapusan data
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $role = $_GET['role'];
    
    if ($role == 'Dosen') {
        $sql_delete = "DELETE FROM data_pribadi_dosen WHERE id = ?";
    } else {
        $sql_delete = "DELETE FROM data_pribadi_mahasiswa WHERE id = ?";
    }

    // Siapkan statement untuk menghapus data
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);

    if ($stmt_delete->execute()) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Data berhasil dihapus!',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'daftar_user.php?dataid=" . $dataid . "';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal menghapus data!',
                text: 'Terjadi kesalahan saat menghapus data.',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}

// Ambil data pengusul
$data = [];

if ($dataid) {
    $sql_dosen = "SELECT id, Nama, Alamat, Kode_Pos, Nomor_Telepon, Email, Fakultas, 'Dosen' as role FROM data_pribadi_dosen WHERE dataid = ?";
    $stmt_dosen = $conn->prepare($sql_dosen);
    $stmt_dosen->bind_param("s", $dataid);
    $stmt_dosen->execute();
    $result_dosen = $stmt_dosen->get_result();
    while ($row = $result_dosen->fetch_assoc()) {
        $data[] = $row;
    }

    $sql_mahasiswa = "SELECT id, Nama, Alamat, Kode_Pos, Nomor_Telepon, Email, Fakultas, 'Mahasiswa' as role FROM data_pribadi_mahasiswa WHERE dataid = ?";
    $stmt_mahasiswa = $conn->prepare($sql_mahasiswa);
    $stmt_mahasiswa->bind_param("s", $dataid);
    $stmt_mahasiswa->execute();
    $result_mahasiswa = $stmt_mahasiswa->get_result();
    while ($row = $result_mahasiswa->fetch_assoc()) {
        $data[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Input Surat Permohonan Hak Cipta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg p-8 flex items-center justify-center min-h-screen">
    <div class="bg-gray-100 w-full max-w-5xl p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6">INPUT SURAT PERMOHONAN HAK CIPTA</h1>
        
        <a href="dataid.php?dataid=<?= $dataid ?>">
            <button class="bg-green-800 text-white px-4 py-2 rounded-lg mb-6 flex items-center">
                Tambah Pengusul <i class="fas fa-plus ml-2"></i>
            </button>
        </a>

        <div class="space-y-4">
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $row): ?>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold"><?= htmlspecialchars($row['Nama']) ?></h2>
                                <p class="text-gray-600"><?= htmlspecialchars($row['Alamat']) ?>, <?= htmlspecialchars($row['Kode_Pos']) ?></p>
                                <p class="text-gray-600">📞 <?= htmlspecialchars($row['Nomor_Telepon']) ?></p>
                                <p class="text-gray-600">✉ <?= htmlspecialchars($row['Email']) ?></p>
                                <p class="text-gray-600">🏫 <?= htmlspecialchars($row['Fakultas']) ?></p>
                                <span class="bg-blue-600 text-white px-2 py-1 rounded-full text-sm"><?= htmlspecialchars($row['role']) ?></span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="edit.php?id=<?= $row['id'] ?>&role=<?= $row['role'] ?>&dataid=<?= $dataid ?>" class="text-gray-500 hover:text-gray-700"><i class="fas fa-edit"></i></a>
                                <a href="?delete_id=<?= $row['id'] ?>&role=<?= $row['role'] ?>&dataid=<?= $dataid ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Yakin ingin menghapus?');"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-600 text-center">Belum ada data pengusul ditambahkan.</p>
            <?php endif; ?>
        </div>

        <div class="flex justify-between mt-6">
            <a href="inputawal.php?dataid=<?= $dataid ?>">
                <button class="bg-teal-700 text-white px-4 py-2 rounded">SEBELUMNYA</button>
            </a>
            <a href="preview.php?dataid=<?= $dataid ?>">
                <button class="bg-teal-700 text-white px-6 py-2 rounded">SELANJUTNYA</button>
            </a>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
