CREATE DATABASE pariwisata1;
USE pariwisata1;

-- users
CREATE TABLE IF NOT EXISTS users (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') DEFAULT 'user',
  tanggal_daftar DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- kategori
CREATE TABLE IF NOT EXISTS kategori (
  id_kategori INT AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(50) NOT NULL
);

-- wisata
CREATE TABLE IF NOT EXISTS wisata (
  id_wisata INT AUTO_INCREMENT PRIMARY KEY,
  id_kategori INT,
  nama_wisata VARCHAR(100),
  lokasi VARCHAR(150),
  deskripsi TEXT,
  gambar VARCHAR(255),
  FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE SET NULL
);

-- favorit
CREATE TABLE IF NOT EXISTS favorit (
  id_favorit INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT,
  id_wisata INT,
  tanggal_disimpan DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
  FOREIGN KEY (id_wisata) REFERENCES wisata(id_wisata) ON DELETE CASCADE,
  UNIQUE KEY unik_user_wisata (id_user, id_wisata)
);

-- sample data
INSERT INTO users (username, email, password, role) VALUES
('admin','admin@gmail.com', MD5('admin123'), 'admin');

INSERT INTO kategori (nama_kategori) VALUES
('Pantai'),('Gunung'),('Budaya'),('Tempat Bersejarah');

INSERT INTO wisata (id_kategori, nama_wisata, lokasi, deskripsi, gambar) VALUES
(1,'Pantai Menganti','Kebumen','Pantai Menganti di Kebumen, Jawa Tengah...','pm.jpg'),
(3,'Kota Tua','Jakarta','Kota Tua Jakarta adalah kawasan bersejarah...','k.jpg'),
(2,'Gunung Slamet','Jawa Tengah','Gunung Slamet adalah gunung tertinggi...','sl.jpg'),
(2,'Gunung Sumbing','Jawa Tengah','Gunung Sumbing adalah gunung berapi...','s.jpg'),
(1,'Pantai Pecaron','Kebumen','Pantai Pecaron di Kebumen menawarkan...','p.webp'),
(3,'Candi Borobudur','Magelang','Candi Borobudur adalah candi Buddha terbesar...','b.jpg');
