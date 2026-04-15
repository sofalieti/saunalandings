<?php

namespace App;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Storage;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Category extends Model
{
    protected $fillable = [
        'name', 'site_id', 'text', 'text_short', 'type', 'exim_code'
    ];
    
    use Sluggable;
    use ModelTree, AdminBuilder;
    public $timestamps = false;
    
    public function __construct(array $attributes = []){
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('position', 'ASC');
        $this->setTitleColumn('name');
    }
    
    public function site(){
        return $this->belongsTo(Site::class);
    }
    
    public function childs(){
        return $this->hasMany(Category::class, 'parent_id')->WithBrandAndSite();
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
    public function active_products(){
        return $this->hasMany(Product::class)
                ->where('active', true)
                ->where(function($query){
                    $query->where('brand_id', 0);
                    $query->orWhere('brand_id', request()->get('brand')->id);
                });
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'category_brands');
    }
    
    public function scopeWithUniqueSlugConstraints(Builder $query, Model $model, $attribute, $config, $slug){
        //return $query->where('site_id', $model->site_id);
    }
    
    public function getImageOriginalAttribute(){
        if($this->image){
            if(Storage::disk('admin')->exists($this->image)){
                return Storage::disk('admin')->url($this->image);
            }else{
                return false;
            }
        }
    }
    public function getTestTestAttribute(){
        return $this->name.'rararwar';
    }
    public function getImageThumbAttribute(){//thumbs
        return generate_image($this->image, 'thumbs', 'resize', 300);
    }
    public function getImageMediumAttribute(){//medium
        return generate_image($this->image, 'mediums', 'resize', 800);
    }
    
    public function getImageBigAttribute(){//big
        return generate_image($this->image, 'bigs', 'resize', 1800);
    }
    
    public static function get_main_categories($parent_id = 0){
        return Category::WithBrandAndSite()
                ->where('parent_id', $parent_id)
                ->orderBy('position', 'ASC')
                ->orderBy('name', 'ASC')
                ->get();
    }
    
    public function scopeWithBrandAndSite($query)
    {
        return $query->where('site_id', request()->get('brand')->site->id)
            ->where(function($query){
                $query->whereDoesntHave('brands');
                $query->orWhereHas('brands', function($query){
                    $query->where('brand_id', request()->get('brand')->id);
                });
            });
    }
    
    public function scopeWithArticles($query)
    {
        return $query->whereHas('articles', function($query){
            $query->where('site_id', request()->get('brand')->site->id);
            $query->where(function($query){
                $query->whereDoesntHave('brand');
                $query->orWhereHas('brand', function($query){
                    $query->where('brand_id', request()->get('brand')->id);
                });
            });
        });
    }
    
    static public function get_categories_tree($current_category_id, $site_id = false, $parent_id = 0, $i = 1){
        static $tree = [];
        if($parent_id == 0) $i = 1;
        $categories = Category::orderBy('position', 'ASC')
                ->where('parent_id', $parent_id)
                ->where('id', '!=', $current_category_id);
        if($site_id != false){
            $categories->where('site_id', $site_id);
        }
        $categories = $categories->get();
        
        foreach($categories as $category){
            $tree[$category->id] = $category->name;
            //if(count($category->childs)){
            //    self::get_categories_tree($site_id, $category->id, $i++);
            //}
        }
        return $tree;
    }
    
    public function category_page_templates(){
        return $this->hasMany(CategoryPageTemplate::class);
    }
    
    public function active_category_page_templates(){
        return $this->hasMany(CategoryPageTemplate::class)->where('active', true);
    }
    
    public static function boot(){
        parent::boot();
        
        self::created(function($category){
            $category->category_page_templates()->delete();
            foreach($category->site->category_templates as $template){
                $category->category_page_templates()->create([
                    'site_id' => $template->site_id,
                    'name' => $template->name,
                    'var_name' => $template->var_name,
                    'meta_title' => $template->meta_title,
                    'meta_description' => $template->id,
                    'meta_keywords' => $template->meta_keywords,
                    'active' => $template->active,
                    'category_template_id' => $template->id
                ]);
            }
        });
        
        self::deleting(function($category){
            $category->category_page_templates()->delete();
        });
    }
    
    public function articles(){
        return $this->hasMany(Article::class);
    }
    
    static public function categories_tree($parent_id = 0, $level = 1){        
        $categories = [];

        foreach(Category::where('parent_id', $parent_id)->get() as $category)
        {
            $categories []= [
                'item' => $category,
                'level' => $level,
                'children' => self::categories_tree($category->id, $level+1)
            ];
        }

        return $categories;
    }
    
    static function categories_tree_for_select($parent_category = true){
        static $categories = [];
        if($parent_category === true){
            $find_categories = self::categories_tree();
        }else{
            $find_categories = $parent_category;
        }
        foreach($find_categories as $category){
            $categories [$category['item']->id] = ($category['level'] > 1 ? str_repeat('-', $category['level']-1)." " : "").$category['item']->name;
            if($category['children']){
                self::categories_tree_for_select($category['children']);
            }
        }
        return $categories;
    }
}
