<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Cviebrock\EloquentSluggable\Sluggable;

class ModelLine extends Model {

    use Sluggable;

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    //
    public $timestamps = false;
    protected $fillable = [
        'name', 'slug', 'image', 'active', 'position', 'description'
    ];

    public static function get_models() {


        return $results;
    }

    public function getImageOriginalAttribute() {
        if ($this->image) {
            if (Storage::disk('admin')->exists($this->image)) {
                return Storage::disk('admin')->url($this->image);
            } else {
                return false;
            }
        }
    }

    public function getImageThumbAttribute() {//thumbs
        return generate_image($this->image, 'thumbs', 'resize', 300);
    }

    public function getImageMediumAttribute() {//medium
        return generate_image($this->image, 'mediums', 'resize', 800);
    }

    public function getImageBigAttribute() {//big
        return generate_image($this->image, 'bigs', 'resize', 1800);
    }
   public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }
    
    static public function get_active_models(){
        if(count(request()->get('brand')->active_models)){
            return request()->get('brand')->active_models();
        }else{
            return \App\ModelLine::whereDoesntHave('brands');
        }
    }

}
