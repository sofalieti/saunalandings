<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormResult extends Model
{
    protected $fillable = [
        'form_name', 'data'
    ];
    public function custom_form(){
        return $this->belongsTo(CustomForm::class);
    }
}
