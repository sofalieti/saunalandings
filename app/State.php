<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class State extends Model
{
    use Sluggable;
    
    public $timestamps = false;
    
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
        return $this->belongsToMany(State::class);
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_brands');
    }
}
