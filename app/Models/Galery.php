<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Galery extends Model
{
    use HasFactory;

    protected $table = 'galeries';

    protected $fillable = [
        'uuid',
        'title',
        'photo',
        'time',
    ];

    /**
     * Gunakan UUID untuk route model binding
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Boot method untuk auto-generate UUID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Galery $galery) {

            if (empty($galery->uuid)) {
                $galery->uuid = (string) Str::uuid();
            }

        });
    }
}
