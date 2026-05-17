<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
{
    use Sluggable;
    
    protected $fillable = [
        'name', 'site_id', 'domain', 'active', 'additional_domains', 'meta_title', 'meta_description',
        'meta_keywords', 'use_all_states',
        'og_title', 'og_description', 'og_image', 'og_type',
        'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image',
        'canonical_url', 'schema_org_json',
    ];
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    
    public function states()
    {
        return $this->belongsToMany(State::class, 'brand_states');
    }
    
    
    public function models()
    {
        return $this->belongsToMany(ModelLine::class);
    }
    
    public function active_models()
    {
        return $this->belongsToMany(ModelLine::class)->where('active', true);
    }
    
    
    
    public function site(){
        return $this->belongsTo(Site::class);
    }
    
    public function getAdditionalDomainsAttribute($value){
        return str_replace("|", "\n", $value);
    }
    
    public function brand_text_blocks(){
        return $this->hasMany(BrandTextBlock::class);
    }

    public function faq_items()
    {
        return $this->hasMany(BrandFaqItem::class)->orderBy('position');
    }
    
    public function page_brand_templates(){
        return $this->hasMany(PageBrandTemplate::class);
    }
    
    public function products(){
        return $this->hasMany(Product::class);
    }
    
    public static function boot(){
        parent::boot();
        
        self::created(function($brand){
            $brand->brand_text_blocks()->delete();
            foreach($brand->site->text_blocks as $block){
                $brand->brand_text_blocks()->create([
                    'site_id' => $block->site_id,
                    'name' => $block->name,
                    'var_name' => $block->var_name,
                    'description' => $block->description,
                    'text_block_id' => $block->id,
                    'active' => $block->active
                ]);
            }
            /*$brand->page_brand_templates()->delete();
            foreach($brand->site->page_templates as $template){
                $brand->page_brand_templates()->create([
                    'site_id' => $template->site_id,
                    'name' => $template->name,
                    'var_name' => $template->var_name,
                    'meta_title' => $template->meta_title,
                    'meta_description' => $template->meta_description,
                    'meta_keywords' => $template->meta_keywords,
                    'active' => $template->active,
                    'page_template_id' => $template->id
                ]);
            }*/
        });
        
        self::deleting(function($brand){
            $brand->brand_text_blocks()->delete();
            $brand->faq_items()->delete();
            //$brand->page_brand_templates()->delete();
        });
    }
    
    public function articles(){
        return $this->hasMany(Article::class);
    }
    
    public function brand_features(){
        return $this->belongsToMany(BrandFeature::class);
    }
    
    public function brand_feature_values(){
        return $this->hasMany(BrandBrandFeature::class)->orderBy('position', 'ASC');
    }
    
    public function categories(){
        return $this->belongsToMany(Category::class, 'category_brands');
    }
}
