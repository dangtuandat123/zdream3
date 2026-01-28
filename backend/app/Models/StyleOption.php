<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StyleOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'style_id', 'label', 'group_name', 'prompt_fragment',
        'icon', 'thumbnail', 'sort_order', 'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function style()
    {
        return $this->belongsTo(Style::class);
    }
}
