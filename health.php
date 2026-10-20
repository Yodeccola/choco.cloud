<?php
// Mengambil konfigurasi database
require_once 'config.php';

// Cek koneksi ke database MySQL
if ($conn->connect_error) {
    // Jika database bermasalah, kirim status error 500
    http_response_code(500);
    echo "ERROR: Database connection failed";
} else {
    // Jika semua normal, tampilkan OK sesuai instruksi dosen
    http_response_code(200);
    echo "OK";
}
?>
