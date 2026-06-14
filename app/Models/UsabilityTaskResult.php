<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsabilityTaskResult extends Model
{
    protected $fillable = [
        'usability_session_id', 'task_number', 'task_name',
        'berhasil', 'durasi_detik', 'jumlah_error',
    ];

    protected $casts = [
        'berhasil' => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(UsabilitySession::class);
    }
}
