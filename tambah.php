<?php
include "../api/db.php";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $id_kategori = intval($_POST['id_kategori']);
    $gambar = '';
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error']===0){
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar = uniqid().'.'.$ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__ . "/../img/" . $gambar);
    }
    mysqli_query($conn, "INSERT INTO wisata (id_kategori,nama_wisata,lokasi,deskripsi,gambar) VALUES ($id_kategori,'$nama','$lokasi','$deskripsi','$gambar')");
    header("Location: index.php");
    exit;
}
$cats = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori ASC");
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Tambah Wisata</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="container">
  <h2>Tambah Wisata</h2>
  <form method="post" enctype="multipart/form-data">
    <p><label>Nama<br><input name="nama" required></label></p>
    <p><label>Lokasi<br><input name="lokasi" required></label></p>
    <p><label>Kategori<br>
      <select name="id_kategori" required>
        <?php while($c=mysqli_fetch_assoc($cats)): ?>
          <option value="<?= $c['id_kategori'] ?>"><?= htmlspecialchars($c['nama_kategori']) ?></option>
        <?php endwhile; ?>
      </select>
    </label></p>
    <p><label>Deskripsi<br><textarea name="deskripsi" rows="6" required></textarea></label></p>
    <p><label>Gambar<br><input type="file" name="gambar" accept="image/*" required></label></p>
    <p><button class="btn">Simpan</button></p>
  </form>
  <p><a href="index.php" class="btn">Kembali</a></p>
</div>
</body>
</html>
