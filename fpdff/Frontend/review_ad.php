<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Permohonan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="review_ad.js" defer></script>
</head>
<body>
<div class="container">
    <h3 class="text-center mb-4">DAFTAR PERMOHONAN</h3>
    <input id="searchInput" class="p-2 rounded-lg border border-gray-300 w-1/2" placeholder="Cari Judul..." type="text"/>
    <table class="table table-bordered table-striped align-middle mt-4">
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
        <tbody id="permohonanTable">
            <!-- Data akan dimuat oleh JavaScript -->
        </tbody>
    </table>
    <div class="text-center mt-4">
        <a href="login_user.php" class="btn btn-success">SEBELUMNYA</a>
    </div>
</div>
</body>
</html>