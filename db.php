<?php
header("Content-Type: application/json; charset=utf-8");
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pariwisata1";

$conn = mysqli_connect($host, $user, $pass, $db);
if(!$conn){
    echo json_encode(["error"=>"DB_CONNECT_ERROR"]);
    exit;
}
mysqli_set_charset($conn, "utf8mb4");
?>
