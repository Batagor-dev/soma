<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Produk;
use App\Models\User;

class RestokProduk extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'produk_id',
        'user_id',
        'jumlah',
        'keterangan',
    ];

    // Relasi dengan Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class)->withTrashed();
    }

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
