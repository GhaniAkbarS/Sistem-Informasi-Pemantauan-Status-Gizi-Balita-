<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsabilitySession extends Model
{
    protected $fillable = [
        'nama_penguji', 'peran', 'mulai_at', 'selesai_at',
        'durasi_detik', 'token',
    ];

    protected $casts = [
        'mulai_at'   => 'datetime',
        'selesai_at' => 'datetime',
    ];

    public function logs()
    {
        return $this->hasMany(UsabilityLog::class);
    }

    public function taskResults()
    {
        return $this->hasMany(UsabilityTaskResult::class);
    }
}
