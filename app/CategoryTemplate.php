<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTemplate extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'var_name', 'meta_title', 'meta_keywords', 'meta_description', 'active', 'site_id',
        'show_articles'
    ];
    
    public static function boot(){
        parent::boot();
        
        self::created(function($template){
            foreach(Category::where('site_id', $template->site_id)->get() as $category){
                $category->category_page_templates()->create([
                    'site_id' => $template->site_id,
                    'name' => $template->name,
                    'var_name' => $template->var_name,
                    'meta_title' => $template->meta_title,
                    'meta_description' => $template->meta_description,
                    'meta_keywords' => $template->meta_keywords,
                    'category_template_id' => $template->id,
                    'active' => (int)$template->active
                ]);
            }
        });
        
        self::deleting(function($template){
            $template->category_page_templates()->delete();
        });
    }
    
    public function category_page_templates(){
        return $this->hasMany(CategoryPageTemplate::class);
    }
}
