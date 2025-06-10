<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleImage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'vehicle_image';
    protected $fillable = ['vehicle_id', 'image_name'];

    public function vehicle()
    {
        return $this->belongsTo(VehicleModel::class);
    }

    
}
