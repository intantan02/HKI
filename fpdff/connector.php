<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hki";

try {
    // Membuat koneksi menggunakan objek mysqli
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Mengatur karakter encoding ke UTF-8
    $conn->set_charset("utf8");

    // Cek koneksi
    if ($conn->connect_error) {
        throw new Exception("Koneksi gagal: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

