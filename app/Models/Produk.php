<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\KategoriProduk;
use App\Models\RestokProduk;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'kategori_produk_id',
        'nama',
        'deskripsi',
        'harga',
        'stok',
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan KategoriProduk
    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id')
                    ->withTrashed();
    }

    // Relasi dengan RestokProduk
    public function restok()
    {
        return $this->hasMany(RestokProduk::class);
    }

}
