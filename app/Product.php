<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'description', 'position', 'brand_id', 'exim_code',
        'enlightensauna_size_weight_html', 'enlightensauna_features_html',
        'enlightensauna_power_html', 'exim_link'
    ];
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
    
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    
    public function setImagesAttribute($images){
        if (is_array($images)) {
            $this->attributes['images'] = json_encode($images);
        }
    }

    public function getImagesAttribute($images){
        return json_decode($images, true);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function getImageThumbAttribute(){//thumbs
        return generate_image($this->image, 'thumbs', 'resize', 300);
    }
    public function getImageThumbCropAttribute(){//thumbs crop
        return generate_image($this->image, 'crops', 'crop', 300, 250);
    }
    public function getImageMediumAttribute(){//medium
        return generate_image($this->image, 'mediums', 'resize', 800);
    }
    
    public function getImageBigAttribute(){//big
        return generate_image($this->image, 'bigs', 'resize', 1800);
    }
    
    public function getImageThumbsAttribute(){//thumbs
        $images = [];
        if(is_array($this->images)){
            foreach($this->images as $image){
                $images []= generate_image($image, 'thumbs', 'resize', 300);
            }
        }
        return $images;
    }
    public function getImageMediumsAttribute(){//medium
        $images = [];
        foreach($this->images as $image){
            $images []= generate_image($this->image, 'mediums', 'resize', 800);
        }
        return $images;
    }
    
    public function getImageBigsAttribute(){//big
        $images = [];
        foreach($this->images as $image){
            $images []= generate_image($this->image, 'bigs', 'resize', 1800);
        }
        return $images;
    }
}
