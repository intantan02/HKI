<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Data Pribadi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg p-8 flex items-center justify-center min-h-screen">
    <div class="bg-gray-100 w-full max-w-5xl p-8 rounded-lg shadow-lg">
        <div class="bg-gray-100 p-5 rounded-lg">
            <h1 class="text-2xl font-bold mb-6">INFORMASI DATA PRIBADI MAHASISWA</h1>
            <div class="mb-4">
                <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                    <div>
                        <p class="font-semibold">Nama</p> <br>
                        <span class="text-xs bg-blue-500 text-white px-2 py-1 rounded">Mahasiswa</span>
                    </div>
                    <div class="flex space-x-2">
                    <button class="text-gray-500 hover:text-gray-700"><i class="fas fa-edit"></i></button>
                        <button class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                    <div>
                        <p class="font-semibold">Alamat</p>
                        <br>
                    </div>
                    <div class="flex space-x-2">
                    <button class="text-gray-500 hover:text-gray-700"><i class="fas fa-edit"></i></button>
                        <button class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                    <div>
                        <p class="font-semibold">Nomor Telpon</p>
                        <br>
                    </div>
                    <div class="flex space-x-2">
                    <button class="text-gray-500 hover:text-gray-700"><i class="fas fa-edit"></i></button>
                        <button class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                    <div>
                        <p class="font-semibold">Program Studi</p>
                        <br>
                    </div>
                    <div class="flex space-x-2">
                    <button class="text-gray-500 hover:text-gray-700"><i class="fas fa-edit"></i></button>
                        <button class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                    <div>
                        <label class="font-semibold">Jenis Permohonan </label>
                        <select class="w-full mt-1 p-2 border rounded">
                        <option>Fakultas Teknik Industri</option>
                        <option>Fakultas Ilmu dan Sosial</option>
                        <option>Fakultas Teknik Mineral</option>
                        <option>Fakultas Ekonomi dan Bisnis</option>
                    </select>
                    </div>
                    <div class="flex space-x-2">
                        <button class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
                    <div>
                        <p class="font-semibold">Alamat Email</p>
                        <br>
                    </div>
                    <div class="flex space-x-2">
                    <button class="text-gray-500 hover:text-gray-700"><i class="fas fa-edit"></i></button>
                        <button class="text-red-500"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div><br>
            <div class="flex justify-center"> 
                <button class="bg-blue-500 text-white px-6 py-2 rounded-lg">SUBMIT</button>
            </div>
        </div>
    </div>
</body>
</html>