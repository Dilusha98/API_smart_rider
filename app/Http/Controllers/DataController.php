<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

//models
use App\Models\UserPermissionModel;
use App\Models\Brand;
use App\Models\UserModel;
use App\Models\User;
use App\Models\category;

class DataController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Private function / create Log InfoFile
    |--------------------------------------------------------------------------
    */
    private function createLogInfoFile($status, $message)
    {
        Log::info('success : ' . $status . ', message : ' . $message);
    }

    /*
    |--------------------------------------------------------------------------
    | user Permissions
    |--------------------------------------------------------------------------
    |
    */
    protected function getUserPermission()
    {
        $data = UserPermissionModel::getUserPermissions();
        $groupedData = $data->groupBy('type')->toArray();
        return $groupedData;
    }
    /*
    |--------------------------------------------------------------------------
    | get Brands
    |--------------------------------------------------------------------------
    |
    */
    public function getBrands()
    {
        $brands = Brand::with('createdBy')->get();
        return $brands;
    }

    /*
    |--------------------------------------------------------------------------
    | get user role
    |--------------------------------------------------------------------------
    |
    */
    public function getUserRole()
    {
        $data = UserModel::where('status', 1)->get();
        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | get user for edit
    |--------------------------------------------------------------------------
    |
    */
    public function getUserForEdit($userId)
    {
        $data = User::where('id', $userId)->get();
        return $data;
    }


    /*
    |--------------------------------------------------------------------------
    | get user categories
    |--------------------------------------------------------------------------
    |
    */
    public function getCategories()
    {
        $data = category::with('createdBy')->get();
        return $data;
    }



    //|--------------------------------------------------------------------------
    //| Chandima Start
    //|--------------------------------------------------------------------------
    /*
    |--------------------------------------------------------------------------
    | get user role for edit
    |--------------------------------------------------------------------------
    |
    */
    public function getUserRoleForEdit($userRoleId)
    {
        $data = UserModel::selectRaw('user_roles.id, user_roles.*')
            ->with(['getPermissions'])
            ->where('user_roles.id', $userRoleId)
            ->first();

        return $data;
    }
    //|--------------------------------------------------------------------------
    //| Chandima End
    //|--------------------------------------------------------------------------
}
