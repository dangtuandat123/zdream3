<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider', 'model_slug', 'endpoint', 'category',
        'capabilities', 'param_schema', 'limits',
        'is_active', 'label', 'version', 'synced_at'
    ];

    protected $casts = [
        'capabilities' => 'array',
        'param_schema' => 'array',
        'limits' => 'array',
        'is_active' => 'boolean',
        'synced_at' => 'datetime',
    ];
}
