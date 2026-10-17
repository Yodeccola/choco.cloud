-- CHOCO CLOUD – import file ini lewat phpMyAdmin (tab Import)
CREATE DATABASE IF NOT EXISTS choco_cloud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE choco_cloud;

CREATE TABLE menu (
  id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama      VARCHAR(100) NOT NULL,
  deskripsi VARCHAR(255) NULL,
  emoji     VARCHAR(8) NULL,
  harga     INT UNSIGNED NOT NULL,
  stok      INT UNSIGNED NOT NULL DEFAULT 20,
  aktif     TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE orders (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama       VARCHAR(100) NOT NULL,
  wa         VARCHAR(20) NOT NULL,
  tgl_ambil  DATE NOT NULL,
  catatan    VARCHAR(300) NULL,
  total      INT UNSIGNED NOT NULL,
  status     ENUM('Menunggu','Diproses','Siap diambil','Selesai','Dibatalkan') NOT NULL DEFAULT 'Menunggu',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1001;

CREATE TABLE order_items (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id     INT UNSIGNED NOT NULL,
  menu_id      INT UNSIGNED NOT NULL,
  qty          INT UNSIGNED NOT NULL,
  harga_satuan INT UNSIGNED NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (menu_id)  REFERENCES menu(id)
) ENGINE=InnoDB;

INSERT INTO menu (nama, deskripsi, emoji, harga, stok) VALUES
('Fudgy Chocolate','Lumer, cokelat pekat.','🍫',45000,20),
('Almond Crunch','Topping almond panggang.','🌰',50000,20),
('Cheese Supreme','Keju gurih di atas cokelat.','🧀',55000,20),
('Lotus Biscoff','Saus dan remahan Biscoff.','🍪',58000,20),
('Matcha Delight','Matcha dengan white chocolate.','🍵',52000,20);
