<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'id',
        'name',
        'image',
        'description',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public $timestamps = false;

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
