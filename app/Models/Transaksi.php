<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    
    protected $fillable = [
        'kode_transaksi',
        'kasir_id',
        'member_id',
        'total_harga',
        'diskon',
        'keuntungan',
        'metode_pembayaran',
        'status',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'diskon' => 'decimal:2',
        'keuntungan' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        // Generate kode transaksi otomatis
        static::creating(function ($transaksi) {
            if (empty($transaksi->kode_transaksi)) {
                $transaksi->kode_transaksi = 'TRX' . date('Ymd') . strtoupper(Str::random(6));
            }
        });
    }

    public function kasir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // Scope untuk transaksi hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Scope untuk transaksi selesai
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    // Accessor untuk total setelah diskon
    public function getTotalSetelahDiskonAttribute()
    {
        return $this->total_harga - $this->diskon;
    }
}
