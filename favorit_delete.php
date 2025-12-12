<?php
include "db.php";
$id_user = intval($_POST['id_user'] ?? 1);
$id_wisata = intval($_POST['id_wisata'] ?? 0);
$res = mysqli_query($conn, "DELETE FROM favorit WHERE id_user=$id_user AND id_wisata=$id_wisata");
echo json_encode(["success" => (bool)$res, "error" => mysqli_error($conn)]);
?>
