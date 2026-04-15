<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public $timestamps = false;
    
    public function brands(){
        return $this->hasMany(Brand::class);
    }
    
    public function text_blocks(){
        return $this->hasMany(TextBlock::class);
    }
    
    public function page_templates(){
        return $this->hasMany(PageTemplate::class);
    }
    
    public function active_page_templates(){
        return $this->hasMany(PageTemplate::class)->where('active', true);
    }
    
    public function category_templates(){
        return $this->hasMany(CategoryTemplate::class);
    }
    
    public function active_category_templates(){
        return $this->hasMany(CategoryTemplate::class)->where('active', true);
    }
    
    public function model_line_templates(){
        return $this->hasMany(ModelLineTemplate::class);
    }
    
    public function active_model_line_templates(){
        return $this->hasMany(ModelLineTemplate::class)->where('active', true);
    }
    
    public static function boot(){
        self::deleting(function($site){
            foreach($site->brands as $brand){
                $brand->delete();
            }
            $site->text_blocks()->delete();
            //$site->page_templates()->delete();
            //$site->category_templates()->delete();
        });
        
        parent::boot();
        
        self::saved(function($site){
            foreach($site->text_blocks as $block){              
                foreach($block->brand_text_blocks as $brand_block){
                    if(!$brand_block->disable_update){
                        $brand_block->active = $block->active;
                        $brand_block->description = $block->description;
                        $brand_block->name = $block->name;
                        $brand_block->var_name = $block->var_name;
                        $brand_block->save();
                    }
                }
            }
            /*foreach($site->page_templates as $template){
                $update_all = request()->get('page_templates')[$template->id]['update_brands'];
                foreach($template->page_brand_templates as $brand_template){
                    if($update_all == 'on'){
                        $brand_template->active = $template->active;
                        $brand_template->meta_title = $template->meta_title;
                        $brand_template->meta_keywords = $template->meta_keywords;
                        $brand_template->meta_description = $template->meta_description;
                    }
                    $brand_template->name = $template->name;
                    $brand_template->var_name = $template->var_name;
                    $brand_template->save();
                }
            }*/
            /*foreach($site->category_templates as $template){
                $update_all = request()->get('category_templates')[$template->id]['update_brands'];
                foreach($template->category_page_templates as $category_template){
                    if($update_all == 'on'){
                        $category_template->active = $template->active;
                        $category_template->meta_title = $template->meta_title;
                        $category_template->meta_keywords = $template->meta_keywords;
                        $category_template->meta_description = $template->meta_description;
                    }
                    $category_template->name = $template->name;
                    $category_template->var_name = $template->var_name;
                    $category_template->save();
                }
            }*/
        });
    }
    
    public function articles(){
        return $this->hasMany(Article::class);
    }
    
    public function categories(){
        return $this->hasMany(Category::class)->orderBy('position', 'asc');
    }
}
