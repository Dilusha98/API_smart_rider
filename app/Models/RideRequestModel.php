<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideRequestModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ride_requests';
    protected $fillable = [
        'id',
        'user_id',
        'date',
        'pickup_lat',
        'pickup_lng',
        'dropoff_lat',
        'dropoff_lng',
        'distance',
        'drop_place',
        'pickup_place',
        'ride_id',
        'seats',
        'status',
        'time',
        'note',
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }

    public function user()
    {
        return $this->belongsTo(AppUsers::class, 'user_id');
    }
}
