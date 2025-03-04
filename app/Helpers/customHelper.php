<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManager as ImageManager;
use Intervention\Image\Drivers\GD\Driver as Driver;

use App\Models\SavePermissionModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


function isPermissions($permission)
{
    $permission_id = DB::table('user_permissions')->where('tle', $permission)->value('upi');
    $UserPermissions = SavePermissionModel::where('user_role', Auth::user()->user_role)->where('permission', $permission_id)->exists();
    return $UserPermissions;
}


function saveImage($file)
{
    try {
        if (!$file->isValid()) {
            throw new \Exception('Invalid file uploaded.');
        }
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = public_path('images/' . $fileName);
        $file->move(public_path('images'), $fileName);
        return $fileName;
    } catch (\Exception $e) {
        return null;
    }
}


function saveImageWebp($file)
{
    try {

        if (!$file->isValid()) {
            throw new \Exception('Invalid file uploaded.');
        }

        $fileName = uniqid() . '.webp';
        $path = public_path('images/' . $fileName);

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());
        $image->toWebp(quality: 90)->save($path);

        return $fileName;
    } catch (\Exception $e) {
        return null;
    }
}

//Token Create with data
if (!function_exists('tokenDecode')) {

    function tokenDecode($data)
    {
        $tokenData = base64_decode($data);
        return $tokenData;
    }
}

// delete Image
function deleteImage($imagePath)
{
    // Define the full path to the image
    $fullPath = public_path('images/' . $imagePath);

    // Check if the file exists and delete it
    if (File::exists($fullPath)) {
        File::delete($fullPath);
        return true;
    }

    return false;
}




if (!function_exists('logError')) {
    /**
     * Log an error with a unique identifier and detailed information.
     *
     * @param \Throwable $exception The caught exception
     * @param \Illuminate\Http\Request $request The current request
     * @param string $module The module or context where the error occurred
     * @return string The unique error identifier
     */
    function logError(\Throwable $exception, $request, $module = null)
    {
        $errorId = random_int(100000, 999999);
        $dateTime = now()->format('Y-m-d H:i:s');

        $logData = [
            'error_id' => $errorId,
            'error_massage' =>  $exception->getMessage() . PHP_EOL,
                'file_name' => $exception->getFile() . PHP_EOL,
                'line_number' => $exception->getLine() . PHP_EOL,
                'route_path' => $request->path() . PHP_EOL,
                'date_time' => $dateTime . PHP_EOL,
                'logged_info' => ['company_code' => session('cmco'), 'user_id' => auth()->user()->id, 'user_name' => auth()->user()->name],
        ];

        Log::channel($module)->error("Error ID: {$errorId}", $logData);

        return $errorId;
    }
}
