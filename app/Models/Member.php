<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'nama_member',
        'no_hp',
        'alamat',
        'kode_member',
        'qr_code',
    ];

    protected static function boot()
    {
        parent::boot();
        
        // Generate kode member otomatis saat create
        static::creating(function ($member) {
            if (empty($member->kode_member)) {
                $member->kode_member = 'MBR' . strtoupper(Str::random(8));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}
