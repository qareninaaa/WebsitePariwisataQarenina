<?php
include "../api/db.php";
$id = intval($_GET['id'] ?? 0);
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id = intval($_POST['id']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $id_kategori = intval($_POST['id_kategori']);

    $cur = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM wisata WHERE id_wisata=$id LIMIT 1"));
    $gambar = $cur['gambar'];
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error']===0){
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $new = uniqid().'.'.$ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], __DIR__ . "/../img/" . $new);
        if($gambar && file_exists(__DIR__ . "/../img/".$gambar)) @unlink(__DIR__ . "/../img/".$gambar);
        $gambar = $new;
    }
    mysqli_query($conn, "UPDATE wisata SET id_kategori=$id_kategori, nama_wisata='$nama', lokasi='$lokasi', deskripsi='$deskripsi', gambar='$gambar' WHERE id_wisata=$id");
    header("Location: index.php");
    exit;
}
$r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM wisata WHERE id_wisata=$id LIMIT 1"));
$cats = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori ASC");
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Wisata</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="container">
  <h2>Edit Wisata</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $r['id_wisata'] ?>">
    <p><label>Nama<br><input name="nama" value="<?= htmlspecialchars($r['nama_wisata']) ?>" required></label></p>
    <p><label>Lokasi<br><input name="lokasi" value="<?= htmlspecialchars($r['lokasi']) ?>" required></label></p>
    <p><label>Kategori<br>
      <select name="id_kategori" required>
        <?php while($c=mysqli_fetch_assoc($cats)): ?>
          <option value="<?= $c['id_kategori'] ?>" <?= ($c['id_kategori']==$r['id_kategori']) ? 'selected' : '' ?>><?= htmlspecialchars($c['nama_kategori']) ?></option>
        <?php endwhile; ?>
      </select>
    </label></p>
    <p><label>Deskripsi<br><textarea name="deskripsi" rows="6" required><?= htmlspecialchars($r['deskripsi']) ?></textarea></label></p>
    <p>Gambar saat ini:<br>
      <?php if($r['gambar']): ?><img src="../img/<?= htmlspecialchars($r['gambar']) ?>" style="height:100px"><?php endif; ?>
    </p>
    <p><label>Ganti Gambar (opsional)<br><input type="file" name="gambar" accept="image/*"></label></p>
    <p><button class="btn">Simpan</button></p>
  </form>
  <p><a href="index.php" class="btn">Kembali</a></p>
</div>
</body>
</html>
