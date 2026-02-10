<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use App\Models\PermissionGroup;
use App\Models\Permission;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends SpatieRole
{
    use HasUuid, SoftDeletes;

    protected $guarded = ['id','uuid'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
