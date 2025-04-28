<?php
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "Akses tidak diizinkan. Silakan login terlebih dahulu.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "hki";

$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan dataid ada di session
if (!isset($_SESSION['dataid'])) {
    $_SESSION['dataid'] = uniqid('data_', true);
}

$dataid = $_SESSION['dataid'];

// Jika form di-submit, proses upload data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Siapkan query SQL untuk menyimpan data ke database
    $sql = "INSERT INTO tabel_upload (dataid, file_sp, file_sph, file_contoh_karya, file_ktp, file_bukti_pembayaran) VALUES (?, ?, ?, ?, ?, ?)";

    // Persiapkan statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Query prepare failed: ' . $conn->error);
    }

    // Bind parameter
    $stmt->bind_param("ssssss", $dataid, $_FILES['file_sp']['name'], $_FILES['file_sph']['name'], $_FILES['file_contoh_karya']['name'], $_FILES['file_ktp']['name'], $_FILES['file_bukti_pembayaran']['name']);

    // Cek apakah query berhasil dijalankan
    if ($stmt->execute()) {
        // Reset dataid setelah berhasil submit
        unset($_SESSION['dataid']);
        
        // Tampilkan pesan sukses dan arahkan user kembali ke halaman daftar_user
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data berhasil diupload.',
                icon: 'success'
            }).then(() => {
                document.querySelector('form').reset(); // Reset form
                window.location.href = 'daftar_user.php'; // Redirect ke daftar_user.php
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat mengupload data.',
                icon: 'error'
            });
        </script>";
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Halaman Upload</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const requiredFields = [
                'file_sp',
                'file_sph',
                'file_contoh_karya',
                'file_ktp',
                'file_bukti_pembayaran'
            ];
            function validateUpload() {
                const allFilled = requiredFields.every(fieldName => {
                    const input = document.querySelector(`input[name="${fieldName}"]`);
                    return input && input.files.length > 0;
                });
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = !allFilled;
            }
            validateUpload();
            requiredFields.forEach(name => {
                const input = document.querySelector(`input[name="${name}"]`);
                if (input) {
                    input.addEventListener('change', validateUpload);
                }
            });
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const msg = urlParams.get('msg');
            if (status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Upload dan penyimpanan data berhasil!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    const form = document.querySelector('form');
                    form.reset();
                    window.location.href = 'daftar_user.php';
                });
            } else if (status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: msg || 'Terjadi kesalahan saat mengupload!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'upload.php';
                });
            }
        });
    </script>
</head>
<body class="bg flex p-8 items-center justify-center min-h-screen">
    <br><br>
    <div class="bg-gray-100 w-full max-w-5xl p-8 rounded-lg shadow-lg">
        <div>
            <h1 class="text-2xl font-bold mb-6">UPLOAD</h1>
            <form action="upload_proses.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="dataid" value="<?= $dataid ?>">
                <div class="">
                    <div class="bg-green-700 text-white p-4 rounded-t-lg">
                        <h2 class="font-semibold">Upload</h2>
                    </div>
                    <div class="bg-white p-6 rounded-b-lg shadow-md mb-6">
                        <div class="border rounded-lg p-4 flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <img alt="Icon for SP" class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/PRA3B5AVClacEZRlaZoRnSSirzeRibWTsik337KzqAF2RGEKA.jpg" width="50"/>
                                <div>
                                    <h2 class="text-xl font-bold">Surat Pernyataan</h2>
                                    <p>SP berisi Surat Pernyataan yang berisi judul buku dan tanda tangan</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>12/10/2022</p>
                                <button class="bg-green-900 text-white px-3 py-2 rounded-lg mt-1">
                                    <input type="file" name="file_sp" class="mt-1" onchange="validateUpload()"/>
                                </button>
                            </div>
                        </div>
                        <br>
                        <div class="border rounded-lg p-4 flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <img alt="Icon for SPH" class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/bMfneMYe8MHZtIfMlYbQ82wFMsB19g8tI28eDUbZnxqBdkBhC.jpg" width="50"/>
                                <div>
                                    <h2 class="text-xl font-bold">Surat Pengalihan Hak Cipta</h2>
                                    <p>SPH berisi surat pengalihan hak yang berisi seluruh pengusul dan tanda tangan sesuai format yang ada</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>12/10/2022</p>
                                <button class="bg-green-900 text-white px-3 py-2 rounded-lg mt-2">
                                    <input type="file" name="file_sph" class="mt-1" onchange="validateUpload()"/>
                                </button>
                            </div>
                        </div>
                        <br>
                        <div class="border rounded-lg p-4 flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <img alt="Icon for Contoh Karya Dan Uraian" class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/03KfS3Dk2l1IQ6yOijmMil5HggtVNuAWKUdySExuWjG1RGEKA.jpg" width="50"/>
                                <div>
                                    <h2 class="text-xl font-bold">Contoh Karya Dan uraian</h2>
                                    <p>Berisi Contoh Karya dan Uraian</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>12/10/2022</p>
                                <button class="bg-green-900 text-white px-3 py-2 rounded-lg mt-2">
                                    <input type="file" name="file_contoh_karya" class="mt-1" onchange="validateUpload()"/>
                                </button>
                            </div>
                        </div>
                        <br>
                        <div class="border rounded-lg p-4 flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <img alt="Icon for Scan KTP" class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/d1IlFNDW0YbsNZbmBPI1lFF6EO3KFMEYtHDch7ztVQz5IDCF.jpg" width="50"/>
                                <div>
                                    <h2 class="text-xl font-bold">Scan KTP</h2>
                                    <p>Berisi Scan KTP bentuk PDF</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>12/10/2022</p>
                                <button class="bg-green-900 text-white px-3 py-2 rounded-lg mt-2">
                                    <input type="file" name="file_ktp" class="mt-1" onchange="validateUpload()"/>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="">
                    <div>
                        <div class="bg-green-700 text-white p-4 rounded-t-lg">
                            <h2 class="font-semibold">Lampiran</h2>
                        </div>
                        <div class="bg-white p-6 rounded-b-lg shadow-md mb-6">
                            <div class="flex items-center space-x-4">
                                <label class="w-1/3">Contoh Ciptaan (Link)</label>
                                <input class="w-full p-2 border rounded-lg" type="text" name="contoh_ciptaan_link"/>
                            </div>
                            <br>
                            <div class="flex items-center space-x-4">
                                <label class="w-1/3">Salinan Resmi Akta Pendirian Badan Hukum</label>
                                <input class="w-full p-2 border rounded-lg" type="file" name="file_akta_pendirian" onchange="validateUpload()"/>
                            </div>
                            <br>
                            <div class="flex items-center space-x-4">
                                <label class="w-1/3">Scan NPWP Perorangan/ Perusahaan</label>
                                <input class="w-full p-2 border rounded-lg" type="file" name="file_npwp" onchange="validateUpload()"/>
                            </div>
                            <br>
                            <div class="flex items-center space-x-4">
                                <label class="w-1/3">Bukti Pembayaran</label>
                                <input class="w-full p-2 border rounded-lg" type="file" name="file_bukti_pembayaran" class="mt-1" onchange="validateUpload()"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-6">
                    <button class="bg-teal-700 text-white px-4 py-2 rounded">
                        <a href="preview.php">SEBELUMNYA</a>
                    </button>
                    <button id="submitBtn" class="bg-teal-700 text-white px-4 py-2 rounded" type="submit" disabled>
                        SUBMIT
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
