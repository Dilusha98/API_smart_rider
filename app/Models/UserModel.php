<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'user_roles';
    protected $primaryKey = 'id';
    public $timestamps = true;


    function getPermissions()
    {
        return $this->hasMany(SavePermissionModel::class, 'user_role', 'id')->selectRaw('save_permissions.user_role, save_permissions.permission');
    }
}
