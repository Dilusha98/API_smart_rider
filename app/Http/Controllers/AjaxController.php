<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandValidation;
use App\Http\Requests\brandEditValidation;
use App\Http\Requests\CategoryEditValidation;
use App\Http\Requests\categoryValidation;
use App\Http\Requests\UserRoleRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\CreateUserPasswordValidationRequest;
use App\Http\Requests\UpdateUserRequest;
use Exception;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use App\Exceptions\ErrorCodeException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

//models
use App\Models\Brand;
use App\Models\UserModel;
use App\Models\SavePermissionModel;
use App\Models\User;
use App\Models\category;
use App\Models\DriverLocation;

class AjaxController extends Controller
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
    | create brand
    |--------------------------------------------------------------------------
    |
    */
    public function addNewBrand(BrandValidation $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $logoName = null;
            if ($request->hasFile('logo')) {
                $logoName = saveImageWebp($request->file('logo'));
            }

            $brand = Brand::create([
                'name' => $data['name'],
                'logo' => $logoName,
                'status' => $data['status'],
                'created_by' => auth()->user()->id,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Brand has been successfully added!',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the brand. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | User role create
    |--------------------------------------------------------------------------
    |
    */
    public function createUserRole(UserRoleRequest $request)
    {
        try {

            if (!isPermissions('create_user_role')) {
                return response()->json([
                    'message' => 'You do not have permission to user role.'
                ], 403);
            }
            DB::beginTransaction();

            //create user role
            $UserModel = new UserModel();
            $UserModel->title = $request->roleName;
            $UserModel->created_by = auth()->id();
            $UserModel->updated_by = auth()->id();
            $UserModel->status = 1;
            if (!$UserModel->save()) {
                throw new Exception('user role create failed!');
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
                    return new Exception('user role permission crate failed!');
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User role has been successfully added!',
                'title' => 'Create User Role',
                'user_role' => $UserModel,
                'errorId' => null,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $errorId = logError($e, $request, 'user_management');
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the user role. Please try again later.',
                'title' => 'Error',
                'errorId' => $errorId,
            ]);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | get brand List
    |--------------------------------------------------------------------------
    |
    */
    public function brandList()
    {

        if (!isPermissions('brand_list')) {
            return response()->json([
                'message' => 'You do not have permission to view the brand list.'
            ], 403);
        }

        $brands = Brand::with('createdBy')->get();
        return response()->json(['brands' => $brands]);
    }
    /*
    |--------------------------------------------------------------------------
    | check phone number existing
    |--------------------------------------------------------------------------
    | .....
    */
    public function phoneNumberValidation(Request $request)
    {
        try {
            $status = User::where('phone', $request->value)->where('id', '!=', $request->id)->exists();
            return response()->json($status);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | User create
    |--------------------------------------------------------------------------
    |
    */
    public function saveUser(CreateUserRequest $request)
    {

        if (!isPermissions('create_user')) {
            return response()->json([
                'message' => 'You do not have permission to view the create user.'
            ], 403);
        }

        try {
            DB::beginTransaction();
            $data = $request->validated();

            $User = new User();
            $User->name = $data['firatName'];
            $User->email = $data['userEmail'];
            $User->email_verified_at = null;
            $User->password = Hash::make($data['password']);
            $User->last_name = $data['LastName'];
            $User->phone = $data['phoneNo'];
            $User->dob = $data['dob'];
            $User->address = $data['address'];
            $User->user_role = $data['userRole'];
            $User->username = $data['userName'];
            $User->status = 1;
            $User->remember_token = null;
            if (!$User->save()) {
                throw new Exception('user create failed!');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User has been successfully added!',
                'user' => $User
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the brand. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | get brand
    |--------------------------------------------------------------------------
    |
    */
    public function getBrand($id)
    {

        if (!isPermissions('brand_list')) {
            return response()->json([
                'message' => 'You do not have permission to view the brand list.'
            ], 403);
        }

        $brand = Brand::with('createdBy')->where('id', $id)->get();
        return response()->json($brand);
    }
    /*
    |--------------------------------------------------------------------------
    | Edit brand
    |--------------------------------------------------------------------------
    |
    */
    public function editNewBrand(BrandEditValidation $request, $id)
    {
        try {
            DB::beginTransaction();


            $data = $request->validated();

            $brand = Brand::findOrFail($id);
            if ($request->hasFile('brandLogoEdit')) {

                $logoName = saveImageWebp($request->file('brandLogoEdit'));
                if ($brand->logo) {
                    deleteImage($brand->logo);
                }
            } else {
                $logoName = $brand->logo;
            }

            $brand->update([
                'name' => $data['brandNameEdit'],
                'logo' => $logoName,
                'status' => $data['brandStatusEdit'],
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Brand has been successfully updated!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the brand. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | check user name existing
    |--------------------------------------------------------------------------
    | .....
    */
    public function userNameValidation(Request $request)
    {
        try {
            $status = User::where('username', $request->value)->where('id', '!=', $request->id)->exists();
            return response()->json($status);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | check user email existing
    |--------------------------------------------------------------------------
    | .....
    */
    public function userEmailValidation(Request $request)
    {
        try {
            $status = User::where('email', $request->value)->where('id', '!=', $request->id)->exists();
            return response()->json($status);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | get user List
    |--------------------------------------------------------------------------
    |
    */
    public function getUserList()
    {

        if (!isPermissions('user_list')) {
            return response()->json([
                'message' => 'You do not have permission to view the user list.'
            ], 403);
        }

        $users = User::selectRaw('users.*, a.title')
            ->leftJoin('user_roles as a', 'a.id', 'users.user_role')
            ->get();
        return response()->json(['users' => $users]);
    }
    /*
    |--------------------------------------------------------------------------
    | check current password
    |--------------------------------------------------------------------------
    |
    */
    public function currentPasswordCheckValidation(Request $request)
    {
        try {
            $user = User::find($request->id);
            if (!$user) {
                Log::error("User not found for ID: {$request->id}");
                return response()->json(false);
            }

            $inputLength = strlen($request->value);
            $dbHashLength = strlen($user->password);

            Log::info("Password check for user {$request->id}:");
            Log::info("Input password length: {$inputLength}");
            Log::info("Stored hash length: {$dbHashLength}");

            $status = Hash::check($request->value, $user->password);
            Log::info("Password match result: " . ($status ? 'Success' : 'Failure'));

            return response()->json($status);
        } catch (\Throwable $th) {
            Log::error("Error in password validation: " . $th->getMessage());
            return response()->json(false);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | save new password
    |--------------------------------------------------------------------------
    |
    */
    public function saveResetPassword(CreateUserPasswordValidationRequest $request)
    {
        if (!isPermissions('user_edit')) {
            return response()->json([
                'message' => 'You do not have permission to view the user edit.'
            ], 403);
        }

        try {
            DB::beginTransaction();
            $data = $request->validated();


            $user = User::find($request->hideUserId);
            if (!$user) {
                throw new Exception('User not found!');
            }

            // Update only the password column
            $user->password = Hash::make($data['newPassowrd']);
            $user->save(); // This will only update the changed attributes


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'The password reset is successful!',
                'user' => $user
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'There was an error resetting the password. Please try again!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | create category
    |--------------------------------------------------------------------------
    |
    */
    public function addNewCategory(categoryValidation $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $image = null;
            if ($request->hasFile('categoryImage')) {
                $image = saveImageWebp($request->file('categoryImage'));
            }

            $brand = category::create([
                'name' => $data['categoryName'],
                'image' => $image,
                'description' => $data['catDescription'],
                'created_by' => auth()->user()->id,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Category has been successfully added!',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the category. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | get category
    |--------------------------------------------------------------------------
    |
    */
    protected function getCategory($id)
    {

        if (!isPermissions('user_role_edit')) {
            return response()->json([
                'message' => 'You do not have permission to view the Category.'
            ], 403);
        }

        $category = category::with('createdBy')->where('id', $id)->get();
        return response()->json($category);
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Category
    |--------------------------------------------------------------------------
    |
    */
    public function editNewCategory(CategoryEditValidation $request, $id)
    {
        try {
            DB::beginTransaction();


            $data = $request->validated();

            $category = category::findOrFail($id);
            if ($request->hasFile('categoryEditImage')) {

                $logoName = saveImageWebp($request->file('categoryEditImage'));
                if ($category->image) {
                    deleteImage($category->image);
                }
            } else {
                $logoName = $category->image;
            }

            $category->update([
                'name' => $data['categoryEditName'],
                'image' => $logoName,
                'description' => $data['catEditDescription'],
                'status' => $data['catStatus'],
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Category has been successfully updated!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the Category. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | get category List
    |--------------------------------------------------------------------------
    |
    */
    public function CategoryList()
    {

        if (!isPermissions('category_list')) {
            return response()->json([
                'message' => 'You do not have permission to view the Category list.'
            ], 403);
        }

        $category = category::with('createdBy')->get();
        return response()->json(['category' => $category]);
    }


    /*
    |--------------------------------------------------------------------------
    | delete category
    |--------------------------------------------------------------------------
    |
    */
    public function CategoryDelete($id)
    {
        try {

            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the category. Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | delete brand
    |--------------------------------------------------------------------------
    |
    */
    public function brandDelete($id)
    {
        try {

            $brand = Brand::findOrFail($id);
            $brand->delete();

            return response()->json([
                'success' => true,
                'message' => 'Brand deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the brand. Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | get user List
    |--------------------------------------------------------------------------
    |
    */
    public function getUserRoleList()
    {

        if (!isPermissions('user_role_list')) {
            return response()->json([
                'message' => 'You do not have permission to view the user role list.'
            ], 403);
        }

        $userRoles = UserModel::selectRaw('user_roles.*, a.name as createdBy, b.name as updatedBy')
            ->leftJoin('users as a', 'a.id', 'user_roles.created_by')
            ->leftJoin('users as b', 'b.id', 'user_roles.updated_by')
            ->get();
        return response()->json(['userRoles' => $userRoles]);
    }



    public function getRideLocations($ride_id)
    {
        $locations = DriverLocation::where('ride_id', $ride_id)
            ->orderBy('captured_at')
            ->get(['lat', 'lng', 'captured_at']);

        return response()->json($locations);
    }


}
