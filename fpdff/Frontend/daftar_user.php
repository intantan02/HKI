<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/daftar_user.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
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

        <div class="flex items-center justify-between mb-4 gap-4">
            <input id="searchInput" class="p-2 rounded-lg border border-gray-300 w-1/2" placeholder="Cari Judul..." type="text" />
            <a href="input_awal.php">
                <button class="bg-green-700 text-white px-4 py-2 rounded flex items-center">
                    <i class="fas fa-plus mr-2"></i> Ajukan Permohonan
                </button>
            </a>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex justify-between items-start">
            <table class="border-separate border-spacing-y-2 w-full" id="permohonanTable">
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
                <tbody id="tableBody">
                    <tr><td colspan="7">Loading data...</td></tr>
                </tbody>
            </table>
        </div>

        <br />
        <div>
            <a href="menu_input.php">
                <button type="button" class="bg-teal-700 text-white px-4 py-2 rounded">SEBELUMNYA</button>
            </a>
        </div>
    </div>

    <script>
        async function fetchData() {
            try {
                const response = await fetch('data.php');
                const data = await response.json();

                const tbody = document.getElementById('tableBody');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7">Tidak ada data</td></tr>';
                    return;
                }

                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.classList.add('bg-white');

                    tr.innerHTML = `
                        <td>${row.judul}</td>
                        <td><a href="uploads/${row.file_ktp}" class="button" target="_blank" rel="noopener noreferrer">Unduh</a></td>
                        <td><a href="uploads/${row.file_contoh_karya}" class="button" target="_blank" rel="noopener noreferrer">Unduh</a></td>
                        <td><a href="uploads/${row.file_sp}" class="button" target="_blank" rel="noopener noreferrer">Unduh</a></td>
                        <td><a href="uploads/${row.file_sph}" class="button" target="_blank" rel="noopener noreferrer">Unduh</a></td>
                        <td>-</td>
                        <td>-</td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (error) {
                console.error('Error fetching data:', error);
                const tbody = document.getElementById('tableBody');
                tbody.innerHTML = '<tr><td colspan="7">Gagal memuat data</td></tr>';
            }
        }

        fetchData();

        // Filter pencarian
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const judul = row.querySelector('td')?.textContent.toLowerCase() || '';
                row.style.display = judul.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
