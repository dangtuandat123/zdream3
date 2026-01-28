<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'thumbnail_url', 'description', 'price',
        'provider_model_id', 'legacy_provider_model_id',
        'base_prompt', 'config_payload',
        'is_active', 'allow_user_custom_prompt', 'sort_order',
        'capabilities', 'image_slots', 'system_images',
        'tag_id'
    ];

    protected $casts = [
        'config_payload' => 'array',
        'capabilities' => 'array',
        'image_slots' => 'array',
        'system_images' => 'array',
        'is_active' => 'boolean',
        'allow_user_custom_prompt' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function options()
    {
        return $this->hasMany(StyleOption::class)->orderBy('sort_order');
    }

    public function generatedImages()
    {
        return $this->hasMany(GeneratedImage::class);
    }
}
