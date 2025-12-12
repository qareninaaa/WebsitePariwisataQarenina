<?php
include "db.php";
$q = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori ASC");
$data = [];
while($r=mysqli_fetch_assoc($q)) $data[]=$r;
echo json_encode($data);
?>
