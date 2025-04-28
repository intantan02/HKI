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

// Proses update status dan upload sertifikat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Cek apakah ID tersedia di detail_permohonan
    $check_id = $conn->query("SELECT id FROM detail_permohonan WHERE id = '$id'");
    if ($check_id->num_rows > 0) {
        // Proses sertifikat jika ada file yang diupload
        $sertifikatFile = null;
        if (isset($_FILES['sertifikat']) && $_FILES['sertifikat']['error'] === 0) {
            $ext = pathinfo($_FILES['sertifikat']['name'], PATHINFO_EXTENSION);
            $sertifikatFile = 'uploads/sertifikat_' . $id . '.' . $ext;
            move_uploaded_file($_FILES['sertifikat']['tmp_name'], $sertifikatFile);
        }

        // Cek apakah data sudah ada di review_ad
        $check = $conn->query("SELECT * FROM review_ad WHERE detailpermohonan_id = '$id'");
        if ($check->num_rows > 0) {
            if ($sertifikatFile) {
                $stmt = $conn->prepare("UPDATE review_ad SET status = ?, sertifikat = ? WHERE detailpermohonan_id = ?");
                $stmt->bind_param("ssi", $status, $sertifikatFile, $id);
            } else {
                $stmt = $conn->prepare("UPDATE review_ad SET status = ? WHERE detailpermohonan_id = ?");
                $stmt->bind_param("si", $status, $id);
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO review_ad (status, sertifikat, detailpermohonan_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $status, $sertifikatFile, $id);
        }

        $stmt->execute();
        $stmt->close();
    }
}

// Ambil data
$sql = "
    SELECT dp.id, dp.judul, up.file_ktp, up.file_contoh_karya, up.file_sp, up.file_sph, up.file_bukti_pembayaran,
           ra.status, ra.sertifikat
    FROM detail_permohonan dp
    LEFT JOIN uploads up ON dp.dataid = up.dataid
    LEFT JOIN review_ad ra ON dp.id = ra.detailpermohonan_id
    ORDER BY dp.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Permohonan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #06402B;
        }

        .container {
            margin-top: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
            
        }

        table {
            text-align: center;
        }

        th {
            background-color: #f1f1f1;
            font-weight: 600;
            vertical-align: middle !important;
        }

        .badge-diajukan {
            background-color: #ffc107;
            color: #000;
        }

        .badge-revisi {
            background-color: #dc3545;
            color: #fff;
        }

        .badge-terdaftar {
            background-color: #198754;
            color: #fff;
        }

        .form-select,
        .btn {
            width: 100%;
        }

        .form-upload {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .text-muted {
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="text-center mb-4">DAFTAR PERMOHONAN</h3>
    <input id="searchInput" class="p-2 rounded-lg border border-gray-300 w-1/2" placeholder="Cari Judul..." type="text"/>
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
    <br>
    <table class="table table-bordered table-striped align-middle">
        <thead>
        <tr>
            <th>Judul</th>
            <th>KTP</th>
            <th>Contoh Karya</th>
            <th>Bukti Pembayaran</th>
            <th>SP</th>
            <th>SPH</th>
            <th>Proses Status</th>
            <th>Status</th>
            <th>Sertifikat</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><a href="uploads/<?= htmlspecialchars($row['file_ktp']) ?>" target="_blank">Unduh</a></td>
                <td><a href="uploads/<?= htmlspecialchars($row['file_contoh_karya']) ?>" target="_blank">Unduh</a></td>
                <td><a href="uploads/<?= htmlspecialchars($row['file_bukti_pembayaran']) ?>" target="_blank">Unduh</a></td>
                <td><a href="uploads/<?= htmlspecialchars($row['file_sp']) ?>" target="_blank">Unduh</a></td>
                <td><a href="uploads/<?= htmlspecialchars($row['file_sph']) ?>" target="_blank">Unduh</a></td>
                <td>
                    <form method="POST" enctype="multipart/form-data" class="form-upload">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                        <select name="status" class="form-select">
                            <option value="Diajukan" <?= ($row['status'] ?? '') === 'Diajukan' ? 'selected' : '' ?>>Diajukan</option>
                            <option value="Revisi" <?= ($row['status'] ?? '') === 'Revisi' ? 'selected' : '' ?>>Revisi</option>
                            <option value="Terdaftar" <?= ($row['status'] ?? '') === 'Terdaftar' ? 'selected' : '' ?>>Terdaftar</option>
                        </select>
                        <input type="file" name="sertifikat" class="form-control">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </td>
                <td>
                    <?php
                    $badgeClass = '';
                    if ($row['status'] === 'Diajukan') {
                        $badgeClass = 'badge-diajukan';
                    } elseif ($row['status'] === 'Revisi') {
                        $badgeClass = 'badge-revisi';
                    } elseif ($row['status'] === 'Terdaftar') {
                        $badgeClass = 'badge-terdaftar';
                    }
                    ?>
                    <?php if (!empty($row['status'])): ?>
                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['status']) ?></span>
                    <?php else: ?>
                        <span class="text-muted">Belum diatur</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!empty($row['sertifikat'])): ?>
                        <a href="<?= $row['sertifikat'] ?>" target="_blank">Unduh</a>
                    <?php else: ?>
                        <span class="text-muted">Belum tersedia</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="login_user.php" class="btn btn-success">SEBELUMNYA</a>
    </div>
</div>
</body>
</html>