<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValueMap extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_attribute_id',
        'value',
        'slug',
        'updated_at',
        'updated_by',
    ];

    protected $table = 'product_attribute_value_map';

    public $timestamps = false;

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }
}
