<?php
include "../api/db.php";
// tambah
if(isset($_POST['tambah'])){
    $n = mysqli_real_escape_string($conn, $_POST['nama']);
    mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$n')");
    header("Location: kategori.php"); exit;
}
// hapus
if(isset($_POST['hapus'])){
    $id = intval($_POST['id']);
    mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori=$id");
    header("Location: kategori.php"); exit;
}
$cats = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori ASC");
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Kategori</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="container">
  <h2>Kategori</h2>
  <form method="post"><input name="nama" required><button name="tambah" class="btn">Tambah</button></form>
  <table class="table">
    <thead><tr><th>ID</th><th>Nama</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php while($c=mysqli_fetch_assoc($cats)): ?>
        <tr>
          <td><?= $c['id_kategori'] ?></td>
          <td><?= htmlspecialchars($c['nama_kategori']) ?></td>
          <td>
            <form method="post" style="display:inline" onsubmit="return confirm('hapus?')">
              <input type="hidden" name="id" value="<?= $c['id_kategori'] ?>">
              <button name="hapus" class="btn small danger">Hapus</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <p><a href="index.php" class="btn">Kembali</a></p>
</div>
</body>
</html>
