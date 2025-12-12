<?php
include "db.php";
$sql = "SELECT w.id_wisata AS id, w.nama_wisata AS title, w.deskripsi AS `desc`, w.gambar AS img, k.nama_kategori AS kategori
        FROM wisata w
        LEFT JOIN kategori k ON w.id_kategori = k.id_kategori
        ORDER BY w.id_wisata ASC";
$res = mysqli_query($conn, $sql);
$data = [];
while($r = mysqli_fetch_assoc($res)){
    $r['img'] = "../img/" . $r['img'];
    $data[] = $r;
}
echo json_encode($data);
?>
