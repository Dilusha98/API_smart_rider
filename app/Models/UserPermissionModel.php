<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserPermissionModel extends Model
{
    use HasFactory;

    protected $table = 'user_permissions';
    protected $primaryKey = 'upi';
    public $timestamps = false;
    public $incrementing = true; 

    /*
    |--------------------------------------------------------------------------
    | Get user permissions
    |--------------------------------------------------------------------------
    |
    */
    public static function getUserPermissions()
    {
        return UserPermissionModel::selectRaw('upi as uPerissnId, tle as title, dpt as displayTxt, typ as type')
            ->get();
    }
}
