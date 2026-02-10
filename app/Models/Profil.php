<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'profils'; 

    protected $guarded = ['id'];

    protected $fillable = [
        'uuid',
        'judul',
        'deskripsi',
        'photo',
        'poin', 
    ];

    protected $casts = [
        'poin' => 'array', 
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
