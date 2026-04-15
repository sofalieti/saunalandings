<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextBlock extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'var_name', 'description', 'active'
    ];
    
    public function site(){
        return $this->belongsTo(Site::class);
    }
    
    public static function boot(){
        parent::boot();
        
        self::created(function($text_block){
            foreach(Brand::where('site_id', $text_block->site_id)->get() as $brand){
                $brand->brand_text_blocks()->create([
                    'site_id' => $text_block->site_id,
                    'name' => $text_block->name,
                    'var_name' => $text_block->var_name,
                    'description' => $text_block->description,
                    'text_block_id' => $text_block->id,
                    'active' => (int)$text_block->active
                ]);
            }
        });
        
        self::deleting(function($text_block){
            $text_block->brand_text_blocks()->delete();
        });
    }
    
    public function brand_text_blocks(){
        return $this->hasMany(BrandTextBlock::class);
    }
}
