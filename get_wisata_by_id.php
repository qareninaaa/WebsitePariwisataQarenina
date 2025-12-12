<?php
include "db.php";
$id = intval($_GET['id'] ?? 0);
$sql = "SELECT w.*, k.nama_kategori FROM wisata w LEFT JOIN kategori k ON w.id_kategori=k.id_kategori WHERE w.id_wisata=$id LIMIT 1";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
if($row){
    $row['img'] = "../img/" . $row['gambar'];
    echo json_encode($row);
} else {
    echo json_encode(null);
}
?>
