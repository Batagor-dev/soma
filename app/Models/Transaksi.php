<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\DetailTransaksi;

class Transaksi extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'tipe',
        'sumber',
        'total',
        'deskripsi',
        'tanggal',
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan DetailTransaksi
    public function details() {
        return $this->hasMany(DetailTransaksi::class);
    }

}
