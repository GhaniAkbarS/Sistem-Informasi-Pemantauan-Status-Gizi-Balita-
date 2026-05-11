<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitaminA extends Model
{
    protected $table = 'sp_vitamin_a';

    protected $fillable = [
        'balita_id',
        'jenis_kapsul',
        'bulan_pemberian',
        'tahun_pemberian',
        'tanggal_pemberian',
    ];

    public function balita()
    {
        return $this->belongsTo(Balita::class, 'balita_id');
    }
}
