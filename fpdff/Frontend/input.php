<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Surat Permohonan Hak Cipta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="input.js" defer></script>
</head>
<body class="bg p-8 flex items-center justify-center min-h-screen">
    <div class="bg-gray-100 w-full max-w-5xl p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6">INPUT SURAT PERMOHONAN HAK CIPTA</h1>
        
        <a href="dataid.php?dataid=<?= $_GET['dataid'] ?? '' ?>">
            <button class="bg-green-800 text-white px-4 py-2 rounded-lg mb-6 flex items-center">
                Tambah Pengusul <i class="fas fa-plus ml-2"></i>
            </button>
        </a>

        <div class="space-y-4" id="pengusul-list">
            <!-- Data pengusul akan dimuat oleh JavaScript -->
        </div>

        <div class="flex justify-between mt-6">
            <a href="input_awal.php?dataid=<?= $_GET['dataid'] ?? '' ?>">
                <button class="bg-teal-700 text-white px-4 py-2 rounded">SEBELUMNYA</button>
            </a>
            <a href="preview.php?dataid=<?= $_GET['dataid'] ?? '' ?>">
                <button class="bg-teal-700 text-white px-6 py-2 rounded">SELANJUTNYA</button>
            </a>
        </div>
    </div>
</body>
</html>