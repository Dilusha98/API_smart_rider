<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\raffel;
use App\Models\AppUsers;
use App\Models\VehicleModel;
use App\Models\RideRequestModel;
use App\Models\RideOffers;
use App\Models\Ride;
use Auth;
use Carbon\Carbon;

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
        $totalUsers = AppUsers::count();

        $pendingDriverConfirmations = AppUsers::count();

        $weekRides = Ride::count();

        $data = [
            'title' => 'Dashboard',
            'view' => 'home',
            'totalUsers' => $totalUsers,
            'pendingDrivers' => $pendingDriverConfirmations,
            'weeklyRides' => $weekRides,
        ];

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

    public function verifyAppUsers(Request $request)
    {
        $users = AppUsers::whereHas('userVerificationDocuments')
            ->with(['userVerificationDocuments' => function($query) {
                $query->orderBy('status', 'asc')
                    ->orderBy('id', 'desc');
            }])
            ->get();

        return $this->default([
            'title'  => 'Verify App User',
            'view'   => 'verifyAppUser',
            'users'  => $users,
        ]);

        return $this->default($data);
    }

    public function verifyVehicles(Request $request)
    {
        $vehicles = VehicleModel::with('images')->orderBy('status')->get();

        return $this->default([
            'title'  => 'Verify Vehicles',
            'view'   => 'verifyVehicles',
            'vehicles' => $vehicles,
        ]);

        return $this->default($data);
    }


public function rideOffers(Request $request)
{
    if ($request->ajax()) {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search')['value'];

        $query = RideOffers::with(['ride.user', 'request', 'passengerUser']);

        // Search functionality
        if (!empty($search)) {
            $query->whereHas('ride.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('passengerUser', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('request', function($q) use ($search) {
                $q->where('pickup_place', 'like', "%{$search}%")
                  ->orWhere('drop_place', 'like', "%{$search}%");
            });
        }

        $totalRecords = RideOffers::count();
        $totalDisplay = $query->count();

        $offers = $query->skip($start)->take($length)->orderBy('id', 'desc')->get();

        $data = [];
        foreach ($offers as $offer) {
            // Status mapping for offers
            $statusText = '';
            switch ($offer->status) {
                case 0: $statusText = '<span class="badge badge-warning">Pending</span>'; break;
                case 1: $statusText = '<span class="badge badge-info">Accepted</span>'; break;
                case 2: $statusText = '<span class="badge badge-success">Completed</span>'; break;
                default: $statusText = '<span class="badge badge-secondary">Unknown</span>';
            }

            $data[] = [
                'id' => $offer->id,
                'driver_name' => $offer->ride && $offer->ride->user ? $offer->ride->user->name : 'N/A',
                'passenger_name' => $offer->passengerUser ? $offer->passengerUser->name : 'N/A',
                'ride_date' => $offer->ride ? date('M d, Y', strtotime($offer->ride->date)) : 'N/A',
                'pickup_place' => $offer->request ? $offer->request->pickup_place : 'N/A',
                'drop_place' => $offer->request ? $offer->request->drop_place : 'N/A',
                'price' => 'LKR ' . number_format($offer->price, 2),
                'status_text' => $statusText,
                'action' => '<button class="btn btn-info btn-sm view-offer" data-id="'.$offer->id.'">
                                <i class="fa fa-eye"></i> View
                            </button>'
            ];
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data' => $data
        ]);
    }

    return $this->default([
        'title' => 'Ride Offers',
        'view' => 'rideOffers',
    ]);
}

public function rideRequests(Request $request)
{
    if ($request->ajax()) {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search')['value'];

        $query = RideRequestModel::with(['ride.user']);

        if (!empty($search)) {
            $query->where('pickup_place', 'like', "%{$search}%")
                  ->orWhere('drop_place', 'like', "%{$search}%")
                  ->orWhereHas('ride.user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $totalRecords = RideRequestModel::count();
        $totalDisplay = $query->count();

        $requests = $query->skip($start)->take($length)->orderBy('id', 'desc')->get();

        $data = [];
        foreach ($requests as $req) {

            $currentDate = now()->format('Y-m-d');
            $actualStatus = $req->status;

            if (($req->status == 0 || $req->status == 1) && $req->date < $currentDate) {
                $actualStatus = 2;
            }

            $statusText = '';
            switch ($actualStatus) {
                case 0: $statusText = '<span class="badge badge-info">Upcoming</span>'; break;
                case 1: $statusText = '<span class="badge badge-warning">Ongoing</span>'; break;
                case 2: $statusText = '<span class="badge badge-success">Completed</span>'; break;
                default: $statusText = '<span class="badge badge-secondary">Unknown</span>';
            }

            $data[] = [
                'id' => $req->id,
                'user_name' => $req->ride && $req->ride->user ? $req->ride->user->name : 'N/A',
                'formatted_date' => date('M d, Y', strtotime($req->date)),
                'formatted_time' => $req->time ? date('h:i A', strtotime($req->time)) : 'N/A',
                'pickup_place' => $req->pickup_place ?: 'N/A',
                'drop_place' => $req->drop_place ?: 'N/A',
                'seats' => $req->seats,
                'distance' => $req->distance ? number_format($req->distance, 2) . ' km' : 'N/A',
                'status_text' => $statusText,
                'action' => '<button class="btn btn-info btn-sm view-request" data-id="'.$req->id.'">
                                <i class="fa fa-eye"></i> View
                            </button>'
            ];
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data' => $data
        ]);
    }

    return $this->default([
        'title' => 'Ride Requests',
        'view' => 'rideRequests',
    ]);
}

public function viewRideOffer($id)
{
    try {
        $offer = RideOffers::with(['ride.user', 'request', 'passengerUser'])->findOrFail($id);
        return response()->json($offer);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Offer not found'], 404);
    }
}

public function viewRideRequest($id)
{
    try {
        $request = RideRequestModel::with(['ride.user'])->findOrFail($id);
        return response()->json($request);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Request not found'], 404);
    }
}

}
