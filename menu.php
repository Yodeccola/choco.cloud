<?php
require __DIR__ . '/../config.php';
header('Content-Type: application/json; charset=utf-8');
try {
    $rows = db()->query('SELECT id, nama, deskripsi, emoji, harga, stok FROM menu WHERE aktif = 1 AND stok > 0 ORDER BY id')->fetchAll();
    foreach ($rows as &$r) { $r['id'] = (int)$r['id']; $r['harga'] = (int)$r['harga']; $r['stok'] = (int)$r['stok']; }
    echo json_encode(['menu' => $rows], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['menu' => []]);
}