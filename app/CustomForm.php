<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomForm extends Model
{
    public $timestamps = false;
    
    public function form_fields(){
        return $this->hasMany(FormField::class)->orderBy('position', 'ASC');
    }
    
    public function form_results(){
        return $this->hasMany(FormResult::class);
    }
}
