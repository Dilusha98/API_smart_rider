<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\raffel;
use Auth;

class viewController extends DataController
{

    /*
    |--------------------------------------------------------------------------
    | Public Function Default
    |--------------------------------------------------------------------------
    |
    */
    public function default($data,$pos=false)
    {

        // Defalut css
        $css = array(
            config('site-specific.datatable-css'),
            config('site-specific.datatable-btn-css'),
            config('site-specific.datatable-bootstrap-css'),
            config('site-specific.dropify-css'),
            config('site-specific.sweetAlert-css'),
            config('site-specific.toastr-css'),
            config('site-specific.switchery-css'),
        );

        //Default script
        $script = array(
            config('site-specific.jquery-min-js'),
            config('site-specific.jquery-ui-min-js'),
            config('site-specific.datatable-js'),
            config('site-specific.datatable-button-js'),
            config('site-specific.datatable-html5-js'),
            config('site-specific.datatable-print-js'),
            config('site-specific.datatable-jszip-js'),
            config('site-specific.datatable-pdfmake-js'),
            config('site-specific.datatable-pdffont-js'),
            config('site-specific.datatable-colVis-js'),
            config('site-specific.datatable-btn-bootstrap-js'),
            config('site-specific.jquery-validation-js'),
            config('site-specific.dropify-js'),
            config('site-specific.sweetAlert-js'),
            config('site-specific.toastr-js'),
            config('site-specific.switchery-js'),
        );

        if (isset($data['css'])) {
            $data['css'] = array_merge($css, $data['css']);
        } else {
            $data['css'] = $css;
        }
        if (isset($data['script'])) {
            $data['script'] = array_merge($script, $data['script']);
        } else {
            $data['script'] = $script;
        }

        if ($pos) {
            return View::make('pos/posLayout', $data);
        }
        return View::make('dashboard', $data);
    }
    /*
    |--------------------------------------------------------------------------
    | Public Function Dashboard
    |--------------------------------------------------------------------------
    |
    */
    public function index()
    {
        $data = array(
            'title'                 => 'Dashboard',
            'view'                  => 'home',
        );

        return $this->default($data);
    }

    /*
    |--------------------------------------------------------------------------
    | Public Function POS View
    |--------------------------------------------------------------------------
    |
    */
    public function PosView()
    {
        $data = array(
            'title'                 => 'Poin of Sales',
            'view'                  => 'pos/pos',
        );

        $pos =true;

        return $this->default($data,$pos);
    }

    /*
    |--------------------------------------------------------------------------
    | Public Function Brand
    |--------------------------------------------------------------------------
    |
    */
    public function brand()
    {

        $data = array(
            'title'                 => 'Brand',
            'view'                  => 'product/brand',
            'script'                => array(config('site-specific.brand-js')),
            'brands'                => $this->getBrands(),
        );

        return $this->default($data);
    }
    /*
    |--------------------------------------------------------------------------
    | Public Function User Role
    |--------------------------------------------------------------------------
    |
    */
    public function userRole()
    {

        $data = array(
            'title'                 => 'User Role',
            'view'                  => 'user_role/create_user_role',
            'script'                => array(config('site-specific.create-user-role-js')),
            'groupedData'           => $this->getUserPermission(),
        );

        return $this->default($data);
    }
    /*
    |--------------------------------------------------------------------------
    | Public Function Create User
    |--------------------------------------------------------------------------
    |
    */
    public function createUser()
    {

        $data = array(
            'title'                 => 'Create User',
            'view'                  => 'user_role/create_user',
            'script'                => array(config('site-specific.create-user-js')),
            'userRoleData'           => $this->getUserRole(),
        );

        return $this->default($data);
    }
    /*
    |--------------------------------------------------------------------------
    | Public Function User List
    |--------------------------------------------------------------------------
    |
    */
    public function userList()
    {

        $data = array(
            'title'                 => 'User List',
            'view'                  => 'user_role/user_list',
            'script'                => array(config('site-specific.user-list-js')),
            //'userRoleData'           => $this->getUserRole(),
        );

        return $this->default($data);
    }
    /*
    |--------------------------------------------------------------------------
    | Public Function Edit User
    |--------------------------------------------------------------------------
    |
    */
    public function userEdit(Request $request)
    {
        $userId = tokenDecode($request->query('token'));

        $data = array(
            'title'                 => 'User Edit',
            'view'                  => 'user_role/edit_user',
            'script'                => array(config('site-specific.user-edit-js')),
            'userRoleData'           => $this->getUserRole(),
            'editData'           => $this->getUserForEdit($userId),
        );

        return $this->default($data);
    }
    /*
    |--------------------------------------------------------------------------
    | Public Function User Role List
    |--------------------------------------------------------------------------
    |
    */
    public function userRoleList()
    {

        $data = array(
            'title'                 => 'User Role List',
            'view'                  => 'user_role/user_role_list',
            'script'                => array(config('site-specific.user-role-list-js')),
            //'userRoleData'           => $this->getUserRole(),
        );

        return $this->default($data);
    }
    /*
    |--------------------------------------------------------------------------
    | Public Function Edit User Role
    |--------------------------------------------------------------------------
    |
    */
    public function userRoleEdit(Request $request)
    {
        $userRoleId = tokenDecode($request->query('token'));

        $data = array(
            'title'                 => 'User Role Edit',
            'view'                  => 'user_role/user_role_edit',
            'script'                => array(config('site-specific.user-role-edit-js')),
            'groupedData'           => $this->getUserPermission(),
            'editData'           => $this->getUserRoleForEdit($userRoleId),
        );

        //dd($data);

        return $this->default($data);
    }

    /*
    |--------------------------------------------------------------------------
    | Public Function Categories list
    |--------------------------------------------------------------------------
    |
    */
    public function categories(Request $request)
    {
        $data = array(
            'title'                 => 'Categories',
            'view'                  => 'product/categories',
            'script'                => array(config('site-specific.category-js')),
            'categories'            => $this->getCategories(),
        );

        return $this->default($data);
    }


    /*
    |--------------------------------------------------------------------------
    | Public Function add product attributes
    |--------------------------------------------------------------------------
    |
    */
    public function addProductAttributes(Request $request)
    {
        $data = array(
            'title'                 => 'Product Attributes',
            'view'                  => 'product/addProductAttributes',
            'script'                => array(config('site-specific.product-attributes-js')),
            'categories'            => $this->getCategories(),
        );

        return $this->default($data);
    }
}
