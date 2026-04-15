<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{    
    public $timestamps = false;
    
    public function states(){
        return $this->hasMany(CountryState::class, "code", "country_code");
    }
}
