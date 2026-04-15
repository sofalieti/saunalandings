<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandBrandFeature extends Model
{
    protected $table = 'brand_brand_feature';
    
    public $timestamps = false;
    
    protected $fillable = [
        'position', 'value'
    ];
    
    protected $appends = array('type_name');
    
    public function brand_feature(){
        return $this->belongsTo(BrandFeature::class);
    }
    
    public function getTypeNameAttribute(){
        return $this->brand_feature->name;
    }
}
