<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Menu extends Model
{
    use Sluggable;
    
     use ModelTree, AdminBuilder;
     
     public function __construct(array $attributes = []){
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('position', 'ASC');
        $this->setTitleColumn('name');
    }
    
    protected $fillable = [
        'name', 'slug', 'active', 'target_blank', 'position', 'category_id', 'link', 'parent_id'
    ];
    
    public $timestamps = false;
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    
    public function category(){
        return $this->belongsTo(Category::class)->where('active', true);
    }
    
    public function childs(){
        return $this->hasMany(Menu::class, 'parent_id')->where('active', true)->orderBy('position', 'ASC');
    }
}
