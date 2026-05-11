<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imunisasi extends Model
{
    protected $table = 'sp_imunisasi';

    protected $fillable = [
        'balita_id',
        'nama_vaksin',
        'tanggal_pemberian',
        'keterangan',
    ];

    public function balita()
    {
        return $this->belongsTo(Balita::class, 'balita_id');
    }

    public function imunisasi()
    {
        return $this->hasMany(Imunisasi::class, 'balita_id');
    }
}
