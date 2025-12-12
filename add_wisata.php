<?php
include "db.php";

$nama = mysqli_real_escape_string($conn, $_POST['nama'] ?? '');
$lokasi = mysqli_real_escape_string($conn, $_POST['lokasi'] ?? '');
$deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi'] ?? '');
$id_kategori = intval($_POST['id_kategori'] ?? 0);

$uploadName = null;
if(isset($_FILES['gambar']) && $_FILES['gambar']['error']===0){
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $uploadName = uniqid() . "." . $ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__ . "/../img/" . $uploadName);
}

$sql = "INSERT INTO wisata (id_kategori, nama_wisata, lokasi, deskripsi, gambar) VALUES ($id_kategori, '$nama', '$lokasi', '$deskripsi', '". ($uploadName ?? '') ."')";
$res = mysqli_query($conn, $sql);
echo json_encode(["success" => (bool)$res, "error" => mysqli_error($conn)]);
?>
