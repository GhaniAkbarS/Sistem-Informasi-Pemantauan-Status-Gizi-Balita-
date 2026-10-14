<?php

use App\Models\Balita;
use App\Models\Periksa;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function fixtureUser(string $role, Posyandu $posyandu): User
{
    return User::create([
        'name' => $role,
        'username' => $role . $posyandu->id,
        'password' => 'testing-password-123',
        'role' => $role,
        'posyandu_id' => $posyandu->id,
    ]);
}

function fixtureBalita(Posyandu $posyandu, User $parent): Balita
{
    return Balita::create([
        'nama' => 'Anak Uji', 'jk' => 'L', 'tgl_lahir' => '2025-01-01',
        'umur' => 12, 'nama_ortu' => $parent->name,
        'tinggi_badan' => 75.7, 'berat_badan' => 9.6,
        'user_id' => $parent->id, 'posyandu_id' => $posyandu->id,
    ]);
}

test('registrasi publik hanya membuat akun posyandu atau kader', function () {
    $posyandu = Posyandu::create(['nama_posyandu' => 'Pos A']);
    $this->get('/register')->assertOk()->assertSee('Petugas/kader')->assertSee('Posyandu');

    foreach (['admin', 'kader'] as $role) {
        $this->post('/register', [
            'name' => 'Pendaftar', 'username' => 'pendaftar_' . $role,
            'password' => 'password-aman-123', 'role' => $role,
            'posyandu_id' => $posyandu->id,
        ])->assertRedirect('/login');
        expect(User::where('username', 'pendaftar_' . $role)->first()->role)->toBe($role);
    }

    foreach (['orang_tua', 'lainnya'] as $role) {
        $this->post('/register', [
            'name' => 'Pendaftar', 'username' => 'ditolak_' . $role,
            'password' => 'password-aman-123', 'role' => $role,
            'posyandu_id' => $posyandu->id,
        ])->assertSessionHasErrors('role');
        expect(User::where('username', 'ditolak_' . $role)->exists())->toBeFalse();
    }
});

test('kader membuat akun orang tua dengan password awal yang sama', function () {
    $posyandu = Posyandu::create(['nama_posyandu' => 'Pos A']);
    $kader = fixtureUser('kader', $posyandu);

    $this->actingAs($kader)->post('/orang-tua/store', ['name' => 'Siti Aminah'])
        ->assertRedirect('/orang-tua/create')
        ->assertSessionHas('success_ortu.password', 'posyandu123');

    $parent = User::where('username', 'sitiaminah')->firstOrFail();
    expect($parent->role)->toBe('orang_tua');
    expect($parent->posyandu_id)->toBe($posyandu->id);
    expect(\Illuminate\Support\Facades\Hash::check('posyandu123', $parent->password))->toBeTrue();
});

test('kader tidak dapat menulis pemeriksaan dan layanan pada posyandu lain', function () {
    $a = Posyandu::create(['nama_posyandu' => 'Pos A']);
    $b = Posyandu::create(['nama_posyandu' => 'Pos B']);
    $kader = fixtureUser('kader', $a);
    $parent = fixtureUser('orang_tua', $b);
    $anak = fixtureBalita($b, $parent);

    $this->actingAs($kader)->post('/periksa/store', [
        'balita_id' => $anak->id, 'tgl_periksa' => '2026-01-01',
        'berat_badan' => 9.6, 'tinggi_badan' => 75.7,
    ])->assertSessionHasErrors('balita_id');
    $this->actingAs($kader)->post('/imunisasi/store', [
        'balita_id' => $anak->id, 'nama_vaksin' => 'Uji', 'tanggal_pemberian' => '2026-01-01',
    ])->assertSessionHasErrors('balita_id');
    expect(Periksa::count())->toBe(0);
});

test('pemeriksaan menyimpan z-score dan melindungi perubahan antar posyandu', function () {
    $a = Posyandu::create(['nama_posyandu' => 'Pos A']);
    $b = Posyandu::create(['nama_posyandu' => 'Pos B']);
    $kaderA = fixtureUser('kader', $a);
    $kaderB = fixtureUser('kader', $b);
    $anak = fixtureBalita($a, fixtureUser('orang_tua', $a));

    $this->actingAs($kaderA)->post('/periksa/store', [
        'balita_id' => $anak->id, 'tgl_periksa' => '2026-01-01',
        'berat_badan' => 9.6, 'tinggi_badan' => 75.7,
    ])->assertRedirect('/periksa');
    $record = Periksa::firstOrFail();
    expect($record->z_bbu)->not->toBeNull();
    expect($record->z_tbu)->not->toBeNull();
    $this->actingAs($kaderA)->get('/')->assertOk()->assertSee('Gizi Normal');
    $this->actingAs($kaderA)->get('/laporan/cetak?bulan=1&tahun=2026')->assertOk()->assertSee('Gizi Normal');
    $this->actingAs($kaderA)->get('/laporan?bulan=1&tahun=2026')->assertOk();

    $this->actingAs($kaderB)->put('/periksa/' . $record->id, [
        'balita_id' => $anak->id, 'tgl_periksa' => '2026-01-01',
        'berat_badan' => 9.6, 'tinggi_badan' => 75.7,
    ])->assertSessionHasErrors('balita_id');
    $this->actingAs($kaderB)->delete('/periksa/' . $record->id)->assertNotFound();
});

test('orang tua tidak dapat membuka data anak lain atau halaman kader', function () {
    $posyandu = Posyandu::create(['nama_posyandu' => 'Pos A']);
    $parentA = fixtureUser('orang_tua', $posyandu);
    $parentB = User::create([
        'name' => 'Ortu B', 'username' => 'ortub', 'password' => 'testing-password-123',
        'role' => 'orang_tua', 'posyandu_id' => $posyandu->id,
    ]);
    $anak = fixtureBalita($posyandu, $parentB);
    $this->actingAs($parentA)->get('/portal/anak/' . $anak->id)->assertNotFound();
    $this->actingAs($parentA)->get('/balita')->assertForbidden();
    $this->get('/users')->assertForbidden();
});

test('halaman privat memerlukan login dan logout hanya menerima POST', function () {
    $this->get('/balita')->assertRedirect('/login');
    $this->get('/logout')->assertMethodNotAllowed();
});

test('password dapat diganti hanya dengan password saat ini', function () {
    $posyandu = Posyandu::create(['nama_posyandu' => 'Pos A']);
    $parent = fixtureUser('orang_tua', $posyandu);
    $this->actingAs($parent)->put('/akun/password', [
        'current_password' => 'salah', 'password' => 'password-baru-123',
        'password_confirmation' => 'password-baru-123',
    ])->assertSessionHasErrors('current_password');
    $this->actingAs($parent)->put('/akun/password', [
        'current_password' => 'testing-password-123', 'password' => 'password-baru-123',
        'password_confirmation' => 'password-baru-123',
    ])->assertSessionHas('success');
    expect(\Illuminate\Support\Facades\Hash::check('password-baru-123', $parent->fresh()->password))->toBeTrue();
});

test('tanggal pemeriksaan sebelum kelahiran ditolak dan riwayat mencegah penghapusan balita', function () {
    $posyandu = Posyandu::create(['nama_posyandu' => 'Pos A']);
    $kader = fixtureUser('kader', $posyandu);
    $anak = fixtureBalita($posyandu, fixtureUser('orang_tua', $posyandu));
    $this->actingAs($kader)->post('/periksa/store', [
        'balita_id' => $anak->id, 'tgl_periksa' => '2024-12-31',
        'berat_badan' => 9.6, 'tinggi_badan' => 75.7,
    ])->assertSessionHasErrors('tgl_periksa');
    $this->actingAs($kader)->post('/periksa/store', [
        'balita_id' => $anak->id, 'tgl_periksa' => '2026-01-01',
        'berat_badan' => 9.6, 'tinggi_badan' => 75.7,
    ])->assertRedirect('/periksa');
    $this->actingAs($kader)->delete('/balita/' . $anak->id)->assertSessionHas('error');
    expect(Balita::find($anak->id))->not->toBeNull();
});

test('nama dan umur balita berasal dari input tervalidasi dan tanggal lahir', function () {
    $posyandu = Posyandu::create(['nama_posyandu' => 'Pos A']);
    $parent = fixtureUser('orang_tua', $posyandu);
    $kader = fixtureUser('kader', $posyandu);
    $this->actingAs($kader)->post('/balita/store', [
        'nama' => 'Anak Baru', 'jk' => 'P', 'tgl_lahir' => today()->subMonths(10)->toDateString(),
        'umur' => 1, 'tinggi_badan' => 70, 'berat_badan' => 8,
        'user_id' => $parent->id,
    ])->assertRedirect('/balita');
    $anak = Balita::where('nama', 'ANAK BARU')->firstOrFail();
    expect($anak->umur)->toBe(10);
});

test('daftar sesi usability hanya dapat dibuka admin', function () {
    $posyandu = Posyandu::create(['nama_posyandu' => 'Pos A']);
    $this->get('/usability')->assertRedirect('/login');
    $this->actingAs(fixtureUser('kader', $posyandu))->get('/usability')->assertForbidden();
});
