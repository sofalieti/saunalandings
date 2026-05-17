<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandFaqItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'brand_id', 'question', 'answer', 'position', 'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
