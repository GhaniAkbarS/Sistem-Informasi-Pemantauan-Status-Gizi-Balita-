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
    ];
}
