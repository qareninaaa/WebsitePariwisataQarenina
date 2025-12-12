<?php
include "../api/db.php";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id = intval($_POST['id']);
    $q = mysqli_query($conn, "SELECT gambar FROM wisata WHERE id_wisata=$id LIMIT 1");
    if($r=mysqli_fetch_assoc($q)){
        if($r['gambar'] && file_exists(__DIR__ . "/../img/" . $r['gambar'])) @unlink(__DIR__ . "/../img/" . $r['gambar']);
    }
    mysqli_query($conn, "DELETE FROM wisata WHERE id_wisata=$id");
}
header("Location: index.php");
exit;
?>
