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

$dataid = $_SESSION['dataid'] ?? '';

$sql = "SELECT dp.judul, up.file_ktp, up.file_contoh_karya, up.file_sp, up.file_sph 
        FROM detail_permohonan dp
        JOIN uploads up ON dp.dataid = up.dataid
        WHERE dp.dataid = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dataid);
$stmt->execute();
$result = $stmt->get_result();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
    <title>Daftar Permohonan User</title>
</head>
<body class="bg p-8 flex items-center justify-center min-h-screen">
    <div class="bg-gray-100 w-full max-w-5xl p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">DAFTAR PERMOHONAN USER</h1>
        <div class="w-full flex justify-end items-center mb-6">
            <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                <i class="fas fa-sign-out-alt mr-2"></i>
            </a>
        </div>
<!-- Input Cari dan Tombol Ajukan Permohonan -->
<div class="flex items-center justify-between mb-4 gap-4">
    <input id="searchInput" class="p-2 rounded-lg border border-gray-300 w-1/2" placeholder="Cari Judul..." type="text"/>
    
    <a href="inputawal.php">
        <button class="bg-green-700 text-white px-4 py-2 rounded flex items-center">
            <i class="fas fa-plus mr-2"></i> Ajukan Permohonan
        </button>
    </a>
</div>
<script>
    const searchInput = document.getElementById("searchInput");

    searchInput.addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("tbody tr");

        rows.forEach(row => {
            const judul = row.querySelector("td")?.textContent.toLowerCase();
            if (judul.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>
        
        <div class="bg-white p-4 rounded-lg shadow flex justify-between items-start">
            <table class="border-separate border-spacing-y-2 w-full">
                <thead>
                    <tr>
                        <th>JUDUL</th>
                        <th>SCAN KTP</th>
                        <th>CONTOH KARYA</th>
                        <th>SURAT PERNYATAAN</th>
                        <th>SURAT PENGALIHAN HAK CIPTA</th>
                        <th>STATUS</th>
                        <th>SERTIFIKAT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="bg-white">
                                <td><?= htmlspecialchars($row['judul']) ?></td>
                                <td><a href='uploads/<?= htmlspecialchars($row['file_ktp']) ?>' class='button'>Unduh</a></td>
                                <td><a href='uploads/<?= htmlspecialchars($row['file_contoh_karya']) ?>' class='button'>Unduh</a></td>
                                <td><a href='uploads/<?= htmlspecialchars($row['file_sp']) ?>' class='button'>Unduh</a></td>
                                <td><a href='uploads/<?= htmlspecialchars($row['file_sph']) ?>' class='button'>Unduh</a></td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Tidak ada data</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <br>
        <div>
            <a href="menu_input.php">
                <button type="button" class="bg-teal-700 text-white px-4 py-2 rounded">SEBELUMNYA</button>
            </a>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>