<?php
include "db.php";
$id_user = intval($_GET['id_user'] ?? 1);
$sql = "SELECT w.id_wisata AS id, w.nama_wisata AS title, w.deskripsi AS `desc`, w.gambar AS img
        FROM favorit f JOIN wisata w ON f.id_wisata = w.id_wisata
        WHERE f.id_user = $id_user ORDER BY f.tanggal_disimpan DESC";
$res = mysqli_query($conn, $sql);
$data = [];
while($r=mysqli_fetch_assoc($res)){
    $r['img'] = "../img/" . $r['img'];
    $data[] = $r;
}
echo json_encode($data);
?>
