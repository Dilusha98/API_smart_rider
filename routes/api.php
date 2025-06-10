<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiActionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::post('/customer/login', [AuthController::class, 'login']);
Route::post('/appuser/register', [AuthController::class, 'register']);
Route::post('/appuser/login', [AuthController::class, 'login']);
Route::post('/ride/submit', [ApiActionController::class, 'submitRide']);
Route::middleware('auth:api')->get('/ride/get', [ApiActionController::class, 'getRideRequests']);
Route::middleware('auth:api')->get('/vehicles', [ApiActionController::class, 'getVehicleList']);
Route::middleware('auth:api')->post('/rides',    [ApiActionController::class, 'createRide']);
Route::middleware('auth:api')->post('/register_vehicles',   [ApiActionController::class, 'RegisterVehicles']);
Route::middleware('auth:api')->get('/rides/requests', [ApiActionController::class, 'getUpcomingRideRequests']);
Route::middleware('auth:api')->post('/verify-user', [ApiActionController::class, 'verifyUser']);
Route::middleware('auth:api')->get('/user-verification', [ApiActionController::class, 'getUerVerification']);
Route::middleware('auth:api')->get('/ride-offers', [ApiActionController::class, 'getRidestList']);
Route::middleware('auth:api')->get('/my-rides', [ApiActionController::class, 'MyRideList']);
Route::middleware('auth:api')->post('/api/send-ride-offer', [ApiActionController::class, 'storeRideOffer']);
Route::middleware('auth:api')->get('/ride/driver', [ApiActionController::class, 'getMyDriverRides']);
Route::middleware('auth:api')->get('/get-ride/{id}', [ApiActionController::class, 'getRide']);
Route::middleware('auth:api')->get('/ride/offers/{rideId}', [ApiActionController::class, 'getPassengerRideOffers']);
Route::middleware('auth:api')->get('/ride-request/{rideId}', [ApiActionController::class, 'getRideRequest']);
Route::middleware('auth:api')->post('/ride-request/approve-offer', [ApiActionController::class, 'approveRideRequestOffer']);
Route::middleware('auth:api')->get('/ride-request/reject-offer', [ApiActionController::class, 'rejectRideRequestOffer']);
Route::middleware('auth:api')->get('/ride/passenger/completed/{id}', [ApiActionController::class, 'getSingleCompletedPassengerRide']);
Route::middleware('auth:api')->post('/ride/rate-driver', [ApiActionController::class, 'rateDriver']);
Route::middleware('auth:api')->get('/ride/driver/detail/{id}', [ApiActionController::class, 'getDriverRideDetail']);
Route::middleware('auth:api')->post('/ride/offer/{id}/accept', [ApiActionController::class, 'acceptRideOffer']);
Route::middleware('auth:api')->post('/ride/offer/{id}/reject', [ApiActionController::class, 'rejectRideOffer']);
Route::middleware('auth:api')->post('/ride/driver/start/{id}', [ApiActionController::class, 'startRide']);
Route::middleware('auth:api')->post('/ride/{rideId}/location', [ApiActionController::class, 'logDriverLocation']);
Route::middleware('auth:api')->post('/ride/driver/stop/{id}', [ApiActionController::class, 'stopRide']);
Route::middleware('auth:api')->post('/ride/offer/{id}/verify-key', [ApiActionController::class, 'verifyRideKey']);
Route::middleware('auth:api')->get('/ride/driver/completed/{id}', [ApiActionController::class, 'completedRide']);
Route::middleware('auth:api')->post('/ride/feedback', [ApiActionController::class, 'ratePassenger']);
Route::middleware('auth:api')->get('/rides/my-available', [ApiActionController::class, 'getMyAvailableRides']);
Route::middleware('auth:api')->post('/ride/make-offer', [ApiActionController::class, 'makeOffer']);





