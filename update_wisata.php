<?php
include "db.php";

$id = intval($_POST['id'] ?? 0);
$nama = mysqli_real_escape_string($conn, $_POST['nama'] ?? '');
$lokasi = mysqli_real_escape_string($conn, $_POST['lokasi'] ?? '');
$deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi'] ?? '');
$id_kategori = intval($_POST['id_kategori'] ?? 0);

$curImg = '';
$q = mysqli_query($conn, "SELECT gambar FROM wisata WHERE id_wisata=$id LIMIT 1");
if($r=mysqli_fetch_assoc($q)) $curImg = $r['gambar'];

$uploadName = $curImg;
if(isset($_FILES['gambar']) && $_FILES['gambar']['error']===0){
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $uploadName = uniqid() . "." . $ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__ . "/../img/" . $uploadName);
    // optionally unlink old file:
    if($curImg && file_exists(__DIR__ . "/../img/" . $curImg)) {
        @unlink(__DIR__ . "/../img/" . $curImg);
    }
}

$sql = "UPDATE wisata SET id_kategori=$id_kategori, nama_wisata='$nama', lokasi='$lokasi', deskripsi='$deskripsi', gambar='$uploadName' WHERE id_wisata=$id";
$res = mysqli_query($conn, $sql);
echo json_encode(["success" => (bool)$res, "error" => mysqli_error($conn)]);
?>
