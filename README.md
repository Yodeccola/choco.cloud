# Choco Cloud

> Choco Cloud adalah aplikasi sistem pemesanan menu dan manajemen toko kue berbasis web.

## ✨ Fitur Utama
- Desain responsif (*mobile-friendly*)
- Pengolahan logika server-side menggunakan PHP
- Interaktivitas antarmuka dengan JavaScript murni (Vanilla JS)
- Tampilan antarmuka modern dengan CSS kustom

## 🛠️ Teknologi yang Digunakan
- **PHP** - Bahasa pemrograman server-side
- **HTML5** - Struktur halaman web
- **CSS3** - Desain dan tata letak (*styling*)
- **JavaScript (ES6+)** - Interaktivitas *client-side*
- **MySQL** - Database (menggunakan file `database.sql`)

## 🚀 Cara Upload & Deployment (IDCloudhost)

Karena proyek ini akan di-upload ke IDCloudhost, ikuti langkah-langkah berikut:

1. **Import Database**
   * Login ke cPanel atau DirectAdmin hosting IDCloudhost Anda.
   * Buka **phpMyAdmin**, lalu buat database baru.
   * Pilih database tersebut, klik menu **Import**, lalu pilih file `database.sql` yang ada di dalam proyek ini untuk mengimpor tabel.

2. **Konfigurasi Koneksi Database**
   * Buka file `config.php` di proyek Anda.
   * Sesuaikan informasi *host*, *username*, *password*, dan *nama database* dengan kredensial database yang baru saja Anda buat di cPanel/DirectAdmin IDCloudhost.

3. **Upload File ke Hosting**
   * Buka **File Manager** di cPanel/DirectAdmin.
   * Masuk ke dalam folder `public_html`.
   * Unggah (*Upload*) seluruh file proyek Anda ke dalam folder `public_html` (atau buat subfolder jika diperlukan).
   * Jika Anda mengunggah dalam bentuk ZIP (`choco-cloud.zip`), klik kanan file ZIP tersebut lalu pilih **Extract**.

4. **Akses Website**
   * Buka browser dan ketikkan nama domain Anda untuk mulai menggunakan aplikasi.

## 📥 Cara Clone untuk Pengembangan Lokal (Opsional)
Jika Anda ingin mengedit kodenya kembali di komputer lokal:
```bash
git clone [https://github.com/Yodeccola/choco.cloud.git](https://github.com/Yodeccola/choco.cloud.git)
cd choco.cloud