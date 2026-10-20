<?php
require __DIR__ . '/../config.php';
header('Content-Type: application/json; charset=utf-8');

function fail(string $msg, int $code = 400): void {
    http_response_code($code);
    echo json_encode(['ok' => false, 'error' => $msg], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') fail('Metode tidak diizinkan.', 405);

$in = json_decode(file_get_contents('php://input'), true);
if (!is_array($in)) fail('Data tidak valid.');

$nama = trim((string)($in['nama'] ?? ''));
$wa   = trim((string)($in['wa'] ?? ''));
$tgl  = (string)($in['tgl'] ?? '');
$cat  = mb_substr(trim((string)($in['catatan'] ?? '')), 0, 300);
$items = $in['items'] ?? [];

if (mb_strlen($nama) < 2 || mb_strlen($nama) > 100) fail('Nama minimal 2 huruf.');
if (!preg_match('/^[0-9+\-\s]{8,20}$/', $wa)) fail('Nomor WhatsApp tidak valid.');
$d = DateTime::createFromFormat('Y-m-d', $tgl);
if (!$d || $d->format('Y-m-d') !== $tgl || $tgl < date('Y-m-d')) fail('Tanggal ambil tidak valid.');
if (!is_array($items) || count($items) < 1 || count($items) > 20) fail('Pilih minimal satu brownies.');

// Gabungkan item yang sama, validasi jumlah
$want = [];
foreach ($items as $it) {
    $id = (int)($it['id'] ?? 0); $q = (int)($it['qty'] ?? 0);
    if ($id < 1 || $q < 1 || $q > 50) fail('Jumlah pesanan tidak valid.');
    $want[$id] = ($want[$id] ?? 0) + $q;
}

$pdo = db();
try {
    $pdo->beginTransaction();
    $ph = implode(',', array_fill(0, count($want), '?'));
    $st = $pdo->prepare("SELECT id, nama, harga, stok FROM menu WHERE aktif = 1 AND id IN ($ph) FOR UPDATE");
    $st->execute(array_keys($want));
    $menu = [];
    foreach ($st->fetchAll() as $m) $menu[(int)$m['id']] = $m;

    $total = 0;
    foreach ($want as $id => $q) {
        if (!isset($menu[$id])) { $pdo->rollBack(); fail('Ada menu yang tidak tersedia.'); }
        if ($menu[$id]['stok'] < $q) { $pdo->rollBack(); fail('Stok ' . $menu[$id]['nama'] . ' tidak cukup.'); }
        $total += $q * (int)$menu[$id]['harga'];   // harga dihitung di server, bukan dari browser
    }

    $pdo->prepare('INSERT INTO orders (nama, wa, tgl_ambil, catatan, total) VALUES (?,?,?,?,?)')
        ->execute([$nama, $wa, $tgl, $cat ?: null, $total]);
    $orderId = (int)$pdo->lastInsertId();

    $ins = $pdo->prepare('INSERT INTO order_items (order_id, menu_id, qty, harga_satuan) VALUES (?,?,?,?)');
    $upd = $pdo->prepare('UPDATE menu SET stok = stok - ? WHERE id = ?');
    foreach ($want as $id => $q) {
        $ins->execute([$orderId, $id, $q, $menu[$id]['harga']]);
        $upd->execute([$q, $id]);
    }
    $pdo->commit();
    echo json_encode(['ok' => true, 'order_id' => $orderId, 'total' => $total]);
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    error_log($e->getMessage());
    fail('Server sedang bermasalah. Coba lagi sebentar.', 500);
}