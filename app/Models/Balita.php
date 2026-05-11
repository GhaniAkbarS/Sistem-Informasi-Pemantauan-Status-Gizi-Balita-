<?php

namespace App\Models;
use App\Models\User;
use App\Models\Periksa;
use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    protected $table = 'sp_balita';

    protected $fillable = [
        'nama',
        'jk',
        'tgl_lahir',
        'umur',
        'nama_ortu',
        'tinggi_badan',
        'berat_badan',
        'posyandu_id',
        'user_id',
    ];

    // relasi 1 balita 1 posyandu
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }

    public function periksa()
    {
        return $this->hasMany(Periksa::class, 'balita_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vitaminA()
    {
        return $this->hasMany(VitaminA::class, 'balita_id');
    }

    public function imunisasi()
    {
        return $this->hasMany(Imunisasi::class, 'balita_id');
    }
}
