<?php
include "db.php";
$id = intval($_POST['id'] ?? 0);
$q = mysqli_query($conn, "SELECT gambar FROM wisata WHERE id_wisata=$id LIMIT 1");
if($r=mysqli_fetch_assoc($q)){
    $g = $r['gambar'];
    if($g && file_exists(__DIR__ . "/../img/" . $g)) @unlink(__DIR__ . "/../img/" . $g);
}
$res = mysqli_query($conn, "DELETE FROM wisata WHERE id_wisata=$id");
echo json_encode(["success" => (bool)$res, "error" => mysqli_error($conn)]);
?>
