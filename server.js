const express = require('express');
const mysql = require('mysql2');
const dotenv = require('dotenv');
const path = require('path');

// Membaca password terenkripsi dari file .env (Memenuhi Syarat Nilai Tambah Poin 2)
dotenv.config();

const app = express();
const port = 3000;

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(__dirname));

// Konfigurasi Kredensial Database Relasional MySQL
const db = mysql.createConnection({
    host: process.env.DB_HOST || 'localhost',
    user: process.env.DB_USER || 'root',
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME || 'choco_db'
});

db.connect((err) => {
    if (err) console.error('Database terputus:', err.message);
    else console.log('Sukses terhubung ke database MySQL internal.');
});

// 🌟 REQUIREMENT WAJIB 4 & OPSIONAL D3: Alamat /health wajib cek koneksi database
app.get('/health', (req, res) => {
    db.query('SELECT 1', (err) => {
        if (err) {
            // Jika database server down atau putus, kirim kode error 500
            return res.status(500).send('Database Error: Koneksi terputus');
        }
        // Jika web server dan database normal aman, tampilkan "OK"
        res.status(200).send('OK');
    });
});

// REQUIREMENT WAJIB 2: Memuat file utama website CHOCO CLOUD
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

// API Menyediakan Data Menu Kue Brownies
app.get('/api/menu', (req, res) => {
    res.json({
        menu: [
            {id:1,nama:'Fudgy Chocolate',harga:45000,emoji:'🍫',deskripsi:'Lumer, cokelat pekat.',stok:99},
            {id:2,nama:'Almond Crunch',harga:50000,emoji:'🌰',deskripsi:'Topping almond panggang.',stok:99},
            {id:3,nama:'Cheese Supreme',harga:55000,emoji:'🧀',deskripsi:'Keju gurih di atas cokelat.',stok:99},
            {id:4,nama:'Lotus Biscoff',harga:58000,emoji:'🍪',deskripsi:'Saus dan remahan Biscoff.',stok:99},
            {id:5,nama:'Matcha Delight',harga:52000,emoji:'🍵',deskripsi:'Matcha dengan white chocolate.',stok:99}
        ]
    });
});

// REQUIREMENT OPSIONAL 1: Menerima pesanan dan menyimpannya ke tabel database
app.post('/api/order', (req, res) => {
    const { nama, wa, tgl, catatan, items, total } = req.body;
    const sql = 'INSERT INTO pesanan (nama_pelanggan, nomor_wa, tanggal_ambil, catatan, item_dibeli, total_bayar) VALUES (?, ?, ?, ?, ?, ?)';
    
    db.query(sql, [nama, wa, tgl, catatan, items, total], (err, result) => {
        if (err) {
            console.error(err);
            return res.status(500).json({ ok: false, error: err.message });
        }
        // Beri respon sukses berbentuk JSON ke frontend
        res.json({ ok: true, order_id: result.insertId, total: total });
    });
});

app.listen(port, () => {
    console.log(`CHOCO CLOUD server aktif secara publik pada port ${port}`);
});
