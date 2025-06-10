<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AppUsers extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'appuser';
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'user_type',
        'gender',
        'rating',
        'rating_count'
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function userVerificationDocuments()
    {
        return $this->hasMany(\App\Models\UserVerification::class, 'user_id');
    }
}
