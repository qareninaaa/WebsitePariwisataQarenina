<?php
include "db.php";
$id_user = intval($_POST['id_user'] ?? 1);
$id_wisata = intval($_POST['id_wisata'] ?? 0);

$res = mysqli_query($conn, "INSERT IGNORE INTO favorit (id_user, id_wisata) VALUES ($id_user, $id_wisata)");
echo json_encode(["success" => (bool)$res, "error" => mysqli_error($conn)]);
?>
