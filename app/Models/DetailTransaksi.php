<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Transaksi;
use App\Models\Produk;

class DetailTransaksi extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
        'harga',
        'subtotal',
    ];

    // Relasi dengan Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Relasi dengan Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class)->withTrashed();
    }
}
