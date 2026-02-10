<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatans';

    protected $fillable = [
        'uuid',
        'slug',
        'title',
        'deskripsi',
        'photo',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Kegiatan $kegiatan) {
            if (empty($kegiatan->uuid)) {
                $kegiatan->uuid = (string) Str::uuid();
            }

            if (empty($kegiatan->slug) && !empty($kegiatan->title)) {
                $kegiatan->slug = Str::slug($kegiatan->title);
            }
        });
    }
}
