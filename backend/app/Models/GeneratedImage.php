<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneratedImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'style_id', 'final_prompt', 'selected_options',
        'user_custom_input', 'generation_params', 'estimated_cost',
        'storage_path', 'provider_task_id', 'provider_polling_url',
        'provider_cost', 'legacy_provider_task_id',
        'status', 'error_message', 'credits_used'
    ];

    protected $casts = [
        'selected_options' => 'array',
        'generation_params' => 'array',
        'estimated_cost' => 'decimal:2',
        'provider_cost' => 'decimal:4',
        'credits_used' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function style()
    {
        return $this->belongsTo(Style::class);
    }
}
