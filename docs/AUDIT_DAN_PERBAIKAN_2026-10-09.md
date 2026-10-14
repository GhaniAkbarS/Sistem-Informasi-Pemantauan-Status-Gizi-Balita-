# Audit dan perbaikan bertahap — 9 Oktober 2026

## Tahap 1 — Audit

### A. Temuan

| Prioritas | Temuan dan bukti | Dampak |
| --- | --- | --- |
| Kritis | `UserController::doRegister` menerima `role` dari request; form registrasi menyediakan admin | Pengunjung dapat membuat akun admin |
| Kritis | `PeriksaController`, `ImunisasiController`, `VitaminAController` menerima `balita_id` global; pemeriksaan dapat diedit/dihapus dengan ID global | Akses lintas Posyandu |
| Tinggi | `BalitaController::store` dan `update` tidak mengisi kolom `nama` | Simpan gagal atau perubahan nama hilang |
| Tinggi | `GiziKalkulator` menghasilkan `Gizi Normal`, tetapi dashboard dan cetak menghitung `Gizi Baik`; tren stunting memasukkan gizi kurang | Jumlah dan label menyesatkan |
| Tinggi | Kalkulator menghasilkan tiga Z-score tetapi `sp_periksa` tidak menyimpannya | Riwayat dan laporan kehilangan hasil saat pemeriksaan |
| Tinggi | `GiziKalkulator` memakai tabel median dan SD; dua Blade memuat tabel kurva tersendiri. Sumber dan kecocokan dengan LMS WHO tidak terbukti di repositori | Ketepatan antropometri belum tervalidasi |
| Sedang | Form pemeriksaan menerima tanggal sebelum lahir dan ukuran di luar rentang tabel; umur balita berasal dari request | Nilai tidak valid dapat diproses |
| Sedang | `BalitaController::destroy` memicu cascade pemeriksaan dan layanan; penghapusan user dapat menyisakan relasi | Riwayat hilang atau anak tanpa akun terkait |
| Sedang | `includes/script.blade.php` memuat SB Admin/Bootstrap 4 dan Chart.js lokal, sedangkan beberapa halaman memakai Tabler dan Chart.js dari CDN | Risiko interaksi dan grafik tidak konsisten |

Alur data: registrasi/login (`UserController`, `sp_users`) → input balita (`BalitaController`, `sp_balita`) → input pemeriksaan (`PeriksaController`, `GiziKalkulator`, `sp_periksa`) → dashboard (`routes/web.php`), portal orang tua, dan laporan. Imunisasi dan vitamin A tersimpan terpisah dengan `balita_id`. Portal orang tua sudah membatasi `user_id`, sedangkan daftar kader dibatasi Posyandu melalui query. Fitur pencarian/filter lengkap, CRUD imunisasi/vitamin A, dan ekspor Excel belum ditemukan; laporan cetak sudah tersedia.

### B. Perubahan

Belum ada perubahan pada tahap audit. Urutan perbaikan: tutup eskalasi peran dan ID lintas Posyandu → perbaiki nama, umur, validasi dan Z-score → selaraskan agregasi status → lindungi riwayat → uji regresi. Validasi acuan WHO dipisahkan karena membutuhkan tabel sumber dan kasus pembanding resmi.

### C. Pengujian

Audit statis terhadap routes, controllers, models, migrations, Blade, aset, dan tests. Tidak ada klaim perilaku runtime pada tahap ini.

### D. Risiko dan keterbatasan

Tidak ada dokumen sumber tabel WHO atau parameter LMS di repositori. `docs/CATATAN_IMPLEMENTASI_TEKNIS.md` dan `cheatsheet_status_gizi.md` memuat definisi algoritma yang berbeda dari implementasi saat ini; perlu sinkronisasi akademis setelah aturan klinis diverifikasi.

### E. Langkah selanjutnya

Perbaikan inti dan akses backend, lalu verifikasi terhadap data acuan antropometri resmi.

## Tahap 2–3 — Perbaikan inti dan keamanan

### A. Temuan

Kategori pada kolom lama `status_gizi` adalah kategori gabungan prioritas. Ini tidak dapat mewakili kategori BB/U, TB/U, dan BB/PB secara independen. `Stunting`, `Gizi Kurang`, dan `Gizi Lebih` tidak boleh dianggap diagnosis atau indikasi rujukan otomatis.

### B. Perubahan

- Registrasi publik selalu membuat akun `orang_tua`; logout memakai POST + CSRF; operasi kader dibatasi ke admin/kader; admin route memakai autentikasi dan konteks Posyandu.
- ID balita, orang tua, dan pemeriksaan divalidasi terhadap Posyandu pengguna pada backend. Portal orang tua tetap memakai kepemilikan `user_id`.
- Nama balita disimpan; umur profil dihitung dari tanggal lahir. Tanggal pemeriksaan di luar usia 0–60 bulan, ukuran nonpositif, dan tinggi di luar jangkauan tabel 45–110 cm ditolak.
- Tiga kolom Z-score nullable ditambahkan melalui migrasi **aditif**. Pemeriksaan baru dan yang diedit menyimpan hasil kalkulator yang ada; dashboard, portal, riwayat JSON, dan laporan menampilkan nilai tersimpan. Nilai null ditampilkan sebagai tanda tidak tersedia, termasuk pada data lama. Tidak ada backfill atau perubahan data lama.
- Definisi label status terpusat di `StatusGizi`; `Gizi Baik` lama dibaca sebagai `Gizi Normal`. Dashboard dan cetak menghitung kategori normal yang sama. Tren stunting hanya menghitung `Stunting`. Penanda dashboard diganti menjadi “Perlu Ditinjau” berdasarkan catatan pemeriksaan di luar normal, tanpa instruksi rujukan otomatis.
- Penghapusan balita dengan riwayat layanan serta akun yang masih terhubung ke balita ditolak. Akun orang tua baru menerima password acak dan semua pengguna dapat mengganti password setelah login.
- Chart.js CDN pada halaman pemeriksaan dan portal dipatok ke versi 4.4.8; HTML dari respons riwayat di-escape sebelum dimasukkan ke tabel.
- Route usability memerlukan login dan daftar seluruh sesi memerlukan admin. Payload log/tugas dibatasi; query string pada URL halaman tidak lagi disimpan. Filter laporan divalidasi dan ekstraksi tahun memakai sintaks sesuai MySQL/SQLite.

### C. Pengujian

`php artisan test`: 11 lulus, 45 asersi. Skenario meliputi registrasi admin palsu, ID lintas Posyandu, kepemilikan anak, route privat, logout POST, password, tanggal tidak valid, penyimpanan Z-score, riwayat saat hapus, nama dan umur balita, serta akses daftar usability. `php artisan view:cache` berhasil; `git diff --check` berhasil. Pengujian memakai SQLite in-memory, bukan data pengguna.

### D. Risiko dan keterbatasan

- Hasil Z-score baru adalah **hasil algoritma median/SD yang sudah ada**, bukan hasil LMS WHO terverifikasi. Tabel BB/PB membulatkan tinggi ke sentimeter dan membatasi ke ujung tabel; prosedur PB/TB belum terpisah. Jangan memakai hasil ini untuk keputusan klinis sebelum sumber dan contoh acuan diverifikasi.
- Kolom status gabungan tetap tidak dapat menggambarkan setiap indeks. Migrasi terpisah untuk status per indeks memerlukan keputusan klasifikasi dan sumber acuan yang sah.
- Tabel referensi tetap terduplikasi di Blade. Chart.js versi 2 lokal masih dipakai dashboard; halaman tertentu memakai versi 4. Komponen Bootstrap 4 dan Tabler masih tercampur. Pengujian interaksi browser dan responsivitas belum dilakukan.
- Migrasi aditif belum dijalankan pada database aplikasi. Jalankan backup dan `php artisan migrate` saat deploy; data lama tetap memiliki Z-score null.
- Token laporan usability masih merupakan tautan akses laporan bagi pengguna yang login; pembatasan kepemilikan sesi dan isi catatan bebas belum diaudit mendalam. Akun lama dengan password bersama tidak diubah diam-diam; pemilik akun perlu menggantinya.
- Dampak pada laporan PA: definisi `Gizi Baik`/`Gizi Normal`, kategori status gabungan, aturan tindak lanjut, dan rumus Z-score pada catatan teknis perlu diperiksa bersama pembimbing atau rujukan resmi. Hasil uji akademis sebelumnya tidak diubah.

### E. Langkah selanjutnya

1. Dapatkan tabel LMS WHO yang sesuai indeks, jenis kelamin, umur dan jenis pengukuran beserta beberapa contoh hasil resmi; bandingkan terhadap kalkulator sebelum mengubah klasifikasi atau melakukan backfill.
2. Pisahkan status per indeks dan gunakan satu sumber tabel untuk PHP serta grafik; siapkan migrasi data lama yang dapat ditinjau tanpa kehilangan hasil historis.
3. Uji alur browser pada desktop/ponsel, rapikan pustaka UI/grafik, lalu selesaikan pencarian, pagination, dan CRUD layanan sesuai kebutuhan PA.
4. Audit modul usability, kebijakan penghapusan, dan seluruh endpoint privat; lanjutkan pengujian regresi setelah setiap perubahan.


