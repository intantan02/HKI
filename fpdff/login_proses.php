<?php
session_start(); // Start session dulu di paling atas

$servername = "localhost";
$user = "root";
$pass = "";
$dbname = "hki";

// Buat koneksi ke database
$conn = new mysqli($servername, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['email'];
    $password = $_POST['password'];

    // Enkripsi password sebelum disimpan (opsional tapi disarankan)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO login_user (Username, Password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            // Reset session data_id biar input baru dimulai fresh
            unset($_SESSION['data_id']);
            
            // Redirect ke halaman input
            header("Location: menu_input.php");
            exit;
        } else {
            echo "Gagal menyimpan data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Query error: " . $conn->error;
    }
}

$conn->close();
?>
