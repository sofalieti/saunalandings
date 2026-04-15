<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandTextBlock extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'var_name', 'description', 'brand_id', 'site_id', 'active', 'text_block_id', 'disable_update'
    ];
    
    public function site(){
        return $this->belongsTo(Site::class);
    }
    
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
