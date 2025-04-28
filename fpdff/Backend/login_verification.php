<?php
session_start();
include '../koneksi.php'; // perbaikan include

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query cek user
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['user_id'] = $result->fetch_assoc()['id'];
        header("Location: ../Frontend/menu_input.php"); // arahkan ke dashboard / halaman utama
    } else {
        header("Location: ../Frontend/login.php?m=wrong"); // kalau gagal login
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../Frontend/login.php");
}
?>
