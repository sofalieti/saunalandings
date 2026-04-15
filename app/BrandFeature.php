<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class BrandFeature extends Model
{
    use Sluggable;
    
    public static $types = [
        'string' => 'String',
        'text' => 'Text',
        'number' => 'Number',
        'checkbox' => 'Checkbox',
        'checkbox_multiply' => 'Checkbox multiply',
        'select' => 'Select',
        'select_multiply' => 'Select multiply',
        'radio' => 'Radio',
    ];
    
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'slug', 'position', 'type'
    ];
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    
    public function brands(){
        return $this->belongsToMany(Brand::class);
    }
    
}
