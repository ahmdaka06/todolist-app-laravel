<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class UserActivity extends Model
{
    use HasFactory, HashableId;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address'
    ];

    protected $hidden = [
        'id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
