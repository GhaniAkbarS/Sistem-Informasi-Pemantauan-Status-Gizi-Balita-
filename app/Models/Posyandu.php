<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    protected $table = 'sp_posyandu';
    protected $fillable = [
        'nama_posyandu',
        'alamat',
        'kelurahan',
        'kecamatan',
    ];

    // 1 posyandu bisa banyak user
    public function user()
    {
        return $this->hasMany(User::class, 'posyandu_id');
    }

    // 1 posyandu bisa banyak balita
    public function balita()
    {
        return $this->hasMany(Balita::class, 'posyandu_id');
    }
}
