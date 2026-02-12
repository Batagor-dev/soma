<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class KategoriProduk extends Model
{

    protected $fillable = [
        'user_id',
        'nama',
        'deskripsi',
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
