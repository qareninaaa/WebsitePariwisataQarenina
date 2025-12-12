<?php
include "../api/db.php";
$res = mysqli_query($conn, "SELECT w.id_wisata, w.nama_wisata, w.lokasi, w.gambar, k.nama_kategori FROM wisata w LEFT JOIN kategori k ON w.id_kategori = k.id_kategori ORDER BY w.id_wisata DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin - Wisata</title>
  <link rel="stylesheet" href="../style.css">
  <style>.admin-wrap{padding:20px}.table{width:100%;border-collapse:collapse}.table th,.table td{padding:8px;border:1px solid #ddd}</style>
</head>
<body>
  <div class="admin-wrap container">
    <h2>Admin - Wisata</h2>
    <p><a href="tambah.php" class="btn">Tambah Wisata</a> <a href="kategori.php" class="btn">Kelola Kategori</a></p>
    <table class="table">
      <thead><tr><th>ID</th><th>Gambar</th><th>Nama</th><th>Lokasi</th><th>Kategori</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php while($r = mysqli_fetch_assoc($res)): ?>
        <tr>
          <td><?= $r['id_wisata'] ?></td>
          <td><img src="../img/<?= htmlspecialchars($r['gambar']) ?>" style="height:60px"></td>
          <td><?= htmlspecialchars($r['nama_wisata']) ?></td>
          <td><?= htmlspecialchars($r['lokasi']) ?></td>
          <td><?= htmlspecialchars($r['nama_kategori']) ?></td>
          <td>
            <a href="edit.php?id=<?= $r['id_wisata'] ?>" class="btn small">Edit</a>
            <form style="display:inline" method="post" action="hapus.php" onsubmit="return confirm('Hapus?')">
              <input type="hidden" name="id" value="<?= $r['id_wisata'] ?>">
              <button class="btn small danger">Hapus</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
