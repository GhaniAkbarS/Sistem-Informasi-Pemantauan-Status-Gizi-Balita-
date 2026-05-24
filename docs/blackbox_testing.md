# DOKUMEN PENGUJIAN BLACKBOX TESTING
## Sistem Informasi Pemantauan Status Gizi Balita

---

**Nama Sistem** : Sistem Informasi Pemantauan Status Gizi Balita  
**Metode Pengujian** : Blackbox Testing  
**Teknik** : Equivalence Partitioning & Boundary Value Analysis  
**Tanggal Pengujian** : Mei 2026

---

## 1. PENDAHULUAN

Pengujian *blackbox testing* dilakukan untuk memastikan setiap fungsionalitas sistem berjalan sesuai dengan kebutuhan yang telah dirancang. Pengujian ini berfokus pada **input** dan **output** sistem tanpa memperhatikan struktur internal kode. Pengujian dilakukan pada seluruh modul yang tersedia, yaitu:

1. Modul Autentikasi (Login, Register, Logout)
2. Modul Manajemen Data Balita
3. Modul Pemeriksaan & Status Gizi
4. Modul Imunisasi
5. Modul Vitamin A
6. Modul Laporan
7. Modul Portal Orang Tua
8. Modul Manajemen Pengguna (Admin)
9. Keamanan & Kontrol Akses

---

## 2. KETERANGAN STATUS

| Simbol | Keterangan |
|:------:|:-----------|
| ✅ | **Berhasil** — Output sesuai yang diharapkan |
| ❌ | **Gagal** — Output tidak sesuai yang diharapkan |

---

## 3. PENGUJIAN MODUL AUTENTIKASI

### 3.1 Fitur Login

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 1 | TC-AUTH-01 | Login dengan username dan password yang valid (role Kader) | Username: `kader01`, Password: `password123` | Berhasil masuk, diarahkan ke halaman Dashboard | ✅ |
| 2 | TC-AUTH-02 | Login dengan username dan password yang valid (role Admin) | Username: `admin01`, Password: `password123` | Berhasil masuk, diarahkan ke halaman Dashboard | ✅ |
| 3 | TC-AUTH-03 | Login dengan username dan password yang valid (role Orang Tua) | Username: `ortu01`, Password: `password123` | Berhasil masuk, diarahkan ke halaman Portal Orang Tua | ✅ |
| 4 | TC-AUTH-04 | Login dengan password yang salah | Username: `kader01`, Password: `salah123` | Gagal login, muncul pesan *"Username atau Password salah"* | ✅ |
| 5 | TC-AUTH-05 | Login dengan username yang tidak terdaftar | Username: `tidakada`, Password: `password` | Gagal login, muncul pesan *"Username atau Password salah"* | ✅ |
| 6 | TC-AUTH-06 | Login dengan semua field dikosongkan | Username: *(kosong)*, Password: *(kosong)* | Gagal login, muncul validasi *"field wajib diisi"* | ✅ |
| 7 | TC-AUTH-07 | Login dengan field password dikosongkan | Username: `kader01`, Password: *(kosong)* | Gagal login, muncul validasi pada field password | ✅ |

### 3.2 Fitur Register

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 8 | TC-AUTH-08 | Registrasi akun baru dengan data valid | Nama: `Kader Baru`, Username: `kaderbaru`, Password: `pass1234`, Role: `Kader`, Posyandu: `Posyandu Melati` | Registrasi berhasil, diarahkan ke halaman login dengan pesan sukses | ✅ |
| 9 | TC-AUTH-09 | Registrasi dengan username yang sudah terdaftar | Username: `kader01` *(sudah ada)*, data lain valid | Gagal registrasi, muncul pesan *"username sudah digunakan"* | ✅ |
| 10 | TC-AUTH-10 | Registrasi dengan password kurang dari 4 karakter | Password: `abc` | Gagal registrasi, muncul validasi minimum karakter | ✅ |
| 11 | TC-AUTH-11 | Registrasi tanpa memilih posyandu | Posyandu: *(tidak dipilih)* | Gagal registrasi, muncul validasi field posyandu | ✅ |
| 12 | TC-AUTH-12 | Registrasi tanpa memilih role | Role: *(tidak dipilih)* | Gagal registrasi, muncul validasi field role | ✅ |
| 13 | TC-AUTH-13 | Registrasi dengan nama melebihi 255 karakter | Nama: *(string 256 karakter)*, data lain valid | Gagal registrasi, muncul validasi *"nama maksimal 255 karakter"* | ✅ |

### 3.3 Fitur Logout

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 14 | TC-AUTH-14 | Logout dari sistem | Klik menu Logout | Sesi berakhir, diarahkan ke halaman login | ✅ |
| 15 | TC-AUTH-15 | Akses halaman terproteksi setelah logout | Akses URL `/balita` secara langsung setelah logout | Diarahkan ke halaman login | ✅ |

---

## 4. PENGUJIAN MODUL MANAJEMEN DATA BALITA

### 4.1 Melihat Daftar Balita

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 16 | TC-BAL-01 | Kader mengakses halaman daftar balita | Login sebagai Kader, akses menu Balita | Menampilkan daftar balita milik posyandu yang sesuai | ✅ |
| 17 | TC-BAL-02 | Data balita posyandu lain tidak tampil (multi-tenant) | Login sebagai Kader Posyandu A | Balita dari Posyandu B tidak terlihat di daftar | ✅ |

### 4.2 Tambah Data Balita

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 18 | TC-BAL-03 | Tambah balita dengan semua data valid | Nama: `Budi Santoso`, JK: `Laki-laki`, Tgl Lahir: `15-01-2023`, Umur: `24`, Nama Ortu: `Santoso`, Tinggi: `80.5`, Berat: `12.0` | Data berhasil disimpan, muncul pesan sukses, diarahkan ke daftar balita | ✅ |
| 19 | TC-BAL-04 | Tambah balita tanpa mengisi nama | Nama: *(kosong)*, data lain valid | Gagal menyimpan, muncul validasi *"nama wajib diisi"* | ✅ |
| 20 | TC-BAL-05 | Tambah balita dengan berat badan berupa teks | Berat Badan: `abc`, data lain valid | Gagal menyimpan, muncul validasi *"berat badan harus berupa angka"* | ✅ |
| 21 | TC-BAL-06 | Tambah balita tanpa memilih jenis kelamin | JK: *(tidak dipilih)*, data lain valid | Gagal menyimpan, muncul validasi field jenis kelamin | ✅ |
| 22 | TC-BAL-07 | Tambah balita dengan format tanggal lahir tidak valid | Tgl Lahir: `32-13-2023` | Gagal menyimpan, muncul validasi *"format tanggal tidak valid"* | ✅ |
| 23 | TC-BAL-08 | Tambah balita dengan tinggi badan berupa teks | Tinggi Badan: `abc`, data lain valid | Gagal menyimpan, muncul validasi *"tinggi badan harus berupa angka"* | ✅ |
| 24 | TC-BAL-09 | Tambah balita dengan berat badan bernilai 0 atau negatif | Berat Badan: `-5`, data lain valid | Gagal menyimpan, muncul validasi *"nilai harus lebih dari 0"* | ✅ |
| 25 | TC-BAL-10 | Tambah balita dengan tinggi badan bernilai 0 atau negatif | Tinggi Badan: `0`, data lain valid | Gagal menyimpan, muncul validasi *"nilai harus lebih dari 0"* | ✅ |
| 26 | TC-BAL-11 | Tambah balita dengan umur berupa teks | Umur: `dua belas`, data lain valid | Gagal menyimpan, muncul validasi *"umur harus berupa angka"* | ✅ |
| 27 | TC-BAL-12 | Tambah balita dengan menghubungkan akun orang tua | User Orang Tua: dipilih dari dropdown, data lain valid | Data berhasil disimpan dengan relasi akun orang tua | ✅ |

### 4.3 Edit Data Balita

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 28 | TC-BAL-13 | Edit data balita dengan data valid | Ubah nama menjadi `Budi Santoso Jr`, umur menjadi `25` | Data berhasil diperbarui, muncul pesan sukses | ✅ |
| 29 | TC-BAL-14 | Edit balita milik posyandu lain | Akses URL edit balita posyandu lain secara langsung | Sistem mengembalikan error 404 (data tidak ditemukan) | ✅ |
| 30 | TC-BAL-15 | Edit balita dengan field wajib dikosongkan | Nama: *(dihapus/dikosongkan)* | Gagal menyimpan, muncul validasi field wajib | ✅ |

### 4.4 Hapus Data Balita

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 31 | TC-BAL-16 | Hapus data balita milik posyandu sendiri | Klik tombol hapus pada data balita `Budi Santoso` | Data berhasil dihapus, muncul pesan sukses | ✅ |
| 32 | TC-BAL-17 | Hapus balita milik posyandu lain | Kirim request DELETE ke ID balita posyandu lain | Sistem mengembalikan error 404, data tidak terhapus | ✅ |

---

## 5. PENGUJIAN MODUL PEMERIKSAAN & STATUS GIZI

### 5.1 Melihat Data Pemeriksaan

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 33 | TC-PKS-01 | Kader mengakses halaman daftar pemeriksaan | Login sebagai Kader, akses menu Pemeriksaan | Menampilkan daftar pemeriksaan sesuai posyandu | ✅ |

### 5.2 Tambah Data Pemeriksaan

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 34 | TC-PKS-02 | Tambah pemeriksaan dengan data valid | Balita: `Budi`, Tgl Periksa: `01-01-2025`, Berat: `12.0`, Tinggi: `80.5` | Data tersimpan, status gizi terhitung otomatis, muncul pesan sukses | ✅ |
| 35 | TC-PKS-03 | Tambah pemeriksaan tanpa memilih balita | Balita: *(tidak dipilih)*, data lain valid | Gagal menyimpan, muncul validasi *"balita wajib dipilih"* | ✅ |
| 36 | TC-PKS-04 | Tambah pemeriksaan dengan nilai berat badan negatif | Berat Badan: `-1`, data lain valid | Gagal menyimpan, muncul validasi nilai tidak valid | ✅ |
| 37 | TC-PKS-05 | Tambah pemeriksaan tanpa tanggal periksa | Tgl Periksa: *(kosong)*, data lain valid | Gagal menyimpan, muncul validasi *"tanggal wajib diisi"* | ✅ |
| 38 | TC-PKS-06 | Verifikasi kalkulasi status gizi otomatis (Z-Score) | Input data dengan kondisi normal | Status gizi terisi otomatis dengan nilai yang valid (`Gizi Baik` / `Gizi Kurang` / `Gizi Lebih` / `Stunting`) | ✅ |
| 39 | TC-PKS-07 | Tambah pemeriksaan dengan tinggi badan berupa teks | Tinggi Badan: `abc`, data lain valid | Gagal menyimpan, muncul validasi *"tinggi badan harus berupa angka"* | ✅ |
| 40 | TC-PKS-08 | Tambah pemeriksaan dengan lingkar kepala berupa teks | Lingkar Kepala: `abc`, data lain valid | Gagal menyimpan, muncul validasi *"lingkar kepala harus berupa angka"* | ✅ |
| 41 | TC-PKS-09 | Tambah pemeriksaan dengan semua field dikosongkan | Semua field: *(kosong)* | Gagal menyimpan, muncul validasi pada seluruh field yang wajib diisi | ✅ |

### 5.3 Edit & Hapus Pemeriksaan

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 42 | TC-PKS-10 | Edit data pemeriksaan dengan data valid | Ubah berat badan dan tinggi badan | Data berhasil diperbarui, status gizi dihitung ulang | ✅ |
| 43 | TC-PKS-11 | Hapus data pemeriksaan | Klik tombol hapus pada data pemeriksaan | Data berhasil dihapus, muncul pesan sukses | ✅ |

---

## 6. PENGUJIAN MODUL IMUNISASI

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 44 | TC-IMU-01 | Akses halaman daftar imunisasi | Login sebagai Kader, akses menu Imunisasi | Menampilkan daftar imunisasi posyandu | ✅ |
| 45 | TC-IMU-02 | Tambah data imunisasi dengan data valid | Balita: `Budi`, Vaksin: `Polio`, Tgl Pemberian: `01-03-2025`, Keterangan: `Dosis ke-2` | Data imunisasi berhasil disimpan, muncul pesan sukses | ✅ |
| 46 | TC-IMU-03 | Tambah imunisasi tanpa memilih balita | Balita: *(tidak dipilih)*, data lain valid | Gagal menyimpan, muncul validasi *"balita wajib dipilih"* | ✅ |
| 47 | TC-IMU-04 | Tambah imunisasi tanpa nama vaksin | Nama Vaksin: *(kosong)*, data lain valid | Gagal menyimpan, muncul validasi *"nama vaksin wajib diisi"* | ✅ |
| 48 | TC-IMU-05 | Tambah imunisasi tanpa tanggal pemberian | Tgl Pemberian: *(kosong)*, data lain valid | Gagal menyimpan, muncul validasi *"tanggal wajib diisi"* | ✅ |
| 49 | TC-IMU-06 | Tambah imunisasi dengan format tanggal tidak valid | Tgl Pemberian: `99-99-9999` | Gagal menyimpan, muncul validasi *"format tanggal tidak valid"* | ✅ |
| 50 | TC-IMU-07 | Tambah imunisasi dengan semua field dikosongkan | Semua field: *(kosong)* | Gagal menyimpan, muncul validasi pada seluruh field yang wajib diisi | ✅ |
| 51 | TC-IMU-08 | Tambah imunisasi dengan keterangan sangat panjang | Keterangan: *(string lebih dari 1000 karakter)* | Data tetap berhasil disimpan karena field keterangan bersifat opsional tanpa batas panjang tertentu | ✅ |

---

## 7. PENGUJIAN MODUL VITAMIN A

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 52 | TC-VITA-01 | Akses halaman daftar Vitamin A | Login sebagai Kader, akses menu Vitamin A | Menampilkan daftar pemberian Vitamin A posyandu | ✅ |
| 53 | TC-VITA-02 | Tambah data Vitamin A dengan data valid | Balita: `Citra`, Jenis Kapsul: `Biru`, Bulan: `Februari`, Tahun: `2025`, Tgl Pemberian: `10-02-2025` | Data berhasil disimpan, muncul pesan sukses | ✅ |
| 54 | TC-VITA-03 | Tambah Vitamin A tanpa memilih balita | Balita: *(tidak dipilih)*, data lain valid | Gagal menyimpan, muncul validasi *"balita wajib dipilih"* | ✅ |
| 55 | TC-VITA-04 | Tambah Vitamin A tanpa memilih jenis kapsul | Jenis Kapsul: *(tidak dipilih)*, data lain valid | Gagal menyimpan, muncul validasi *"jenis kapsul wajib dipilih"* | ✅ |
| 56 | TC-VITA-05 | Tambah Vitamin A dengan tahun kurang dari 4 digit | Tahun Pemberian: `99` *(bukan 4 digit)* | Gagal menyimpan, muncul validasi *"tahun harus 4 digit"* | ✅ |
| 57 | TC-VITA-06 | Tambah Vitamin A tanpa memilih bulan pemberian | Bulan Pemberian: *(tidak dipilih)*, data lain valid | Gagal menyimpan, muncul validasi *"bulan wajib dipilih"* | ✅ |
| 58 | TC-VITA-07 | Tambah Vitamin A dengan format tanggal pemberian tidak valid | Tgl Pemberian: `99-99-9999` | Gagal menyimpan, muncul validasi *"format tanggal tidak valid"* | ✅ |
| 59 | TC-VITA-08 | Tambah Vitamin A dengan tahun berupa teks | Tahun Pemberian: `dua ribu` | Gagal menyimpan, muncul validasi *"tahun harus berupa angka 4 digit"* | ✅ |

---

## 8. PENGUJIAN MODUL LAPORAN

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 60 | TC-LAP-01 | Akses halaman laporan utama | Login sebagai Kader, akses menu Laporan | Halaman laporan tampil dengan data bulan dan tahun saat ini | ✅ |
| 61 | TC-LAP-02 | Filter laporan berdasarkan bulan dan tahun | Bulan: `Maret`, Tahun: `2025` | Data laporan diperbarui sesuai filter yang dipilih | ✅ |
| 62 | TC-LAP-03 | Cetak laporan pemeriksaan (PDF) | Klik tombol cetak laporan pemeriksaan | Halaman cetak/PDF laporan pemeriksaan terbuka | ✅ |
| 63 | TC-LAP-04 | Cetak laporan data balita (PDF) | Klik tombol cetak daftar balita | Halaman cetak/PDF daftar balita terbuka | ✅ |
| 64 | TC-LAP-05 | Cetak laporan imunisasi (PDF) | Klik tombol cetak laporan imunisasi | Halaman cetak/PDF laporan imunisasi terbuka | ✅ |
| 65 | TC-LAP-06 | Cetak laporan Vitamin A (PDF) | Klik tombol cetak laporan Vitamin A | Halaman cetak/PDF laporan Vitamin A terbuka | ✅ |

---

## 9. PENGUJIAN MODUL PORTAL ORANG TUA

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 66 | TC-ORT-01 | Orang tua mengakses portal | Login sebagai Orang Tua, akses portal | Menampilkan daftar anak yang terdaftar atas akun tersebut | ✅ |
| 67 | TC-ORT-02 | Orang tua melihat detail data anak | Klik nama anak di portal | Menampilkan detail data anak beserta riwayat pemeriksaan dan grafik pertumbuhan | ✅ |
| 68 | TC-ORT-03 | Orang tua tidak dapat mengakses data anak orang lain | Akses URL `/portal/anak/{id_anak_orang_lain}` | Sistem mengembalikan error 404, data tidak ditampilkan | ✅ |
| 69 | TC-ORT-04 | Orang tua tidak bisa mengakses menu Kader/Admin | Akses URL `/balita`, `/periksa` secara langsung | Diarahkan kembali ke portal dengan pesan *"tidak punya hak akses"* | ✅ |

---

## 10. PENGUJIAN MODUL MANAJEMEN PENGGUNA (ADMIN)

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 70 | TC-USR-01 | Admin mengakses halaman manajemen pengguna | Login sebagai Admin, akses menu Pengguna | Menampilkan daftar pengguna yang terdaftar di posyandu Admin | ✅ |
| 71 | TC-USR-02 | Admin tidak bisa melihat pengguna posyandu lain (multi-tenant) | Login sebagai Admin Posyandu A | Pengguna dari Posyandu B tidak tampil | ✅ |
| 72 | TC-USR-03 | Admin menghapus akun pengguna | Klik hapus pada salah satu pengguna | Pengguna berhasil dihapus, muncul pesan sukses | ✅ |
| 73 | TC-USR-04 | Admin tidak bisa menghapus akun dirinya sendiri | Akun milik Admin tidak muncul di daftar | Akun Admin tidak tampil di halaman manajemen pengguna | ✅ |
| 74 | TC-USR-05 | Kader tidak bisa mengakses halaman manajemen pengguna | Login sebagai Kader, akses URL `/users` | Diarahkan ke Dashboard dengan pesan *"tidak punya hak akses"* | ✅ |
| 75 | TC-USR-06 | Orang tua tidak bisa mengakses halaman manajemen pengguna | Login sebagai Orang Tua, akses URL `/users` | Diarahkan ke Portal dengan pesan *"tidak punya hak akses"* | ✅ |

---

## 11. PENGUJIAN KEAMANAN & KONTROL AKSES (RBAC)

| No | Kode Uji | Skenario Pengujian | Data Input | Output yang Diharapkan | Status |
|:--:|:--------:|:-------------------|:-----------|:-----------------------|:------:|
| 76 | TC-SEC-01 | Akses halaman dashboard tanpa login | Buka URL `/` tanpa sesi aktif | Diarahkan ke halaman login | ✅ |
| 77 | TC-SEC-02 | Kader dari Posyandu A tidak bisa akses data Posyandu B | Login Posyandu A, manipulasi ID di URL ke data Posyandu B | Sistem mengembalikan error 404 | ✅ |
| 78 | TC-SEC-03 | Pengguna tidak terdaftar tidak bisa masuk ke sistem | Tidak ada sesi login | Semua halaman terproteksi mengalihkan ke login | ✅ |

---

## 12. RINGKASAN HASIL PENGUJIAN

| Modul | Jumlah Test Case | Berhasil | Gagal |
|:------|:----------------:|:--------:|:-----:|
| Autentikasi (Login, Register, Logout) | 15 | 15 | 0 |
| Manajemen Data Balita | 17 | 17 | 0 |
| Pemeriksaan & Status Gizi | 11 | 11 | 0 |
| Imunisasi | 8 | 8 | 0 |
| Vitamin A | 8 | 8 | 0 |
| Laporan | 6 | 6 | 0 |
| Portal Orang Tua | 4 | 4 | 0 |
| Manajemen Pengguna (Admin) | 6 | 6 | 0 |
| Keamanan & Kontrol Akses | 3 | 3 | 0 |
| **TOTAL** | **78** | **78** | **0** |

> **Kesimpulan:** Seluruh **78 test case** yang telah dirancang dan dijalankan menunjukkan hasil yang **berhasil (✅)**. Semua fungsi sistem berjalan sesuai dengan spesifikasi yang diharapkan, termasuk validasi input data tidak sesuai, kontrol akses berbasis peran (RBAC), isolasi data antar posyandu (multi-tenant), dan kalkulasi status gizi secara otomatis.
