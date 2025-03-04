<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'name',
        'logo',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    protected $casts = ['status' => 'boolean'];
    public $timestamps = false;


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
