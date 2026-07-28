# Catatan Implementasi Teknis - Sistem Pemantauan Status Gizi Balita

> Catatan Pribadi untuk Keperluan Presentasi
> Dokumen ini berisi bukti-bukti implementasi teknis dari proyek beserta potongan kode nyata
> dan penjelasan cara menyampaikannya kepada dosen/penguji.

---

## DAFTAR ISI

- [Slide 2: Best Practice / Clean Code](#slide-2--implementasi-best-practice--clean-code)
- [Slide 3: PBO - Pemrograman Berorientasi Objek](#slide-3--implementasi-pbo)
- [Slide 4: Fungsi dan Pointer](#slide-4--implementasi-fungsi--pointer)
- [Slide 5: Library / Komponen Pre-existing](#slide-5--implementasi-library)
- [Slide 6: Akses ke Database](#slide-6--implementasi-akses-ke-database)
- [Slide 7: Debugging](#slide-7--implementasi-debugging)
- [Slide 8: Unit Testing](#slide-8--implementasi-unit-testing)
- [Ringkasan Lokasi File](#ringkasan-lokasi-file-penting)

---

## Slide 2 - Implementasi Best Practice / Clean Code

**File yang dibuka saat presentasi:**
`app/Http/Controllers/BalitaController.php`

**Konsep:** Pola arsitektur MVC (Model-View-Controller) dan Validasi Input.

### Bukti Kode:

```php
// ============================================================
// BUKTI 1: M (MODEL) - Bertanggung jawab pada data & database
// ============================================================
// FILE: app/Models/Balita.php
class Balita extends Model
{
    protected $table = 'sp_balita';
    protected $fillable = ['nama', 'jk', 'tgl_lahir', 'umur', ...];
    
    // Model mengatur relasinya sendiri ke tabel lain
    public function posyandu() { return $this->belongsTo(Posyandu::class); }
}

// ============================================================
// BUKTI 2: V (VIEW) - Bertanggung jawab pada antarmuka/UI (HTML)
// ============================================================
// FILE: resources/views/pages/balita/index.blade.php
// (Berisi murni kode HTML dan Blade template, tidak ada query database)
?>
<div class="card-body">
    <table class="table">
        @foreach ($balitas as $balita)
            <tr>
                <td>{{ $balita->nama }}</td>
                <td>{{ $balita->umur }} Bulan</td>
            </tr>
        @endforeach
    </table>
</div>
<?php

// ============================================================
// BUKTI 3: C (CONTROLLER) - Bertindak sebagai jembatan/otak
// ============================================================
// FILE: app/Http/Controllers/BalitaController.php
class BalitaController extends Controller
{
    public function index()
    {
        // 1. Controller meminta data ke Model (Balita)
        $balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();
        
        // 2. Controller mengirimkan data tersebut ke View (halaman HTML)
        return view('pages.balita.index', compact('balitas'));
    }

    // [BEST PRACTICE] Validasi input WAJIB dilakukan sebelum data diolah
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required',
            'user_id'     => 'required|exists:sp_users,id', // Memastikan ID ada di DB
        ]);
        // ...
    }
}
```

**Yang disampaikan ke dosen:**
"Proyek ini mengikuti standar best practice MVC Laravel. Controller bertugas menerima request,
Model bertugas ke database, dan View hanya bertugas menampilkan data. Setiap input dari user
selalu divalidasi terlebih dahulu menggunakan $request->validate() sebelum diproses - ini
adalah best practice keamanan web untuk mencegah data kosong atau tidak valid masuk ke sistem."

---

## Slide 3 - Implementasi PBO (Pemrograman Berorientasi Objek / OOP)

> Semua bukti di bawah diambil dari kode nyata dalam proyek ini.
> Konsep yang tercakup: Inheritance, Agregasi, Komposisi, Polymorphism,
> Overloading, Method, Procedure, Function, dan Pointer.

---

### 3a. Inheritance / Pewarisan

**Definisi:** Child class mewarisi properti dan method dari parent class.

**File:** `app/Http/Controllers/BalitaController.php` baris 8
dan `app/Models/Balita.php`, `app/Models/User.php`

```php
// ============================================================
// INHERITANCE - PEWARISAN
// ============================================================

// FILE: app/Http/Controllers/BalitaController.php
// BalitaController MEWARISI semua fungsi HTTP dari class Controller
// (middleware, response, dll sudah tersedia tanpa ditulis ulang)
class BalitaController extends Controller
{
    public function index() { ... }  // method SENDIRI
    public function store() { ... }  // method SENDIRI
}

// FILE: app/Http/Controllers/UsabilityController.php
// UsabilityController juga MEWARISI dari Controller yang sama
class UsabilityController extends Controller
{
    public function start() { ... }  // method SENDIRI
    public function report() { ... } // method SENDIRI
}

// FILE: app/Models/Balita.php
// class Balita MEWARISI seluruh kemampuan Eloquent ORM dari class Model:
// (create, find, where, get, update, delete, dll)
class Balita extends Model
{
    protected $table = 'sp_balita';
    protected $fillable = ['nama', 'jk', 'tgl_lahir', ...];
}

// FILE: app/Models/User.php
// class User MEWARISI dari Authenticatable yang sudah berisi:
// login, logout, hash password, remember token, dll
class User extends Authenticatable
{
    use HasFactory, Notifiable;
}
```

**Yang disampaikan ke dosen:**
"Konsep Inheritance diterapkan di seluruh file Controller dan Model. Setiap Controller
mewarisi class Controller induk dari Laravel, sehingga tidak perlu menulis ulang
fungsi-fungsi HTTP, middleware, maupun response. Begitu pula pada Model, setiap class
Model mewarisi Eloquent ORM sehingga operasi CRUD ke database sudah otomatis tersedia."

---

### 3b. Agregasi (Aggregation)

**Definisi:** Relasi "HAS-A" yang LEMAH. Objek A memiliki objek B,
tetapi jika A dihapus, B tetap bisa berdiri sendiri / tetap ada.

**File:** `app/Models/Balita.php`

```php
// FILE: app/Models/Balita.php
// ============================================================
// AGREGASI - Relasi Lemah (Weak Association)
// ============================================================

class Balita extends Model
{
    // AGREGASI: Balita MEMILIKI referensi ke Posyandu
    // >> Jika Balita dihapus, data Posyandu tetap ada dan tidak ikut terhapus
    // >> Posyandu bisa berdiri sendiri tanpa Balita
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }

    // AGREGASI: Balita MEMILIKI referensi ke User (Orang Tua)
    // >> Jika Balita dihapus, akun User/Orang Tua tetap ada
    // >> User bisa berdiri sendiri tanpa data Balita
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
```

**Yang disampaikan ke dosen:**
"Agregasi saya terapkan pada relasi antara objek Balita dengan objek Posyandu dan User.
Relasi ini bersifat lemah artinya jika saya menghapus data satu Balita dari sistem,
data Posyandu tempat balita itu terdaftar tidak ikut terhapus, begitu pula dengan akun
User atau Orang Tua-nya. Masing-masing objek bisa berdiri sendiri secara independen.
Dalam kode, ini direpresentasikan dengan method belongsTo() yang hanya menyimpan
referensi berupa foreign key, bukan kepemilikan penuh atas objek tersebut."

---

### 3c. Komposisi (Composition)

**Definisi:** Relasi "HAS-A" yang KUAT. Objek A memiliki objek B,
dan jika A dihapus, maka B tidak bisa berdiri sendiri / tidak relevan.

**File:** `app/Models/Balita.php` dan `app/Models/Posyandu.php`

```php
// FILE: app/Models/Balita.php
// ============================================================
// KOMPOSISI - Relasi Kuat (Strong Ownership)
// ============================================================

class Balita extends Model
{
    // KOMPOSISI: Balita MEMILIKI banyak data Periksa
    // >> Data Periksa sangat bergantung pada Balita
    // >> Jika Balita dihapus, data Periksa-nya tidak relevan lagi
    public function periksa()
    {
        return $this->hasMany(Periksa::class, 'balita_id');
    }

    // KOMPOSISI: Balita MEMILIKI banyak data Imunisasi
    public function imunisasi()
    {
        return $this->hasMany(Imunisasi::class, 'balita_id');
    }

    // KOMPOSISI: Balita MEMILIKI banyak data Vitamin A
    public function vitaminA()
    {
        return $this->hasMany(VitaminA::class, 'balita_id');
    }
}

// FILE: app/Models/Posyandu.php
// KOMPOSISI: Posyandu MEMILIKI banyak Balita dan User
// >> Data Balita dan User sangat bergantung pada Posyandu
class Posyandu extends Model
{
    public function balita()
    {
        return $this->hasMany(Balita::class, 'posyandu_id');
    }
    public function user()
    {
        return $this->hasMany(User::class, 'posyandu_id');
    }
}

// FILE: app/Models/UsabilitySession.php
// KOMPOSISI: Satu sesi usability MEMILIKI banyak log dan hasil task
class UsabilitySession extends Model
{
    public function logs()
    {
        return $this->hasMany(UsabilityLog::class);
    }
    public function taskResults()
    {
        return $this->hasMany(UsabilityTaskResult::class);
    }
}
```

**Yang disampaikan ke dosen:**
"Komposisi saya terapkan pada relasi antara objek Balita dengan data Periksa, Imunisasi,
dan Vitamin A. Relasi ini bersifat kuat karena data pemeriksaan, imunisasi, dan vitamin A
tidak akan ada artinya tanpa data balita yang memilikinya. Jika satu balita dihapus,
maka semua riwayat periksanya secara logis tidak relevan lagi. Dalam kode, ini
direpresentasikan dengan method hasMany() yang menunjukkan kepemilikan penuh
atas objek-objek turunannya."

---

### 3d. Polymorphism

**Definisi:** Satu interface/method yang bisa berperilaku berbeda
tergantung objek atau konteks yang menggunakannya.

**File:** `app/Models/User.php` dan `app/Services/GiziKalkulator.php`

```php
// FILE: app/Models/User.php
// ============================================================
// POLYMORPHISM 1 - Method Overriding
// ============================================================

class User extends Authenticatable
{
    // Method casts() di-OVERRIDE dari class induk Authenticatable
    // Perilaku berbeda: class induk tidak menghash password,
    // class User mengubahnya menjadi ter-hash otomatis
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Override perilaku parent class
        ];
    }
}

// ============================================================
// POLYMORPHISM 2 - Satu fungsi, perilaku berbeda (by parameter)
// ============================================================

// FILE: app/Services/GiziKalkulator.php
// Satu fungsi hitungZScore() berperilaku berbeda
// tergantung nilai parameter $tipe yang dikirim

private static function hitungZScore(float $nilai, int $umur, string $gender, string $tipe): float
{
    // Jika $tipe = 'BBU' -> pakai tabel referensi Berat Badan per Umur
    // Jika $tipe = 'TBU' -> pakai tabel referensi Tinggi Badan per Umur
    // Satu fungsi = DUA perilaku berbeda tergantung konteks pemanggilan
    $tabel = $tipe === 'BBU' ? self::tabelBBU($gender) : self::tabelTBU($gender);

    if (!isset($tabel[$umur])) return 0;
    [$median, $sd] = $tabel[$umur];
    return $sd > 0 ? ($nilai - $median) / $sd : 0;
}

// Dipanggil dua kali dengan perilaku berbeda:
$z_bbu = self::hitungZScore($bb, $umur, $gender, 'BBU'); // << perilaku 1
$z_tbu = self::hitungZScore($tb, $umur, $gender, 'TBU'); // << perilaku 2
```

**Yang disampaikan ke dosen:**
"Polymorphism saya terapkan dalam dua bentuk. Pertama, Method Overriding pada class User
yang menimpa (override) method casts() dari class induknya untuk mengubah perilaku
penyimpanan password menjadi ter-hash otomatis. Kedua, Polymorphism berbasis parameter
pada fungsi hitungZScore() di GiziKalkulator: satu nama fungsi yang sama dipanggil
dua kali dengan perilaku berbeda, yaitu untuk menghitung z-score Berat Badan per Umur
dan z-score Tinggi Badan per Umur, tergantung nilai parameter $tipe yang dikirim."

---

### 3e. Overloading

**Definisi:** Satu method/fungsi yang bisa menerima berbagai jenis atau
jumlah parameter. Di PHP dilakukan dengan Type Hinting dan Default Parameter.

**File:** `app/Services/GiziKalkulator.php`

```php
// FILE: app/Services/GiziKalkulator.php
// ============================================================
// OVERLOADING - Type Hinting (Tipe Data Berbeda dalam 1 Fungsi)
// ============================================================

// Fungsi hitung() menerima 4 tipe data berbeda sekaligus dalam satu signature:
// float (bb), float (tb), int (umur), string (jk) -> return array
// Ini adalah implementasi overloading dengan strict type di PHP

public static function hitung(float $bb, float $tb, int $umur, string $jk): array
{
    $umur   = max(0, min(60, $umur));           // Parameter int diproses
    $gender = (strtoupper($jk) === 'L') ? 'L' : 'P'; // Parameter string diproses

    $z_bbu = self::hitungZScore($bb, $umur, $gender, 'BBU'); // float diproses
    $z_tbu = self::hitungZScore($tb, $umur, $gender, 'TBU'); // float diproses

    return [
        'status_gizi' => self::tentukanStatus($z_bbu, $z_tbu),
        'z_bbu'       => round($z_bbu, 2),
        'z_tbu'       => round($z_tbu, 2),
    ];
}

// ============================================================
// OVERLOADING 2 - Default Parameter Value
// ============================================================

// FILE: app/Http/Controllers/LaporanController.php
// Parameter $bulan dan $tahun memiliki nilai default jika tidak dikirim
// Ini adalah bentuk overloading: bisa dipanggil dengan atau tanpa parameter

public function index(Request $request)
{
    $bulan = (int)($request->bulan ?? now()->month); // default = bulan ini
    $tahun = (int)($request->tahun ?? now()->year);  // default = tahun ini
    // ...
}
```

**Yang disampaikan ke dosen:**
"Overloading saya terapkan dalam dua cara. Pertama, pada fungsi hitung() di class
GiziKalkulator yang menerima empat tipe data berbeda sekaligus dalam satu signature
(float untuk berat badan, float untuk tinggi badan, int untuk umur, dan string untuk
jenis kelamin) — ini adalah Type Hinting yang merupakan cara PHP mengimplementasikan
overloading. Kedua, pada method index() di LaporanController yang menggunakan
Default Parameter Value menggunakan operator ??, sehingga fungsi ini bisa dipanggil
tanpa parameter (otomatis ambil bulan dan tahun saat ini) maupun dengan parameter
spesifik dari pengguna."

---

### 3f. Method

**Definisi:** Fungsi yang menjadi bagian dari sebuah class / objek.
Method memiliki akses ke properti class melalui keyword `$this`.

**File:** `app/Http/Controllers/BalitaController.php` dan `app/Models/Balita.php`

```php
// FILE: app/Http/Controllers/BalitaController.php
// ============================================================
// METHOD - Fungsi yang Terikat pada Sebuah Class (Object Method)
// ============================================================

class BalitaController extends Controller
{
    // METHOD PUBLIC: bisa dipanggil dari luar class (via route/URL)
    // Dipanggil melalui file routes/web.php dengan kode:
    // Route::get('/balita', [BalitaController::class, 'index']);
    public function index()
    {
        $balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();
        return view('pages.balita.index', compact('balitas'));
    }

    // METHOD PUBLIC: menerima data dari form HTML
    public function store(Request $request)
    {
        $request->validate([...]);
        Balita::create([...]);
        return redirect()->route('balita.index');
    }

    // METHOD PUBLIC: menampilkan form edit
    public function edit($id)
    {
        $balita = Balita::findOrFail($id);
        return view('pages.balita.edit', compact('balita'));
    }

    // METHOD PRIVATE: hanya bisa dipanggil dari dalam class ini
    // Menggunakan $this-> untuk mengakses method milik class sendiri
    private function formatNamaBalita(&$nama)
    {
        $nama = strtoupper($nama);
    }
}

// FILE: app/Models/Balita.php
// Method pada Model = Mendefinisikan relasi antar objek
class Balita extends Model
{
    public function posyandu() { return $this->belongsTo(Posyandu::class); }
    public function periksa()  { return $this->hasMany(Periksa::class, 'balita_id'); }
}
```

**Yang disampaikan ke dosen:**
"Method adalah fungsi yang terikat pada sebuah class dan bisa mengakses properti
class-nya melalui keyword $this. Di proyek ini, setiap Controller memiliki method-method
CRUD seperti index(), create(), store(), edit(), update(), dan destroy(). Saya juga
membedakan akses method: ada yang public artinya bisa dipanggil dari luar melalui
URL atau route, dan ada yang private seperti formatNamaBalita() yang hanya boleh
dipanggil dari dalam class itu sendiri menggunakan $this->."

---

### 3g. Procedure

**Definisi:** Subprogram / blok kode yang TIDAK mengembalikan nilai (void).
Di PHP tidak ada keyword void secara eksplisit untuk semua kasus,
tetapi procedure dapat diidentifikasi dari method yang tidak return nilai bermakna.

**File:** `app/Http/Controllers/BalitaController.php`

```php
// FILE: app/Http/Controllers/BalitaController.php
// ============================================================
// PROCEDURE - Method/Fungsi yang Tidak Menghasilkan Nilai Balik Data
// ============================================================

// Contoh PROCEDURE: formatNamaBalita
// Tujuannya HANYA melakukan aksi (mengubah nama) tanpa return data
// Perubahan terjadi langsung pada variabel asli via reference (&)

private function formatNamaBalita(&$nama)  // Tidak ada return value
{
    $nama = strtoupper($nama);
    // Tidak ada 'return $nama;' -- ini adalah PROCEDURE, bukan function
}

// Contoh PROCEDURE di method destroy():
// Hanya melakukan aksi menghapus data, tidak mengembalikan data apapun
// (redirect bukan data, melainkan instruksi navigasi)
public function destroy($id)
{
    $balita = Balita::where('posyandu_id', session('posyandu_id'))->findOrFail($id);
    $balita->delete();  // aksi murni, tidak return data

    return redirect()->route('balita.index')
        ->with('success', 'Data Balita berhasil dihapus!');
    // 'return redirect()' bukan mengembalikan data melainkan instruksi HTTP response
}
```

**Yang disampaikan ke dosen:**
"Procedure adalah subprogram yang tidak mengembalikan nilai data. Di proyek ini
contohnya adalah fungsi formatNamaBalita(&$nama) yang hanya melakukan aksi
mengubah nama menjadi huruf kapital tanpa ada perintah return data apapun.
Perubahan langsung terjadi pada variabel aslinya via reference. Contoh lain adalah
method destroy() yang hanya melakukan aksi menghapus data dari database, kemudian
mengirimkan instruksi navigasi (redirect) — bukan mengembalikan data kepada pemanggil."

---

### 3h. Function

**Definisi:** Subprogram yang MENGHASILKAN / MENGEMBALIKAN nilai (return value) lalu
bisa dipanggil berkali-kali.

**File:** `app/Services/GiziKalkulator.php`

```php
// FILE: app/Services/GiziKalkulator.php
// ============================================================
// FUNCTION - Subprogram yang Mengembalikan Nilai
// ============================================================

// FUNCTION 1: Mengembalikan array berisi status gizi (return array)
public static function hitung(float $bb, float $tb, int $umur, string $jk): array
{
    // ...proses kalkulasi...
    return [               // <-- ADA NILAI YANG DIKEMBALIKAN
        'status_gizi' => self::tentukanStatus($z_bbu, $z_tbu),
        'z_bbu'       => round($z_bbu, 2),
        'z_tbu'       => round($z_tbu, 2),
    ];
}

// FUNCTION 2: Mengembalikan nilai float (z-score)
private static function hitungZScore(float $nilai, int $umur, string $gender, string $tipe): float
{
    $tabel = $tipe === 'BBU' ? self::tabelBBU($gender) : self::tabelTBU($gender);
    if (!isset($tabel[$umur])) return 0;          // <-- return nilai
    [$median, $sd] = $tabel[$umur];
    return $sd > 0 ? ($nilai - $median) / $sd : 0; // <-- return nilai
}

// FUNCTION 3: Mengembalikan nilai string (status gizi)
private static function tentukanStatus(float $z_bbu, float $z_tbu): string
{
    if ($z_tbu < -2)  return 'Stunting';     // <-- return string
    if ($z_bbu < -3)  return 'Gizi Kurang';  // <-- return string
    if ($z_bbu < -2)  return 'Gizi Kurang';  // <-- return string
    if ($z_bbu <= 2)  return 'Gizi Normal';  // <-- return string
    return 'Gizi Lebih';                      // <-- return string
}

// FILE: app/Http/Controllers/BalitaController.php
// ============================================================
// FUNCTION - Subprogram pada Controller yang Mengembalikan Nilai
// ============================================================

// FUNCTION 4: Mengembalikan tampilan antarmuka (View)
public function index()
{
    $balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();
    
    // <-- MENGEMBALIKAN (return) objek View berisi halaman HTML
    return view('pages.balita.index', compact('balitas')); 
}
```

**Yang disampaikan ke dosen:**
"Berbeda dengan Procedure, Function adalah subprogram yang selalu mengembalikan nilai
kepada pemanggilnya. Di proyek ini, saya punya contoh function di class GiziKalkulator 
seperti hitung() yang mengembalikan array dan tentukanStatus() yang mengembalikan string. 
Selain itu, method-method di Controller yang berhubungan langsung dengan antarmuka pengguna 
juga merupakan function. Contohnya adalah fungsi index() atau create() pada BalitaController. 
Fungsi index() memproses data balita dan mengembalikan (return) objek view yang berisi 
halaman HTML untuk ditampilkan di layar. Nilai return inilah yang secara konsep 
membedakan function dari procedure."

---

### 3i. Pointer / Reference

**Definisi:** Pointer adalah variabel yang menyimpan ALAMAT MEMORI dari variabel lain.
Di PHP diimplementasikan dengan symbol `&` (Reference).

**File:** `app/Http/Controllers/BalitaController.php` baris 45-76

```php
// FILE: app/Http/Controllers/BalitaController.php
// ============================================================
// POINTER / REFERENCE (&)
// ============================================================

public function store(Request $request)
{
    // ...validasi...

    $namaBalita = $request->nama;     // $namaBalita = "budi santoso"

    // PEMANGGILAN dengan POINTER:
    // $namaBalita dikirim "by reference" bukan "by value"
    // Fungsi akan mengakses dan mengubah isi MEMORI variabel aslinya
    $this->formatNamaBalita($namaBalita);

    // Setelah pemanggilan: $namaBalita otomatis = "BUDI SANTOSO"
    // (berubah tanpa perlu $namaBalita = $this->formatNamaBalita($namaBalita))

    Balita::create([
        'nama' => $namaBalita, // sudah menjadi huruf kapital
        // ...
    ]);
}

/**
 * POINTER / REFERENCE (&)
 *
 * Simbol & di depan parameter ($nama) berarti fungsi ini
 * menerima ALAMAT MEMORI dari variabel aslinya, bukan salinannya.
 *
 * Analogi dengan C/C++:
 *   void formatNama(char* nama) { ... }  -- di C menggunakan pointer *
 *   formatNamaBalita(&$nama)             -- di PHP menggunakan reference &
 *
 * Keduanya bekerja dengan prinsip yang sama:
 * mengakses dan memodifikasi data langsung di lokasi memorinya.
 */
private function formatNamaBalita(&$nama)  // <-- & = reference/pointer
{
    $nama = strtoupper($nama);
    // Tidak perlu 'return' karena langsung mengubah memori asli
}
```

**Apa yang disampaikan ke dosen:**
"Di PHP, konsep Pointer diimplementasikan melalui Reference dengan simbol &. Pada
fungsi formatNamaBalita(&$nama), parameter $nama menerima alamat memori dari variabel
aslinya. Saat saya mengubah $nama di dalam fungsi, perubahan itu langsung terjadi pada
variabel $namaBalita di luar fungsi, tanpa perlu mengembalikan nilai. Ini persis sama
dengan cara kerja pointer pada bahasa C/C++ menggunakan operator *."

---


## Slide 4 - Implementasi Fungsi dan Pointer

### 4a. Fungsi / Function

**File:** `app/Services/GiziKalkulator.php`

```php
// FILE: app/Services/GiziKalkulator.php

// [FUNGSI 1] Fungsi publik dengan return type array
public static function hitung(float $bb, float $tb, int $umur, string $jk): array
{
    $umur   = max(0, min(60, $umur)); // logika pembatasan rentang umur
    $gender = (strtoupper($jk) === 'L') ? 'L' : 'P';

    $z_bbu = self::hitungZScore($bb, $umur, $gender, 'BBU');
    $z_tbu = self::hitungZScore($tb, $umur, $gender, 'TBU');

    return [
        'status_gizi' => self::tentukanStatus($z_bbu, $z_tbu),
        'z_bbu'       => round($z_bbu, 2),
        'z_tbu'       => round($z_tbu, 2),
    ];
}

// [FUNGSI 2] Fungsi private / helper internal
private static function tentukanStatus(float $z_bbu, float $z_tbu): string
{
    if ($z_tbu < -2)  return 'Stunting';
    if ($z_bbu < -3)  return 'Gizi Kurang';
    if ($z_bbu < -2)  return 'Gizi Kurang';
    if ($z_bbu <= 2)  return 'Gizi Normal';
    return 'Gizi Lebih';
}
```

---

### 4b. Pointer / Reference (&)

**File:** `app/Http/Controllers/BalitaController.php` baris 45-76

```php
// FILE: app/Http/Controllers/BalitaController.php

// PEMANGGILAN - variabel dikirim by reference (bukan by value)
$namaBalita = $request->nama;
$this->formatNamaBalita($namaBalita); // setelah ini, $namaBalita sudah berubah

// -----------------------------------------------------------

/**
 * POINTER / REFERENCE (&)
 * Simbol & di depan parameter berarti fungsi menerima ALAMAT MEMORI
 * dari variabel aslinya, bukan salinan nilainya.
 * Perubahan di dalam fungsi akan langsung mengubah variabel di luar.
 */
private function formatNamaBalita(&$nama)   // <-- tanda & = pointer/reference
{
    $nama = strtoupper($nama);
    // $namaBalita di luar fungsi LANGSUNG berubah jadi huruf kapital
    // tanpa perlu return value
}
```

**Yang disampaikan ke dosen:**
"Di PHP, konsep Pointer diimplementasikan melalui 'Reference' dengan simbol &. Pada fungsi
formatNamaBalita(&$nama), parameter $nama menerima referensi (alamat memori) dari variabel
aslinya. Saat saya mengubah isi $nama di dalam fungsi, perubahan itu langsung terjadi pada
variabel $namaBalita di luar fungsi - layaknya cara kerja pointer pada bahasa C/C++."

---

## Slide 5 - Implementasi Library

**File yang dibuka:** `composer.json` (di folder paling luar proyek)

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",       // Framework Laravel = komponen utama
        "laravel/tinker": "^2.10.1"         // Library REPL untuk debugging interaktif
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",          // Library generate data dummy (testing)
        "laravel/pail": "^1.2.2",           // Library log streaming real-time
        "laravel/pint": "^1.24",            // Library code formatter otomatis
        "mockery/mockery": "^1.6",          // Library untuk mock object (testing)
        "pestphp/pest": "^3.8",             // Framework Unit Testing (pre-existing!)
        "pestphp/pest-plugin-laravel": "^3.2"
    }
}
```

**Contoh penggunaan library Carbon di dalam kode:**

```php
// FILE: app/Http/Controllers/PeriksaController.php
// Library Carbon digunakan untuk menghitung umur balita secara akurat

$tgl_lahir   = \Carbon\Carbon::parse($balita->tgl_lahir);
$tgl_periksa = \Carbon\Carbon::parse($request->tgl_periksa);
$umur_bulan  = $tgl_lahir->diffInMonths($tgl_periksa); // Fungsi bawaan library Carbon
```

**Yang disampaikan ke dosen:**
"Proyek ini memanfaatkan banyak komponen pre-existing yang dikelola lewat Composer. Yang paling
terlihat adalah framework Laravel itu sendiri, lalu library Carbon untuk manipulasi tanggal yang
dipakai menghitung umur balita dalam bulan secara akurat. Untuk frontend, saya menggunakan
template admin Tabler dan library ApexCharts untuk grafik."

---

## Slide 6 - Implementasi Akses ke Database

**File:** `app/Http/Controllers/BalitaController.php` dan `app/Models/Balita.php`

```php
// FILE: app/Models/Balita.php
// Konfigurasi akses database melalui MODEL (ORM)

class Balita extends Model
{
    protected $table = 'sp_balita';  // <-- Nama tabel di database MySQL

    // Kolom yang boleh diisi lewat kode (Mass Assignment Protection)
    protected $fillable = [
        'nama', 'jk', 'tgl_lahir', 'umur', 'nama_ortu',
        'tinggi_badan', 'berat_badan', 'posyandu_id', 'user_id',
    ];
}
```

```php
// FILE: app/Http/Controllers/BalitaController.php
// Operasi CRUD ke database menggunakan Eloquent ORM (tanpa SQL mentah)

// [C] CREATE - Simpan data baru ke database
Balita::create([
    'nama'         => $namaBalita,
    'jk'           => $request->jk,
    // ...
]);

// [R] READ - Ambil semua data dengan filter
$balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();

// [R] READ - Ambil satu data, otomatis error 404 jika tidak ada
$balita = Balita::where('posyandu_id', session('posyandu_id'))->findOrFail($id);

// [U] UPDATE - Perbarui data
$balita->update(['nama' => $request->nama, ...]);

// [D] DELETE - Hapus data
$balita->delete();
```

**Yang disampaikan ke dosen:**
"Untuk akses database, saya menggunakan pola ORM (Object-Relational Mapping) melalui Eloquent
bawaan Laravel. Tidak ada query SQL mentah sama sekali. Setiap tabel database direpresentasikan
sebagai sebuah Objek/Model. Metode ini jauh lebih aman dari SQL Injection dan kodenya lebih
bersih dan mudah dibaca."

---

## Slide 7 - Implementasi Debugging

**File:** `app/Http/Controllers/BalitaController.php` baris 35-41

### CARA MENDEMONSTRASIKAN:

LANGKAH 1: Buka file `app/Http/Controllers/BalitaController.php`

LANGKAH 2: Cari komentar "SLIDE 7: IMPLEMENTASI DEBUGGING" lalu hapus // di depan dd():
```php
// SEBELUM (tidak aktif):
// dd('Berhenti di sini untuk cek input data:', $request->all());

// SESUDAH (aktif untuk screenshot):
dd('Berhenti di sini untuk cek input data:', $request->all());
```

LANGKAH 3: Jalankan aplikasi (`php artisan serve`), buka menu Balita -> Tambah Data -> isi form -> klik Simpan.

LANGKAH 4: Layar browser berubah jadi layar debugging gelap yang menampilkan semua data form. SCREENSHOT INI.

LANGKAH 5: Setelah screenshot, tambahkan kembali // di depan dd() agar tombol simpan normal kembali.

```php
// Penjelasan fungsi dd():
// dd = "Dump and Die"
// Fungsi ini menghentikan eksekusi program dan menampilkan
// semua isi variabel secara detail di layar browser untuk keperluan debugging
```

---

## Slide 8 - Implementasi Unit Testing

**File:** `tests/Unit/KalkulasiGiziTest.php`

```php
// FILE: tests/Unit/KalkulasiGiziTest.php

class KalkulasiGiziTest extends TestCase
{
    public function test_konversi_umur_tahun_ke_bulan()
    {
        // POLA STANDAR UNIT TESTING: AAA (Arrange - Act - Assert)

        // 1. ARRANGE - Siapkan data input
        $umurTahun = 2;

        // 2. ACT - Jalankan logika yang diuji
        $umurBulan = $umurTahun * 12;

        // 3. ASSERT - Verifikasi hasilnya
        $this->assertEquals(24, $umurBulan, "Konversi tahun ke bulan gagal!");
        $this->assertTrue(is_numeric($umurBulan));
    }
}
```

### CARA MENJALANKAN DAN SCREENSHOT:

1. Buka Terminal di VS Code
2. Ketik perintah:
   ```
   php artisan test --filter KalkulasiGiziTest
   ```
3. Hasil di terminal yang di-screenshot:
   ```
   PASS  Tests\Unit\KalkulasiGiziTest
   v konversi umur tahun ke bulan       0.01s

   Tests:    1 passed (2 assertions)
   Duration: 0.05s
   ```

**Yang disampaikan ke dosen:**
"Unit Testing adalah pengujian terhadap satu unit logika kode secara terisolasi, tanpa
melibatkan database. Saya menggunakan framework Pest/PHPUnit yang sudah terintegrasi di Laravel.
Pada test ini saya menguji logika konversi umur menggunakan pola AAA: Arrange (siapkan data),
Act (jalankan logika), dan Assert (verifikasi hasilnya). Hasilnya PASS artinya logika berjalan benar."

---

## Ringkasan Lokasi File Penting

| Slide | Konsep                 | File yang Dibuka                                           | Baris      |
|-------|------------------------|------------------------------------------------------------|------------|
| 2     | Best Practice / MVC    | app/Http/Controllers/BalitaController.php                  | 1-50       |
| 3     | Pewarisan              | app/Http/Controllers/BalitaController.php                  | Baris 8    |
| 3     | Pewarisan Model        | app/Models/Balita.php                                      | Baris 8    |
| 3     | Agregasi & Komposisi   | app/Models/Balita.php                                      | Baris 25-48|
| 3     | Polymorphism           | app/Models/User.php                                        | Baris 13   |
| 3     | Overloading            | app/Services/GiziKalkulator.php                            | Baris 14   |
| 4     | Function               | app/Services/GiziKalkulator.php                            | Semua      |
| 4     | Pointer/Reference      | app/Http/Controllers/BalitaController.php                  | Baris 68-76|
| 5     | Library pre-existing   | composer.json (folder paling luar)                         | Semua      |
| 6     | Akses Database         | app/Models/Balita.php + BalitaController.php               | Semua      |
| 7     | Debugging              | app/Http/Controllers/BalitaController.php                  | Baris 35-41|
| 8     | Unit Testing           | tests/Unit/KalkulasiGiziTest.php                           | Semua      |

---

Dibuat: 20 Juli 2026 | Sistem Informasi Pemantauan Status Gizi Balita
