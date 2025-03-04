<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\QueryException;
use App\Exceptions\ErrorCodeException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRoleRequest;
use Illuminate\Support\Facades\Log;
use Validator;
use Auth;

//models
use App\Models\UserModel;
use App\Models\SavePermissionModel;
use App\Models\User;
use App\Models\ProductAttributeValueMap;
use App\Models\ProductAttribute;


class ActionController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Private function / create Log InfoFile
    |--------------------------------------------------------------------------
    */
    private function createLogInfoFile($status,$message){
        Log::info('success : '.$status.', message : '.$message);
    }

    //|--------------------------------------------------------------------------
    //| Dilusha Start
    //|--------------------------------------------------------------------------


    /*
    |--------------------------------------------------------------------------
    | Save Product Attributes
    |--------------------------------------------------------------------------
    |
    */
    public function saveAttributes(Request $request)
    {
        try {

            if (!isPermissions('add_product_attributes')) {
                return Redirect()->back()->with('error','You do not have permission to view the create attributes.');
            }

            $validation_array = [
                'attribute_name' => 'required|string|max:152',
                'attribute_slug' => 'required|string|max:152',
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
                return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction();

            $attribute = ProductAttribute::create([
                'name' => $request->attribute_name,
                'slug' => $request->attribute_slug,
                'created_by'=>Auth::id(),
            ]);

            if(!$attribute){
                return Redirect()->back()->with('error','Something Went Wrong,Try Again Later!');
            }


            foreach ($request->values as $index => $value) {
                ProductAttributeValueMap::create([
                    'product_attribute_id' => $attribute->id,
                    'value' => $value,
                    'slug' => $request->value_slugs[$index],
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Product attribute and values saved successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return Redirect()->back()->with(['success' => false, 'message' => 'An error occurred while creating the attriutes. Please try again later.!']);
        }
    }


    //|--------------------------------------------------------------------------
    //| Dilusha End
    //|-

    //|--------------------------------------------------------------------------
    //| Chandima Start
    //|--------------------------------------------------------------------------
    /*
    |--------------------------------------------------------------------------
    | User Update
    |--------------------------------------------------------------------------
    |
    */
    public function userUpdate(Request $request)
    {
        if (!isPermissions('user_list')) {
            return response()->json([
                'message' => 'You do not have permission to view the create user.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            $user = User::find($request->userId);
            $user->name = $request->firatName;
            $user->email = $request->userEmail;
            $user->email_verified_at = null;
            $user->last_name = $request->LastName;
            $user->phone = $request->phoneNo;
            $user->dob = $request->dob;
            $user->address = $request->address;
            $user->user_role = $request->userRole;
            $user->username = $request->userName;
            $user->status = $request->stus;
            $user->remember_token = null;
            $user->save();

            DB::commit();

            return Redirect()->back()->with(['success' => true, 'message' => 'User has been successfully updated!']);
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect()->back()->with(['success' => false, 'message' => 'An error occurred while updating the user. Please try again later.!']);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | User role update
    |--------------------------------------------------------------------------
    |
    */
    public function updateUserRole(UserRoleRequest $request)
    {
        try {

            if (!isPermissions('create_user_role')) {
                return response()->json([
                    'message' => 'You do not have permission to user role.'
                ], 403);
            }
            DB::beginTransaction();

            //create user role
            //$UserModel = new UserModel();
            $UserModel = UserModel::find($request->userRoleId);
            $UserModel->title = $request->roleName;
            $UserModel->created_by = auth()->id();
            $UserModel->updated_by = auth()->id();
            $UserModel->status = $request->stus;;
            $UserModel->save();

            if (SavePermissionModel::where('user_role', $UserModel->id)->exists()) {
                //delete old order items
                if (!SavePermissionModel::where('user_role', $UserModel->id)->delete()) {
                    throw new Exception('old user role delete failed!');
                }
            }
            //create user role permission
            $permissionCollection = collect(); //permission collection
            if ($request->has('permissions') && count($request->permissions) > 0) {
                foreach ($request->permissions as $permission) {
                    $permissionCollection->push([
                        'user_role' => $UserModel->id,
                        'permission' => $permission,
                    ]);
                }
                if (!SavePermissionModel::insert($permissionCollection->toArray())) {
                    return new Exception('user role permission update failed!');
                }
            }

            DB::commit();

            return Redirect()->back()->with(['success' => true, 'message' => 'User role has been successfully updated!']);
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect()->back()->with(['success' => false, 'message' => 'An error occurred while updating the user role. Please try again later.!']);
        }
    }
    //|--------------------------------------------------------------------------
    //| Chandima End
    //|--------------------------------------------------------------------------
}
