<?php
include "connector.php";
session_start();

$username = $_POST['username'];
$password = $_POST['password'];


//$query = "SELECT id, password FROM users WHERE username = '$username'";
$query = "SELECT id, password, role FROM users WHERE username = '$username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashedPasswordFromDatabase = $row['password'];
    $role = $row['role'];

    if ($password == $hashedPasswordFromDatabase) {
        $_SESSION['user_id'] = $row['id'];
        if ($role == 'user'){
            //halaman user
            header("Location: menu_input.php");
        } else {
            //halaman
            header("Location: review_ad.php");
        }
    } else {
        header("Location: login_user.php?m=wrong");
    }
} else {
    header("Location: login_user.php?m=nfound");
}

$conn->close();
?>
?>