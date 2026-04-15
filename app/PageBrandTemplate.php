<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageBrandTemplate extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'var_name', 'meta_title', 'meta_keywords', 'meta_description', 'active', 'site_id', 'brand_id', 'page_template_id'
    ];
    
    public function site(){
        return $this->belongsTo(Site::class);
    }
    
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
