<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    public $timestamps = false;
    
    public static $types = [
        'text' => 'Text',
        'phone' => 'Phone',
        'email' => 'E-mail',
        'textarea' => 'Textarea',
        'select' => 'Select',
        'multi_select' => 'Multi Select',        
        'radio' => 'Radio Buttons',
        'checkbox' => 'Checkbox',
        'image' => 'Image',
        'custom_text' => 'Custom Text'
    ];
    
    public static $zoho_field_types = [
        'name' => 'Contact name',
        'phone' => 'Phone',
        'email' => 'E-mail'
    ];
    
    protected $fillable = [
        'name', 'type', 'css_class', 'position', 'select_and_radio_values', 'required', 'placeholder', 'zoho_field_type'
    ];
    
    public function custom_form(){
        return $this->belongsTo(CustomForm::class);
    }
    
    public function select_and_radio_values_obj(){
        $options = [];
        if(!empty($this->select_and_radio_values)){
            $opts = explode('|', $this->select_and_radio_values);
            if(is_array($opts)){
                foreach($opts as $opt){
                    $values = explode(":", $opt);
                    if(is_array($values)){
                        $options[$values[0]] = $values[1];
                    }
                }
            }
        }
        return $options;
    }
}
