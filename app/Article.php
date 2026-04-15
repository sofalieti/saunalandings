<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Article extends Model
{
    use Sluggable;
    
    protected $fillable = [
        'name', 'slug', 'active', 'description', 'brand_id', 'site_id', 'category_id'
    ];
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    
    public function site(){
        return $this->belongsTo(Site::class);
    }
    
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function scopeWithBrandAndSite($query){
        return $query->where('site_id', request()->get('brand')->site->id)
            ->where(function($query){
                $query->whereDoesntHave('brand');
                $query->orWhereHas('brand', function($query){
                    $query->where('brand_id', request()->get('brand')->id);
                });
            });
    }
}
