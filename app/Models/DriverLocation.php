<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverLocation extends Model
{
    use HasFactory;

    protected $fillable = ['ride_id', 'lat', 'lng', 'captured_at'];

    public $timestamps = false;

    protected $dates = ['captured_at'];
}
