<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stuktural extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = [
        'uuid', 'unit', 'jabatan', 'name', 'photo'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
