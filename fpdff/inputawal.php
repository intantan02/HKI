<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Akses tidak diizinkan. Silakan login terlebih dahulu.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Inisialisasi dataid jika belum ada
if (!isset($_SESSION['dataid'])) {
    $_SESSION['dataid'] = uniqid();
}
$dataid = $_SESSION['dataid'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "hki";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data pencipta berdasarkan ID tertentu
$id_pencipta = 1;

$sql_pencipta = "SELECT * FROM pencipta WHERE id = ?";
$stmt = $conn->prepare($sql_pencipta);
$stmt->bind_param("i", $id_pencipta);
$stmt->execute();
$result_pencipta = $stmt->get_result();

$data_pencipta = [];
if ($result_pencipta) {
    while ($row = $result_pencipta->fetch_assoc()) {
        $data_pencipta[] = $row;
    }
} else {
    echo "<script>alert('Gagal mengambil data pencipta berdasarkan ID');</script>";
}

echo "ID Pencipta: " . $id_pencipta . "<br>";
echo "Jumlah data pencipta: " . count($data_pencipta) . "<br>";

$stmt->close();
$conn->close();
?>




<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet"/>
</head>

<body class="bg p-9 flex justify-center items-center min-h-screen ">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<br>
<br>
    <div class="bg-gray-100 w-full max-w-7xl p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6">INPUT SURAT PERMOHONAN HAK CIPTA</h1>

        <form action="proses_inputawal.php" method="post">
                <div class="bg-green-700 text-white p-4 rounded-t-lg">
            <h2 class="font-semibold">Detail Permohonan</h2>
        </div>
        
        <div class="bg-white p-6 rounded-b-lg shadow-md mb-6">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <label for="jenis_permohonan">Jenis Permohonan <span class="text-red-500">*</span></label>
                    </div>
                    <div class="col-8">    
                    <select name="jenis_permohonan" class="w-full mt-1 p-2 border rounded">
                        <option value="">Pilih Jenis Permohonan</option>
                        <option value="UMK">UMK, Lembaga Pendidikan, Lembaga Litbang Pemerintah</option>
                        <option value="Umum">Umum</option>
                    </select>
                    </div>        
                </div>
                <div class="row">
                    <div class= "col-4">
                        <label class="block text-gray-700">Jenis Ciptaan <span class="text-red-500">*</span></label>
                    </div>
                    
                    <div class= "col-8">
                        <select name = "jenis_ciptaan" id="jenis_ciptaan" class="w-full mt-1 p-2 border rounded col-8">
                        <option  value="">Pilih Jenis Ciptaan</option>
                            <option value="Karya Tulis">Karya Tulis</option>
                            <option value="Karya Seni">Karya Seni</option>
                            <option value="Komposisi Musik">Komposisi Musik</option>
                            <option value="Karya Audio Visual">Karya Audio Visual</option>
                            <option value = "Karya Fotografi">Karya Fotografi</option>
                            <option value = "Karya Drama & Koreografi">Karya Drama & Koreografi</option>
                            <option value = "Karya Rekaman">Karya Rekaman</option>
                            <option value = "Karya Lainnya">Karya Lainnya</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <div class="row">
                        <div class= "col-4">
                            <label class="block text-gray-700">Sub-Jenis Ciptaan</label>
                        </div>
                        <div class= "col-8">
                            <select name = "sub_jenis_ciptaan" id="sub_jenis_ciptaan" class="w-full mt-1 p-2 border rounded">
                            <option value="">Pilih Sub-Jenis Ciptaan</option>
                            </select>
                        </div>
                    </div>
                    <script>
                        const subjenisOptions = {
                            "Karya Tulis": [
                                "Atlasbiografi",
                                "Booklet",
                                "Buku",
                                "Buku mewarnai",
                                "Buku panduan/petunjuk",
                                "Buku pelajaran",
                                "Buku saku",
                                "Bunga rampai",
                                "Cerita bergambar",
                                "Diktat",
                                "Dongeng",
                                "E-book",
                                "Ensiklopedia",
                                "Jurnal",
                                "Kamus",
                                "Karya ilmiah",
                                "Karya tulis",
                                "Karya tulis (artikel)",
                                "Karya tulis (disertasi)",
                                "Karya tulis (skripsi)",
                                "Karya tulis (tesis)",
                                "Karya tulis lainnya",
                                "Komik",
                                "Laporan penelitian",
                                "Majalah",
                                "Makalah",
                                "Modul",
                                "Naskah drama/pertunjukan"
                            ],
                            "Karya Seni": [
                                "Alat Peraga",
                                "Arsitektur",
                                "Baliho",
                                "Banner",
                                "Brosur",
                                "Diorama",
                                "Flayer",
                                "Kaligrafi",
                                "Karya seni batik",
                                "Karya seni rupa",
                                "Kolase",
                                "Leaflet",
                                "Motif sasirangan",
                                "Motif tapis",
                                "Motif Tenun Ikat",
                                "Motif Ulos",
                                "Pamflet",
                                "Peta",
                                "Poster",
                                "Seni Gambar",
                                "Seni Ilustrasi",
                                "Seni Lukis",
                                "Seni Motif",
                                "Seni Motif Lainnya",
                                "Seni Pahat",
                                "Seni Patung",
                                "Seni Rupa",
                                "Seni Songket",
                                "Seni Terapan",
                                "Seni Umum",
                                "Sketsa",
                                "Spanduk",
                                "Ukiran"
                            ],
                            "Komposisi Musik": [
                                "Aransemen",
                                "Lagu (Musik Dengan Teks)",
                                "Musik",
                                "Musik Blues",
                                "Musik Country",
                                "Musik Dangdut",
                                "Musik Elektronik",
                                "Musik Funk",
                                "Musik Gospel",
                                "Musik Hip Hop, Rap, Rapcore",
                                "Musik Jazz",
                                "Musik Karawitan"
                            ],
                            "Karya Audio Visual": [
                                "Film",
                                "Film Cerita",
                                "Film Dokumenter",
                                "Film Iklan",
                                "Film Kartun",
                                "Karya Rekaman Video",
                                "Karya Siaran",
                                "Karya Siaran Media Televisi dan Film",
                                "Karya Siaran Video",
                                "Karya Siaran Media Radio",
                                "Karya Sinematografi",
                                "Kuliah",
                                "Reportase"
                            ],
                            "Karya Fotografi": [
                                "Karya Fotografi",
                                "Potret"
                            ],
                            "Karya Drama & Koreografi": [
                                "Drama / Pertunjukan",
                                "Drama Musikal",
                                "Ketoprak",
                                "Komedi/Lawak",
                                "Koreografi",
                                "Lenong",
                                "Ludruk",
                                "Opera",
                                "Pantomim",
                                "Pentas Musik",
                                "Pewayangan",
                                "Seni Akrobat",
                                "Seni Pertunjukan",
                                "Sirkus",
                                "Sulap",
                                "Tari (Sendra Tari)"
                            ],
                            "Karya Rekaman": [
                                "Ceramah",
                                "Karya Rekaman Suara atau Bunyi",
                                "Khutbah",
                                "Pidato"
                            ],
                            "Karya Lainnya": [
                                "Basis Data",
                                "Kompilasi Ciptaan / Data",
                                "Permainan Video",
                                "Program Komputer"
                            ]
                        };

                        document.addEventListener("DOMContentLoaded", function() {
                            const jenisCiptaanDropdown = document.getElementById('jenis_ciptaan');
                            const subJenisDropdown = document.getElementById('sub_jenis_ciptaan');
                            
                            if (jenisCiptaanDropdown && subJenisDropdown) {
                                jenisCiptaanDropdown.addEventListener('change', function() {
                                    const jenisCiptaan = this.value;
                                    subJenisDropdown.innerHTML = '<option value="">Pilih Sub-Jenis Ciptaan</option>';
                                    
                                    if (subjenisOptions[jenisCiptaan]) {
                                        subjenisOptions[jenisCiptaan].forEach(subjenis => {
                                            const option = document.createElement('option');
                                            option.value = subjenis;
                                            option.textContent = subjenis;
                                            subJenisDropdown.appendChild(option);
                                        });
                                    }
                                });
                            } else {
                                console.error("Pastikan elemen dengan ID 'jenis_ciptaan' dan 'sub_jenis_ciptaan' ada di dalam HTML.");
                            }
                        });

                    </script>
                </div>
                
                <div>
                    <div class="row">
                        <div class= "col-4">
                            <label class="block text-gray-700">Judul <span class="text-red-500">*</span></label>
                        </div>
                            <div class= "col-8">
                                <input type="text" name="judul" class="w-full mt-1 p-2 border rounded" placeholder="Masukkan judul">
                            </div>
                        </div>
                    <div>
                        <div class="row">
                            <div class= "col-4">
                                <label class="block text-gray-700">Uraian Singkat Ciptaan <span class="text-red-500">*</span></label>
                            </div>
                            <div class= "col-8">
                                <input type="text"  name="uraian_singkat" class="w-full mt-1 p-2 border rounded" placeholder="Masukkan uraian singkat ciptaan">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="row">
                            <div class= "col-4">
                                <label class="block text-gray-700">Tanggal Pertama Kali Diumumkan <span class="text-red-500">*</span></label>
                            </div>
                            <div class= "col-8">
                                <input type="date"  name="tanggal_pertama_kali_diumumkan" class="w-full mt-1 p-2 border rounded">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="row">
                            <div class= "col-4">
                                <label class="block text-gray-700">Negara Pertama Kali Diumumkan</label>
                            </div>
                            <div class= "col-8">
                                <input type="text" name="negara_pertama_kali_diumumkan"  class="w-full mt-1 p-2 border rounded" placeholder="Masukkan negara">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="row">
                        <div class= "col-4">
                            <label class="block text-gray-700">Kota Pertama Kali Diumumkan <span class="text-red-500">*</span></label>
                        </div>
                        <div class= "col-8">
                            <input type="text"  name="kota_pertama_kali_diumumkan" class="w-full mt-1 p-2 border rounded" placeholder="Masukkan Kota">
                        </div>
                    </div>
                    <div>
                        
                        
                        <div class="row">
                            <div class= "col-4">
                                <label for="jenisHibah" class="block text-gray-700">Jenis Pendanaan<span class="text-red-500">*</span></label>
                            </div>
                            <div class= "col-8">
                                <select id="jenisHibah" name = "jenis_hibah" class="w-full mt-1 p-2 border rounded" onchange="showHibahOptions()">
                                    <option value="">Pilih Jenis Pendanaan</option>
                                    <option value="internal">Internal</option>
                                    <option value="eksternal">Eksternal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class= "col-4">
                            <label for="hibah" class="block text-gray-700" id="hibahLabel">Nama Pendanaan<span class="text-red-500">*</span></label>
                        </div>
                        <div class= "col-8">
                            <select id="hibah" name = "jenis_pendanaan"class="w-full mt-1 p-2 border rounded" >
                                <option value="">Pilih Hibah</option>
                            </select>
                        </div>
                        </div>
    </div>
    <script>
    function showHibahOptions() {
    const jenisHibah = document.getElementById("jenisHibah").value;
    const hibahSelect = document.getElementById("hibah");
    const hibahLabel = document.getElementById("hibahLabel");
    const pendanaanLabel = document.getElementById("pendanaanLabel");
    const pendanaanValue = document.getElementById("pendanaanValue");
    const pendanaanHidden = document.getElementById("pendanaanHidden");

    // Clear previous options
    hibahSelect.innerHTML = '<option value="">Pilih Hibah</option>';
    hibahLabel.classList.add("hidden");
    hibahSelect.classList.add("hidden");
    pendanaanLabel.classList.add("hidden");
    pendanaanValue.classList.add("hidden");
    pendanaanHidden.value = "";

    if (jenisHibah === "internal") {
        hibahLabel.classList.remove("hidden");
        hibahSelect.classList.remove("hidden");
        hibahSelect.innerHTML += `
            <option value="hibah penelitian dosen pemula" data-funding="Rp50.000.000">Hibah Penelitian Dosen Pemula</option>
            <option value="hibah penelitian dasar" data-funding="Rp100.000.000">Hibah Penelitian Dasar</option>
            <option value="hibah penelitian terapan" data-funding="Rp150.000.000">Hibah Penelitian Terapan</option>
            <option value="hibah penelitian pengembangan" data-funding="Rp200.000.000">Hibah Penelitian Pengembangan</option>
            <option value="hibah penelitian kelembagaan" data-funding="Rp250.000.000">Hibah Penelitian Kelembagaan</option>
        `;
    } else if (jenisHibah === "eksternal") {
        hibahLabel.classList.remove("hidden");
        hibahSelect.classList.remove("hidden");
        hibahSelect.innerHTML += `
            <option value="hibah drtpm" data-funding="Rp300.000.000">Hibah DRTPM</option>
            <option value="riim" data-funding="Rp400.000.000">RIIM</option>
            <option value="kedaireka" data-funding="Rp500.000.000">Kedaireka</option>
            <option value="riset inovatif produktif" data-funding="Rp600.000.000">Riset Inovatif Produktif (RISPRO)</option>
            <option value="grant riset sawit bpdpks" data-funding="Rp700.000.000">Grant Riset Sawit BPDPKS</option>
            <option value="lainnya" data-funding="-">Lainnya</option>
        `;
    }
    hibahSelect.onchange = showPendanaan;
}

function showPendanaan() {
    const selectedOption = document.getElementById("hibah").selectedOptions[0];
    const pendanaanLabel = document.getElementById("pendanaanLabel");
    const pendanaanValue = document.getElementById("pendanaanValue");
    const pendanaanHidden = document.getElementById("pendanaanHidden");

    if (selectedOption.value) {
        const fundingAmount = selectedOption.getAttribute("data-funding");
        pendanaanLabel.classList.remove("hidden");
        pendanaanValue.classList.remove("hidden");
        pendanaanValue.textContent = fundingAmount;
        pendanaanHidden.value = fundingAmount; // Simpan ke input hidden untuk dikirim ke backend
    } else {
        pendanaanLabel.classList.add("hidden");
        pendanaanValue.classList.add("hidden");
        pendanaanValue.textContent = "";
        pendanaanHidden.value = "";
    }
}

</script>
<input type="hidden" id="pendanaanHidden" name="pendanaanHidden">

<div class="row">
    <div class="col-4">
        <label for="hibah" class="block text-gray-700 hidden" id="hibahLabel">Nama Pendanaan<span class="text-red-500">*</span></label>
    </div>
    <div class="col-8">
        <select id="hibah" name="jenis_pendanaan" class="w-full mt-1 p-2 border rounded hidden">
            <option value="">Pilih Hibah</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <label id="pendanaanLabel" class="block text-gray-700 hidden">Pendanaan:</label>
    </div>
    <div class="col-8">
        <span id="pendanaanValue" class="text-blue-600 font-bold hidden"></span>
    </div>
</div>

            </div>
        </div>

        <div class="bg-green-700 text-white p-4 rounded-t-lg">
            <h2 class="font-semibold">Data Kuasa</h2>
        </div>
        <div class="bg-white p-6 rounded-b-lg shadow-md mb-6">
            <label class="block text-gray-700 mb-2">Melalui Kuasa</label>
            <div class="flex items-center">
                <input type="radio" name="kuasa" class="mr-2"> Yes
                <input type="radio" name="kuasa" class="ml-4 mr-2" checked> No
            </div>
        </div>

        <div class="bg-green-700 text-white p-4 rounded-t-lg">
            <h2 class="font-semibold">Data Pemegang Hak Cipta</h2>
        </div>
        <div class="bg-white p-6 rounded-b-lg shadow-md mb-6">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">No. Telp</th>
                        <th class="border p-2">Kewarganegaraan</th>
                        <th class="border p-2">Alamat</th>
                        <th class="border p-2">Negara</th>
                        <th class="border p-2">Provinsi</th>
                        <th class="border p-2">Kota</th>
                        <th class="border p-2">Kecamatan</th>
                        <th class="border p-2">Kode Pos</th>
                        <th class="border p-2">Pemegang Hakcipta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($data_pencipta)) {
                        $number = 0;
                        foreach ($data_pencipta as $row) {
                            echo '<tr class="border">';
                            echo '<td class="border p-2 text-center">' . ++$number . '</td>';
                            echo '<td class="border p-2">' . htmlspecialchars($row["nama"]) . '</td>';
                            echo '<td class="border p-2">' . htmlspecialchars($row["email"]) . '</td>';
                            echo '<td class="border p-2 text-center">' . htmlspecialchars($row["no_telp"]) . '</td>';
                            echo '<td class="border p-2 text-center">' . htmlspecialchars($row["kewarganegaraan"]) . '</td>';
                            echo '<td class="border p-2">' . htmlspecialchars($row["alamat"]) . '</td>';
                            echo '<td class="border p-2 text-center">' . htmlspecialchars($row["negara"]) . '</td>';
                            echo '<td class="border p-2 text-center">' . htmlspecialchars($row["provinsi"]) . '</td>';
                            echo '<td class="border p-2 text-center">' . htmlspecialchars($row["kabupaten_kota"]) . '</td>';
                            echo '<td class="border p-2 text-center">' . htmlspecialchars($row["kecamatan"]) . '</td>';
                            echo '<td class="border p-2 text-center">' . htmlspecialchars($row["kode_pos"]) . '</td>';
                            echo '<td class="border p-2 text-center">' . htmlspecialchars($row["pemegang_hakcipta"]) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="12" class="border p-4 text-center">Tidak ada data pengusul.</td></tr>';
                    }
                    ?>
                </tbody>

            </table>
            
        </div>
<br>
                 <div class="flex justify-between mt-4">
                    <a href="daftar_user.php"><button type="button" id="tambahPenciptaBtnSebelumnya" class="bg-green-800 text-white px-4 py-2 rounded">SEBELUMNYA</button></a>
                    <button type="submit" id="tambahPenciptaBtnSelanjutnya" class="bg-green-800 text-white px-4 py-2 rounded">SELANJUTNYA</button>
                </div>
        </form>
    </div>
</body>
</html>