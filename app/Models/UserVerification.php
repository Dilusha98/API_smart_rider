<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    use HasFactory;

    protected $table = 'user_verification_documents';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'type',
        'file_name',
        'status',
        'admin_note',
        'reviewed_by',
        'reviewed_at',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(AppUser::class, 'user_id');
    }

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // Accessors
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Rejected',
            default => 'Unknown',
        };
    }
}
