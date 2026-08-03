<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FlatFile\UsesFlatFiles;

class ModelLineTemplate extends Model
{
    use UsesFlatFiles;

    public $timestamps = false;
    
    protected $fillable = [
        'name', 'var_name', 'meta_title', 'meta_keywords', 'meta_description', 'active', 'site_id'
    ];
    
    public function site(){
        return $this->belongsTo(Site::class);
    }
}
