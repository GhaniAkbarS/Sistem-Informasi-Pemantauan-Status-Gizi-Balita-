# Rencana Testing Sistem Gizi Balita

---

## FASE 1 — Persiapan Data (Lakukan ini dulu sebelum test fitur apapun!)

### Step 1.1 — Register Akun

Buka `http://localhost:8000/register` dan buat akun berikut satu per satu:

| No | Nama | Username | Password | Role | Posyandu |
|---|---|---|---|---|---|
| 1 | Admin Posyandu | `admin1` | `1234` | Admin | Posyandu Cendrawasih |
| 2 | Kader Siti | `kader1` | `1234` | Petugas/Kader | Posyandu Cendrawasih |
| 3 | Ibu Rina | `ortu1` | `1234` | Orang Tua | Posyandu Cendrawasih |
| 4 | Ibu Dewi | `ortu2` | `1234` | Orang Tua | Posyandu Cendrawasih |

---

### Step 1.2 — Input Data Balita

Login sebagai `kader1`, masuk ke **Data Balita → Tambah Balita**, input:

| No | Nama Balita | JK | Tgl Lahir | Nama Ortu | BB | TB | Link Akun Ortu |
|---|---|---|---|---|---|---|---|
| 1 | Budi Santoso | L | 2023-03-10 | Rina Wati | 12.5 | 85 | Ibu Rina (ortu1) |
| 2 | Sari Dewi | P | 2022-08-15 | Dewi Lestari | 10.2 | 78 | Ibu Dewi (ortu2) |
| 3 | Andi Putra | L | 2024-01-05 | Bapak Hendra | 8.0 | 68 | (kosongkan) |

---

### Step 1.3 — Input Data Pemeriksaan

Masuk ke **Pemeriksaan → Tambah Pemeriksaan**, input minimal 3x per anak agar grafik terisi:

**Budi Santoso:**
| Tanggal | BB | TB |
|---|---|---|
| 2025-01-15 | 11.0 | 80 |
| 2025-03-15 | 11.8 | 83 |
| 2025-05-01 | 12.5 | 85 |

**Sari Dewi:**
| Tanggal | BB | TB |
|---|---|---|
| 2025-02-10 | 9.5 | 74 |
| 2025-04-10 | 9.9 | 76 |
| 2025-05-01 | 10.2 | 78 |

---

### Step 1.4 — Input Imunisasi

Masuk ke **Imunisasi → Input Imunisasi**, input:

| Anak | Vaksin | Tanggal |
|---|---|---|
| Budi Santoso | BCG | 2023-04-10 |
| Budi Santoso | Polio 1 | 2023-04-10 |
| Budi Santoso | DPT-HB-Hib 1 | 2023-05-10 |
| Sari Dewi | HB0 | 2022-08-16 |
| Sari Dewi | BCG | 2022-09-15 |

---

### Step 1.5 — Input Vitamin A

Masuk ke **Vitamin A → Input Vitamin A**, input:

| Anak | Kapsul | Bulan | Tahun | Tanggal |
|---|---|---|---|---|
| Budi Santoso | Merah (200.000 IU) | Februari | 2025 | 2025-02-14 |
| Sari Dewi | Merah (200.000 IU) | Agustus | 2024 | 2024-08-12 |

---

## FASE 2 — Testing Fitur per Role

---

### TEST A — Autentikasi & Keamanan Akses

| # | Aksi | Yang Diharapkan | Hasil |
|---|---|---|---|
| A1 | Login sebagai `kader1` | Masuk ke dashboard kader (`/`) | |
| A2 | Login sebagai `ortu1` | Langsung ke portal (`/portal`) | |
| A3 | Login sebagai `admin1` | Masuk ke dashboard kader (`/`) | |
| A4 | Login ortu → akses `/balita` via URL | Redirect ke `/portal` | |
| A5 | Login ortu → akses `/periksa` via URL | Redirect ke `/portal` | |
| A6 | Login ortu → akses `/imunisasi/create` via URL | Redirect ke `/portal` | |
| A7 | Login kader → akses `/portal` via URL | Redirect + pesan error | |
| A8 | Tanpa login → akses `/balita` via URL | Redirect ke `/login` | |
| A9 | Tanpa login → akses `/imunisasi/create` via URL | Redirect ke `/login` | |

---

### TEST B — Dashboard Kader

Login sebagai `kader1`:

| # | Yang Dicek | Yang Diharapkan | Hasil |
|---|---|---|---|
| B1 | Angka "Total Balita" | Sesuai jumlah yang diinput (3) | |
| B2 | Angka "Pemeriksaan Bulan Ini" | Sesuai pemeriksaan bulan berjalan | |
| B3 | Tabel "Pemeriksaan Terbaru" | Data 7 hari terakhir muncul | |

---

### TEST C — Manajemen Balita (Kader)

Login sebagai `kader1`:

| # | Yang Dicek | Yang Diharapkan | Hasil |
|---|---|---|---|
| C1 | Halaman index balita | Hanya balita dari posyandu sendiri | |
| C2 | Tambah balita — semua field lengkap + link ortu | Tersimpan, redirect ke index | |
| C3 | Tambah balita — field `jk` dikosongkan | Validasi gagal, muncul pesan error | |
| C4 | Edit balita — dropdown akun ortu muncul | Daftar akun `orang_tua` tampil | |
| C5 | Edit balita — ganti/tambah link ke akun ortu | `user_id` terupdate di database | |
| C6 | Hapus balita | Data terhapus dari list | |

---

### TEST D — Pemeriksaan (Kader)

Login sebagai `kader1`:

| # | Yang Dicek | Yang Diharapkan | Hasil |
|---|---|---|---|
| D1 | Daftar pemeriksaan | Hanya dari posyandu sendiri | |
| D2 | Tambah pemeriksaan baru | Data tersimpan | |
| D3 | Kolom status gizi | Terisi setelah simpan | |
| D4 | Edit pemeriksaan | Data terupdate | |

---

### TEST E — Imunisasi (Kader)

Login sebagai `kader1`:

| # | Yang Dicek | Yang Diharapkan | Hasil |
|---|---|---|---|
| E1 | Akses `/imunisasi/create` | Halaman tampil normal | |
| E2 | Dropdown nama anak | Balita dari posyandu sendiri muncul | |
| E3 | Dropdown nama vaksin | Semua pilihan vaksin tampil | |
| E4 | Simpan data imunisasi | Tersimpan + muncul pesan sukses | |

---

### TEST F — Vitamin A (Kader)

Login sebagai `kader1`:

| # | Yang Dicek | Yang Diharapkan | Hasil |
|---|---|---|---|
| F1 | Akses `/vitamin-a/create` | Halaman tampil normal | |
| F2 | Dropdown jenis kapsul | Pilihan Biru & Merah muncul | |
| F3 | Dropdown bulan pemberian | Pilihan Februari & Agustus muncul | |
| F4 | Simpan data vitamin A | Tersimpan + muncul pesan sukses | |

---

### TEST G — Portal Orang Tua (Read-Only)

Login sebagai `ortu1` (anaknya: Budi Santoso):

| # | Yang Dicek | Yang Diharapkan | Hasil |
|---|---|---|---|
| G1 | Halaman portal `/portal` | Card anak "Budi Santoso" muncul | |
| G2 | Login sebagai `ortu2` (Sari Dewi) | Hanya muncul Sari Dewi, bukan Budi | |
| G3 | Klik "Lihat Perkembangan" | Masuk ke halaman detail anak | |
| G4 | Detail — tabel riwayat pemeriksaan | 3 riwayat pemeriksaan muncul | |
| G5 | Detail — grafik pertumbuhan | Grafik garis BB & TB tampil | |
| G6 | Detail — tabel imunisasi | Vaksin BCG, Polio 1, DPT muncul | |
| G7 | Detail — tabel Vitamin A | Data vitamin A Februari muncul | |
| G8 | Akses `/portal/anak/999` (ID tidak ada) | Error 404 | |
| G9 | Akses `/portal/anak/{id_anak_ortu_lain}` | Error 404 (data terisolasi) | |
| G10 | Tidak ada tombol Edit/Hapus | Konfirmasi bahwa ini read-only | |
| G11 | Tombol Keluar/Logout di header | Bisa logout | |

---

### TEST H — Admin

Login sebagai `admin1`:

| # | Yang Dicek | Yang Diharapkan | Hasil |
|---|---|---|---|
| H1 | Menu "Manajemen User" di sidebar | Muncul hanya untuk admin | |
| H2 | Halaman `/users` | Daftar user dari posyandu yang sama | |
| H3 | Login kader → cek sidebar | Menu Manajemen User tidak muncul | |
| H4 | Hapus salah satu user | User terhapus dari daftar | |

---

## FASE 3 — Testing Negatif (Keamanan)

| # | Skenario | Yang Diharapkan | Hasil |
|---|---|---|---|
| N1 | Tanpa login → POST ke `/balita/store` | Redirect ke login | |
| N2 | Tanpa login → akses `/imunisasi/create` | Redirect ke login | |
| N3 | Tanpa login → akses `/vitamin-a/create` | Redirect ke login | |
| N4 | Login ortu → akses data balita yang bukan anaknya | 404 / tidak muncul | |

---

## Checklist Akhir

```
[ ] Fase 1 — Semua data berhasil diinput
[ ] Test A — Autentikasi & keamanan akses
[ ] Test B — Dashboard kader
[ ] Test C — Manajemen balita
[ ] Test D — Pemeriksaan
[ ] Test E — Imunisasi
[ ] Test F — Vitamin A
[ ] Test G — Portal orang tua
[ ] Test H — Admin
[ ] Fase 3 — Testing negatif / keamanan
```

Jika semua checklist terpenuhi → sistem siap digunakan! 🎉
