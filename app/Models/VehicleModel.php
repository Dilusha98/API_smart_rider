<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'vehicle';
    protected $fillable = [
        'id',
        'category',
        'brand',
        'owner',
        'status',
        'plate_number',
        'year',
        'fuel_type',
        'model',
        'max_seats'
    ];

    public function images()
    {
        return $this->hasMany(VehicleImage::class, 'vehicle_id');
    }

    public function ownerUser()
    {
        return $this->belongsTo(AppUser::class, 'owner');
    }
}
