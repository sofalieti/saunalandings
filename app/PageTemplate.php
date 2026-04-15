<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageTemplate extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'var_name', 'meta_title', 'meta_keywords', 'meta_description', 'active', 'site_id', 'use_for_states',
        'show_articles'
    ];
    
    public static function boot(){
        parent::boot();
        
        self::created(function($template){
            foreach(Brand::where('site_id', $template->site_id)->get() as $brand){
                $brand->page_brand_templates()->create([
                    'site_id' => $template->site_id,
                    'name' => $template->name,
                    'var_name' => $template->var_name,
                    'meta_title' => $template->meta_title,
                    'meta_description' => $template->meta_description,
                    'meta_keywords' => $template->meta_keywords,
                    'active' => (int)$template->active,
                    'page_template_id' => $template->id
                ]);
            }
        });
        
        self::deleting(function($template){
            $template->page_brand_templates()->delete();
        });
    }
    
    public function page_brand_templates(){
        return $this->hasMany(PageBrandTemplate::class);
    }
}
