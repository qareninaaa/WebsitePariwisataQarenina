<?php
include "../db.php";

$username = $_POST['username'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// cek username / email sudah ada
$check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");
if (mysqli_num_rows($check) > 0) {
    header("Location: register.php?error=Akun sudah terdaftar!");
    exit;
}

$q = mysqli_query($conn, "INSERT INTO users(username,email,password,role,tanggal_daftar)
                          VALUES('$username','$email','$password','user',NOW())");

if ($q) {
    header("Location: login.php");
} else {
    header("Location: register.php?error=Gagal mendaftar!");
}
