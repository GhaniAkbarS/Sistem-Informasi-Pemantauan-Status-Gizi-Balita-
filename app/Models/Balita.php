<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    protected $table = 'sp_balita';

    protected $fillable = [
        'nama',
        'tgl_lahir',
        'umur',
        'nama_ortu',
        'tinggi_badan',
        'berat_badan',
        'posyandu_id',
    ];

    // relasi 1 balita 1 posyandu
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }
}
