<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    protected $table = 'sp_periksa';

    protected $fillable = [
        'balita_id',
        'tgl_lahir',
        'umur_bulan',
        'nama_ortu',
        'tanggal_periksa',
        'berat_badan',
        'tinggi_badan',
        'jenis_pengukuran',
        'status_gizi',
    ];

    public function balita()
    {
        return $this->belongsTo(Balita::class, 'balita_id');
    }
}
