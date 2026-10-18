<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiApiKey extends Model
{
    use HasFactory;

    protected $table = 'ai_api_keys';

    protected $fillable = [
        'name',
        'api_key',
        'is_active',
        'status',
        'last_used_at',
        'reset_quota_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
        'reset_quota_at' => 'datetime',
    ];
}