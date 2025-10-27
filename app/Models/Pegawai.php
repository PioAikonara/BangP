<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    
    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_telp',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
