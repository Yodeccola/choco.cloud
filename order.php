<?php
require_once 'config.php';
header('Content-Type: application/json');

// Menangkap data form standar
$nama = $_POST['nama'] ?? '';
$whatsapp = $_POST['wa'] ?? '';
$tanggal_ambil = $_POST['tgl'] ?? '';
$catatan = $_POST['catatan'] ?? '';
$total_harga = $_POST['total'] ?? 0;

if (empty($nama) || empty($whatsapp)) {
    echo json_encode(["status" => "error", "message" => "Nama dan WhatsApp wajib diisi."]);
    exit;
}

// Memasukkan data ke database choco_cloud
$query = "INSERT INTO orders (nama, whatsapp, tanggal_ambil, catatan, total_harga) VALUES ('$nama', '$whatsapp', '$tanggal_ambil', '$catatan', '$total_harga')";

if ($conn->query($query) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Pesanan Brownies berhasil masuk database VPS!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal menyimpan ke database: " . $conn->error]);
}

$conn->close();
?>
