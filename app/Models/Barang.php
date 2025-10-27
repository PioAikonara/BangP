<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $table = 'barang';
    
    protected $fillable = [
        'nama_barang',
        'kategori',
        'ukuran',
        'harga_beli',
        'harga_jual',
        'stok',
        'gambar',
        'deskripsi',
        'expired_at',
        'diskon',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'diskon' => 'decimal:2',
        'expired_at' => 'date',
    ];

    public function transaksiDetail(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // Accessor untuk harga setelah diskon
    public function getHargaSetelahDiskonAttribute()
    {
        return $this->harga_jual - ($this->harga_jual * $this->diskon / 100);
    }

    // Scope untuk produk expired
    public function scopeExpired($query)
    {
        return $query->where('expired_at', '<', now());
    }

    // Scope untuk produk aktif
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expired_at')
              ->orWhere('expired_at', '>=', now());
        });
    }
}
