<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormResult extends Model
{
    /**
     * Always use the default (MySQL) connection — never the flat content store.
     * Required so CustomForm (flat) -> form_results (mysql) relations keep working.
     */
    public function getConnectionName()
    {
        return config('database.default', 'mysql');
    }

    protected $fillable = [
        'form_name', 'data'
    ];
    public function custom_form(){
        return $this->belongsTo(CustomForm::class);
    }
}
