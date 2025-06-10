<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

//models
use App\Models\RideRequestModel;
use App\Models\VehicleModel;
use App\Models\Ride;
use App\Models\VehicleImage;
use App\Models\UserVerification;
use App\Models\RideOffers;
use App\Models\passenger_ride_offers;
use App\Models\DriverLocation;

class ApiActionController extends Controller
{
    public function submitRide(Request $request)
    {
        try {

            DB::beginTransaction();

            $request->validate([
                'userId' => 'required|exists:appuser,id',
                'date' => 'required|date|after:today',
                'time' => 'required|date_format:H:i',
                'pickup.lat' => 'required|numeric',
                'pickup.lng' => 'required|numeric',
                'dropoff.lat' => 'required|numeric',
                'dropoff.lng' => 'required|numeric',
                'pickup.place' => 'required',
                'dropoff.place' => 'required',
            ]);

            $request = RideRequestModel::create([
                'user_id' => $request->userId,
                'date' => $request->date,
                'time' => $request->time,
                'note' => $request->message,
                'pickup_lat' => $request->pickup['lat'],
                'pickup_lng' => $request->pickup['lng'],
                'dropoff_lat' => $request->dropoff['lat'],
                'dropoff_lng' => $request->dropoff['lng'],
                'distance' => $request->distance,
                'pickup_place' => $request->pickup['place'],
                'drop_place' => $request->dropoff['place'],
                'status' => 0,
            ]);

            DB::commit();

            return response()->json(['message' => 'Ride created successfully'], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create ride. Please try again later.'.$th->getMessage()
            ], 500);
        }
    }

    public function getRideRequests(Request $request)
    {
        $userId = auth()->guard('api')->user()->id;

        $upcomingRides = RideRequestModel::where('user_id', $userId)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->get();

        $pastRides = RideRequestModel::where('user_id', $userId)
            ->where('date', '<', now()->toDateString())
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'upcomingRides' => $upcomingRides,
            'pastRides' => $pastRides
        ]);
    }

    public function getVehicleList(Request $request)
    {
        $userId = auth()->guard('api')->user()->id;

        $myVehicleList = VehicleModel::where([
            'owner' => $userId,
            'status' => 1
        ])->get();

        return response()->json([
            'vehicleList' => $myVehicleList,
        ]);
    }

    public function createRide(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'user_id' => 'required|exists:appuser,id',
            'vehicle_id' => 'required|exists:vehicle,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'message' => 'nullable|string|max:255',
            'seats' => 'required|integer|min:1',
            'start_lat' => 'required|numeric',
            'start_lng' => 'required|numeric',
            'start_place' => 'required|string|max:255',
            'end_lat' => 'required|numeric',
            'end_lng' => 'required|numeric',
            'end_place' => 'required|string|max:255',
        ]);

        $vehicle = VehicleModel::find($validated['vehicle_id']);
        if ($validated['seats'] > $vehicle->max_seats) {
            return response()->json(['message' => 'Seat count exceeds vehicle limit.'], 422);
        }

        $validated['status'] = 0;

        Ride::create($validated);

        return response()->json(['message' => 'Ride created successfully.'], 201);
    }


    public function getUpcomingRideRequests(Request $request)
    {
        $user = auth()->guard('api')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $upcomingRides = RideRequestModel::where('user_id', '!=', $user->id)
            ->where('status',0)
            ->get();

        return response()->json([
            'upcomingRides' => $upcomingRides,
        ]);
    }

    public function registerVehicles(Request $request)
    {
        try {
            $user = auth()->guard('api')->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $validator = Validator::make($request->all(), [
                'category' => 'required|string|max:50',
                'brand' => 'required|string|max:50',
                'model' => 'required|string|max:50',
                'plate_number' => 'required|string|max:20|unique:vehicle,plate_number',
                'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'fuel_type' => 'required|string|max:20',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'max_seats' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            DB::beginTransaction();

            $vehicle = VehicleModel::create([
                'owner' => $user->id,
                'category' => $request->category,
                'brand' => $request->brand,
                'model' => $request->model,
                'plate_number' => $request->plate_number,
                'year' => $request->year,
                'fuel_type' => $request->fuel_type,
                'status' => 0,
                'max_seats' => $request->max_seats,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = Str::uuid()->toString() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/vehicle_images', $filename);

                    VehicleImage::create([
                        'vehicle_id' => $vehicle->id,
                        'image_name' => $filename
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'message' => 'Vehicle registered successfully.',
                'vehicle' => $vehicle->load('images')
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Vehicle registration unsuccessfully.'
            ]);
        }

    }


    public function verifyUser(Request $request)
    {
        try {
            $user = auth()->guard('api')->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $validator = Validator::make($request->all(), [
                'id_back'        => 'nullable|image|mimes:jpeg,png,jpg|max:12048',
                'id_front'       => 'nullable|image|mimes:jpeg,png,jpg|max:12048',
                'license_front'  => 'nullable|image|mimes:jpeg,png,jpg|max:12048',
                'license_back'   => 'nullable|image|mimes:jpeg,png,jpg|max:12048',
                'selfie'         => 'nullable|image|mimes:jpeg,png,jpg|max:12048',
                'student_id'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'work_id'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = ['user_id' => $user->id];
            $commonTypes = ['id_front', 'id_back', 'license_front', 'license_back', 'selfie'];

            $userType = $user->user_type;

            if ($userType === 'student') {
                $commonTypes[] = 'student_id';
            } elseif ($userType === 'professional') {
                $commonTypes[] = 'work_id';
            }

            foreach ($commonTypes as $type) {
                if ($request->hasFile($type)) {
                    $file = $request->file($type);
                    $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/user_verifications', $filename);

                    UserVerification::updateOrCreate(
                        ['user_id' => $user->id, 'type' => $type],
                        ['file_name' => $filename, 'status' => 0]
                    );
                }
            }


            return response()->json([
                'message' => 'Verification submitted successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong during verification.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getUerVerification()
    {
        try {
            $user = Auth::guard('api')->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $documents = UserVerification::where('user_id', $user->id)
                ->select('type', 'file_name', 'status')
                ->get()
                ->map(function ($doc) {
                    return [
                        'type' => $doc->type,
                        'file_name' => $doc->file_name,
                        'url' => asset('storage/user_verifications/' . $doc->file_name),
                        'status' => $doc->status,
                        'status_text' => $doc->status_text,
                    ];
                });

            return response()->json([
                'documents' => $documents
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch verification data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getRidestList()
    {
        $user = Auth::guard('api')->user();

        $rides = Ride::with('user')
            ->where('user_id', '!=', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        $rideList = $rides->map(function ($ride) {
            return [
                'id' => $ride->id,
                'date' => $ride->date,
                'time' => $ride->time,
                'seats' => $ride->seats,
                'pickup' => [
                    'place' => $ride->start_place,
                    'lat' => $ride->start_lat,
                    'lng' => $ride->start_lng,
                ],
                'dropoff' => [
                    'place' => $ride->end_place,
                    'lat' => $ride->end_lat,
                    'lng' => $ride->end_lng,
                ],
                'seats_available' => $ride->seats,
                'status' => $ride->status,
                'driver' => [
                    'name' => $ride->user->name ?? '',
                    'email' => $ride->user->email ?? '',
                    'rating' => 4.5
                ],
            ];
        });

        return response()->json($rideList);
    }

public function MyRideList(Request $request)
{
    $user = Auth::guard('api')->user();
    $rideId = $request->input('ride_id');

    $ride = Ride::find($rideId);

    if (!$ride) {
        return response()->json(['message' => 'Ride not found'], 404);
    }

    $matchingRequests = RideRequestModel::where('user_id', $user->id)
        ->where('status', 0)
        ->whereDate('date', $ride->date)
        ->where('seats', '<=', $ride->seats)
        ->orderBy('date', 'desc')
        ->get(['id', 'pickup_place', 'drop_place', 'seats']);

    if ($matchingRequests->isEmpty()) {
        return response()->json(['message' => 'No matching ride requests found'], 404);
    }

    return response()->json($matchingRequests);
}


public function storeRideOffer(Request $request)
{
    $validated = $request->validate([
        'ride_id' => 'required|exists:rides,id',
        'request_id' => 'required|exists:ride_requests,id',
        'price' => 'required|numeric|min:0'
    ]);

    $driver = Auth::guard('api')->user();

    $ride = Ride::findOrFail($validated['ride_id']);
    $requestModel = RideRequestModel::findOrFail($validated['request_id']);

    RideOffers::create([
        'ride_id' => $ride->id,
        'request_id' => $requestModel->id,
        'passenger' => $requestModel->user_id,
        'price' => $validated['price'],
        'status' => 0
    ]);

    return response()->json(['message' => 'Offer submitted successfully.']);
}

public function getMyDriverRides(Request $request)
{
    $user = auth()->guard('api')->user()->id;

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $rides = Ride::where('user_id', $user)
            ->orderBy('date', 'desc')
            ->get();

    return response()->json(['driverRides' => $rides], 200);
}

public function getRide($id) {
    $ride = Ride::findOrFail($id);
    return response()->json(['ride' => $ride]);
}

public function getRideOffers($rideId) {
    $offers = RideOffers::where('ride_id', $rideId)
        ->with('driver')
        ->get()
        ->map(function ($offer) {
            return [
                'id' => $offer->id,
                'driver_name' => $offer->driver->name,
                'start_time' => $offer->start_time,
                'status' => $offer->status,
                'is_started' => $offer->is_started,
            ];
        });

    return response()->json(['offers' => $offers]);
}

public function getRideRequest($rideId)
{
    try {
        $ride = RideRequestModel::find($rideId);

        if (!$ride) {
            return response()->json(['message' => 'Ride request not found'], 404);
        }

        return response()->json(['ride' => $ride], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to fetch ride request',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function getPassengerRideOffers($rideId)
{
    $offers = passenger_ride_offers::where('p_ride_id', $rideId)
        ->with(['driver', 'ride.vehicle'])
        ->get();
        // ->map(function ($offer) {
        //     return [
        //         'id' => $offer->id,
        //         'price' => $offer->price,
        //         'status' => $offer->status,
        //         'driver' => [
        //             'name' => $offer->driver->name ?? 'N/A',
        //             'rating' => $offer->driver->rating ?? 'N/A',
        //         ],
        //         'vehicle' => [
        //             'model' => $offer->ride->vehicle->model ?? 'N/A',
        //         ]
        //     ];
        // });

    return response()->json(['offers' => $offers]);
}

public function approveRideRequestOffer(Request $request)
{
    $request->validate([
        'offer_id' => 'required|exists:passenger_ride_offers,id',
    ]);

    $offer = passenger_ride_offers::find($request->offer_id);

    if (!$offer) {
        return response()->json(['message' => 'Offer not found'], 404);
    }

    $offer->status = 1;
    $offer->save();

    passenger_ride_offers::where('p_ride_id', $offer->p_ride_id)
        ->where('id', '!=', $offer->id)
        ->update(['status' => 2]);

    return response()->json(['message' => 'Offer approved and ride started successfully.']);
}

public function rejectRideRequestOffer(Request $request)
{
    $request->validate([
        'offer_id' => 'required|exists:passenger_ride_offers,id',
    ]);

    $offer = passenger_ride_offers::find($request->offer_id);

    if (!$offer) {
        return response()->json(['message' => 'Offer not found'], 404);
    }

    $offer->status = 2;
    $offer->save();

    return response()->json(['message' => 'Offer rejected successfully.']);
}

public function getSingleCompletedPassengerRide($id)
{
    $userId = auth()->guard('api')->user()->id;

    $rideRequest = RideRequestModel::with(['ride.vehicle', 'ride.user'])
        ->where('user_id', $userId)
        ->where('id', $id)
        ->first();

        // return $rideRequest;

    if (!$rideRequest) {
        return response()->json(['message' => 'Ride request not found'], 404);
    }

    $acceptedOffer = passenger_ride_offers::where('p_ride_id', $rideRequest->id)
        ->where('status', 1)
        ->first();

    $ride = $rideRequest->ride;
    $rideStarted = $ride && $ride->status == 2;

    return response()->json([
        'ride' => [
            'id' => $rideRequest->id,
            'pickup_place' => $rideRequest->pickup_place,
            'drop_place' => $rideRequest->drop_place,
            'date' => $rideRequest->date,
            'time' => $rideRequest->time,
            'driver_rating' => $rideRequest->driver_rating,
            'distance' => $rideRequest->distance,
            'driver' => $acceptedOffer ? optional($ride->user)->name : null,
            'vehicle' => $acceptedOffer ? $ride->vehicle->brand.'-'.$ride->vehicle->model.' ('.$ride->vehicle->plate_number.')' : null,
            'status' => $acceptedOffer ? 1 : 0,
            'message' => $acceptedOffer ? null : 'Ride not completed',
        ]
    ]);
}


public function rateDriver(Request $request)
{
    $request->validate([
        'ride_id' => 'required|exists:ride_requests,id',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $userId = auth()->guard('api')->user()->id;

    $rideRequest = RideRequestModel::where('id', $request->ride_id)
        ->where('user_id', $userId)
        ->first();

    if (!$rideRequest) {
        return response()->json(['message' => 'Ride request not found or unauthorized'], 404);
    }

    // Prevent duplicate rating
    if ($rideRequest->driver_rating !== null) {
        return response()->json(['message' => 'Rating already submitted for this ride'], 400);
    }

    $ride = $rideRequest->ride;

    if (!$ride) {
        return response()->json(['message' => 'Associated ride not found'], 404);
    }

    $driver = $ride->user;
    if (!$driver) {
        return response()->json(['message' => 'Driver not found'], 404);
    }

    // Update ride request with this rating
    $rideRequest->driver_rating = $request->rating;
    $rideRequest->save();

    // Calculate new average rating
    $oldTotal = $driver->rating * $driver->rating_count;
    $newCount = $driver->rating_count + 1;
    $newTotal = $oldTotal + $request->rating;
    $newAverage = round($newTotal / $newCount);

    $driver->rating = $newAverage;
    $driver->rating_count = $newCount;
    $driver->save();

    return response()->json(['message' => 'Driver rated successfully']);
}

// ----------------------------------

public function getDriverRideDetail($id)
{
    $user = auth()->user();

    $ride = Ride::with('vehicle')->where('id', $id)->where('user_id', $user->id)->firstOrFail();

    $offers = RideOffers::with(['request', 'passengerUser'])
        ->where('ride_id', $ride->id)
        ->get();

    return response()->json([
        'ride' => $ride,
        'offers' => $offers
    ]);
}

public function acceptRideOffer($id)
{
    $offer = RideOffers::with(['ride', 'request'])->findOrFail($id);
    $ride = $offer->ride;
    $request = $offer->request;

    if (!$ride || $ride->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $acceptedCount = RideOffers::where('ride_id', $ride->id)
        ->where('status', 1)
        ->count();

    if ($acceptedCount >= $ride->seats) {
        return response()->json(['error' => 'All available seats are filled.'], 400);
    }

    $offer->status = 1;
    $offer->save();

    if ($request) {
        $request->ride_id = $ride->id;
        $request->status = 1;
        $request->save();
    }

    $acceptedCount++;

    if ($acceptedCount >= $ride->seats) {
        RideOffers::where('ride_id', $ride->id)
            ->where('status', 0)
            ->where('id', '!=', $offer->id)
            ->update(['status' => 2]);
    }

    return response()->json(['message' => 'Offer accepted and other offers updated.']);
}

public function rejectRideOffer($id)
{
    $offer = RideOffers::with('ride')->findOrFail($id);
    $ride = $offer->ride;

    if (!$ride || $ride->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $offer->status = 2; // Rejected
    $offer->save();

    return response()->json(['message' => 'Offer rejected successfully.']);
}

public function startRide($id)
{
    $ride = Ride::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    if ($ride->status !== 0) {
        return response()->json(['error' => 'Ride is not in an upcoming state.'], 400);
    }

    $ride->status = 1;
    $ride->save();

    $rideRequests = RideRequestModel::where('ride_id', $ride->id)
        ->where('status', 1)
        ->get();

    foreach ($rideRequests as $request) {
        $request->status = 1;
        $request->ride_key = Str::upper(Str::random(8));
        $request->save();
    }

    return response()->json([
        'message' => 'Ride started successfully.',
        'updated_requests' => $rideRequests->count()
    ]);
}

public function logDriverLocation(Request $request, $rideId)
{
    $request->validate([
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
    ]);

    $ride = Ride::findOrFail($rideId);

    if ($ride->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    DriverLocation::create([
        'ride_id' => $ride->id,
        'driver_id' => auth()->id(),
        'lat' => $request->lat,
        'lng' => $request->lng,
        'captured_at' => now()
    ]);

    return response()->json(['message' => 'Location logged successfully']);
}

public function stopRide($id)
{
    $ride = Ride::findOrFail($id);

    if ($ride->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $ride->status = 2;
    $ride->save();

    RideRequestModel::where('ride_id', $ride->id)
        ->where('status', 1)
        ->update(['status' => 2]);

    return response()->json(['message' => 'Ride and related requests marked as completed']);
}


public function verifyRideKey(Request $request, $offerId)
{
    $offer = RideOffers::with('request')->findOrFail($offerId);

    if (!$offer || $offer->status != 1) {
        return response()->json(['error' => 'Invalid offer or not accepted'], 400);
    }

    $inputKey = $request->ride_key;
    if ($offer->request->ride_key === $inputKey) {
        $offer->picked_up = 1;
        $offer->save();

        return response()->json(['message' => 'Passenger marked as picked up']);
    }

    return response()->json(['error' => 'Incorrect ride key'], 401);
}


public function completedRide($id)
{
    $ride = Ride::with('user')->findOrFail($id);

    if ($ride->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $rideDateTime = \Carbon\Carbon::parse($ride->date . ' ' . $ride->time);
    $now = now();
    $isPast = $now->greaterThan($rideDateTime);
    $isCompleted = $ride->status == 2;
    $isExpiredUnstarted = $ride->status == 0 && $isPast;

    if (!$isCompleted && !$isExpiredUnstarted) {
        return response()->json(['error' => 'Ride is not completed'], 400);
    }

    $offers = RideOffers::with(['passengerUser', 'request'])
        ->where('ride_id', $id)
        ->where('status', 1)
        ->get();

    $locations = DriverLocation::where('ride_id', $id)
        ->orderBy('captured_at')
        ->get(['lat', 'lng', 'captured_at']);

    return response()->json([
        'ride' => $ride,
        'offers' => $offers,
        'locations' => $locations
    ]);
}


public function ratePassenger(Request $request)
{
    $request->validate([
        'offer_id' => 'required|exists:ride_offers,id',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $driverId = auth()->guard('api')->user()->id;

    $offer = RideOffers::with('request')->find($request->offer_id);

    return $offer;

    if (!$offer || !$offer->ride || $offer->ride->driver_id !== $driverId) {
        return response()->json(['message' => 'Ride offer not found or unauthorized'], 404);
    }

    $rideRequest = $offer->request;

    if (!$rideRequest) {
        return response()->json(['message' => 'Associated ride request not found'], 404);
    }

    if ($rideRequest->passenger_rating !== null) {
        return response()->json(['message' => 'Rating already submitted'], 400);
    }

    $rideRequest->passenger_rating = $request->rating;
    $rideRequest->save();

    $passenger = $rideRequest->user;
    if ($passenger) {
        $oldTotal = $passenger->rating * $passenger->rating_count;
        $newCount = $passenger->rating_count + 1;
        $newAvg = round(($oldTotal + $request->rating) / $newCount);

        $passenger->rating = $newAvg;
        $passenger->rating_count = $newCount;
        $passenger->save();
    }

    return response()->json(['message' => 'Passenger rated successfully']);
}


public function getMyAvailableRides(Request $request)
{
    $user = auth()->guard('api')->user();
    $requestId = $request->request_id;

    $rideRequest = RideRequestModel::find($requestId);
    if (!$rideRequest) {
        return response()->json(['message' => 'Ride request not found'], 404);
    }

    $today = now()->toDateString();

    $rides = Ride::where('user_id', $user->id)
        ->where('status', 0)
        ->whereDate('date', '>=', $today)
        ->where('seats', '>=', $rideRequest->seats)
        ->whereDoesntHave('offers', function ($query) use ($requestId) {
            $query->where('request_id', $requestId);
        })
        ->get(['id', 'date', 'time', 'start_place', 'end_place', 'seats']);

    return response()->json($rides);
}

public function makeOffer(Request $request)
{
    $user = auth()->guard('api')->user();

    $validated = $request->validate([
        'request_id' => 'required|exists:ride_requests,id',
        'ride_id' => 'required|exists:rides,id',
        'price' => 'required|numeric|min:0',
    ]);

    // Check for existing offer
    $existingOffer = RideOffers::where('request_id', $validated['request_id'])
        ->where('ride_id', $validated['ride_id'])
        ->where('passenger', $user->id)
        ->first();

    if ($existingOffer) {
        return response()->json(['message' => 'Offer already exists for this ride and request.'], 409);
    }

    // Create the offer
    $offer = new RideOffers();
    $offer->ride_id = $validated['ride_id'];
    $offer->request_id = $validated['request_id'];
    $offer->price = $validated['price'];
    $offer->passenger = $user->id;
    $offer->status = 0; // pending
    $offer->picked_up = 0; // default

    $offer->save();

    return response()->json(['message' => 'Ride offer submitted successfully.'], 201);
}



}

