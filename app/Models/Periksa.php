<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    protected $table = 'sp_periksa';

    protected $fillable = [
        'id_balita',
        'tgl_periksa',
        'umur',
        'tinggi_badan',
        'berat_badan',
        'imt',
        'status_gizi',
    ];
}
