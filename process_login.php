<?php
session_start();
include "../db.php";

$username = $_POST['username'];
$password = $_POST['password'];

// cek user
$q = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    header("Location: login.php?error=Username tidak ditemukan");
    exit;
}

if (password_verify($password, $data['password'])) {
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    header("Location: ../home.php");
} else {
    header("Location: login.php?error=Password salah");
}
