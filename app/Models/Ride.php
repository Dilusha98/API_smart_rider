<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppUsers;
use App\Models\VehicleModel;

class Ride extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'rides';

    protected $fillable = [
        'id',
        'user_id',
        'vehicle_id',
        'date',
        'time',
        'message',
        'seats',
        'start_lat',
        'start_lng',
        'start_place',
        'end_lat',
        'end_lng',
        'end_place',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(AppUsers::class, 'user_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_id');
    }

    // Ride.php
    public function offers()
    {
        return $this->hasMany(RideOffers::class, 'ride_id');
    }



}
