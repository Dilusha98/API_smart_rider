<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    protected $table = 'product_attributes';

    public $timestamps = false;

    public function values()
    {
        return $this->hasMany(ProductAttributeValueMap::class);
    }
}
