const express = require('express');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 80;

// Halaman utama (statis): public/index.html
app.use(express.static(path.join(__dirname, 'public')));

// Health check: menampilkan teks "OK"
app.get('/health', (req, res) => {
  res.type('text/plain').send('OK');
});

app.listen(PORT, '0.0.0.0', () => {
  console.log(`Choco Cloud berjalan di port ${PORT}`);
});
