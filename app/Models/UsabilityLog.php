<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsabilityLog extends Model
{
    protected $fillable = [
        'usability_session_id', 'event_type', 'page_url', 'page_name',
        'element', 'durasi_di_halaman', 'is_back_navigation',
        'is_error', 'catatan', 'terjadi_at',
    ];

    protected $casts = [
        'terjadi_at'        => 'datetime',
        'is_back_navigation' => 'boolean',
        'is_error'           => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(UsabilitySession::class);
    }
}
