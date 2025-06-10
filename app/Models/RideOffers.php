<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideOffers extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'ride_offers';

    protected $fillable = [
        'ride_id',
        'request_id',
        'passenger',
        'price',
        'status'
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }

    public function request()
    {
        return $this->belongsTo(RideRequestModel::class, 'request_id');
    }

    public function passengerUser()
    {
        return $this->belongsTo(AppUsers::class, 'passenger');
    }

}
