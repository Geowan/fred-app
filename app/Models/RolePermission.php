<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    public $appends = ["permission"];
    protected $fillable = ["permission_id","role_id"];

    public function getPermissionAttribute()
    {
        $permission =  Permission::where('id', $this->permission_id)->first();
        return $permission?$permission->name:'';
    }
}
