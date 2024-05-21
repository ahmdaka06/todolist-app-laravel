<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Todo extends Model
{
    use HasFactory, HashableId;

    const STATUS = [
        'waiting',
        'progress',
        'completed',
        'fail',
        'reject'
    ];

    const STATUS_COLOR = [
        'waiting' => '#FFBD00',
        'progress' => '#057BD1',
        'completed' => '#64FF33',
        'fail' => '#FF3333',
        'reject' => 'B30619'
    ];

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'started_at'
    ];

    protected $hidden = [
        'id',
        'user_id'
    ];

    protected $appends = ['hash'];

    protected $casts = [
        'started_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
