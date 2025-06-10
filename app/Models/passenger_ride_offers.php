<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppUsers;

class passenger_ride_offers extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'passenger_ride_offers';

    protected $fillable = [
        'p_ride_id',
        'driver',
        'price',
        'status',
        'ride_id'
    ];

    public function driver()
    {
        return $this->belongsTo(AppUsers::class, 'driver');
    }

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }

}
