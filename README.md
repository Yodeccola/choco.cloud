# Choco Cloud

Web statis UMKM brownies **Choco Cloud**, tugas UTS Cloud Computing – **Kelompok 6**.

- Halaman utama: nama, deskripsi, 5 menu beserta harga, info store, dan footer anggota kelompok.
- `/health` menampilkan teks `OK`.
- Tanpa database.

## Struktur

```
server.js        # server Express (static + /health)
package.json
public/
  index.html
  style.css
  logo.png
```

## Cara instalasi

Prasyarat: Node.js 18 atau lebih baru.

```bash
git clone https://github.com/Yodeccola/choco.cloud.git
cd choco.cloud
npm install
npm start
```

Server berjalan di port 80 (ubah dengan `PORT=3000 npm start`).
Buka `http://localhost:3000/` dan `http://localhost:3000/health`.

## Menjalankan terus-menerus di server (opsional)

```bash
sudo npm install -g pm2
sudo PORT=80 pm2 start server.js --name choco-cloud
pm2 save && pm2 startup
```

## Anggota Kelompok 6

- Annisa Gladiola Duryat – Cloud Architect
- Nabila – Infrastructure Engineer
- Rayza Aditya Ilham – Infrastructure Engineer
- Siti Naylani Safitri – Security & Governance Officer
- Matius Rusdin Halawa – Cost & Operations Analyst
