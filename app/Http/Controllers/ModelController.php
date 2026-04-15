<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\CustomForm;
use App\FormField;
use Validator;
use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\ModelLine;
use App\Brand;

class ModelController extends Controller {

    public function model(Request $request) {
        $model = ModelLine::get_active_models()->where('slug', $request->slug)->firstOrFail();
        $category = Category::withBrandAndSite()
                ->where('main_models_category', true)
                ->where('active', true)
                ->firstOrFail();


        return view(request()->get('layout') . ".models.index", [
            'meta' => $this->get_meta($model, $category),
            'slug' => $request->slug,
            'model' => $model,
            'category' => $category
        ]);
    }

    public function model_category(Request $request) {
        $model = ModelLine::get_active_models()->where('slug', $request->slug)->firstOrFail();

        $category = Category::withBrandAndSite()
                ->where('slug', $request->category_slug)
                ->where('active', true)
                ->firstOrFail();


        return view(request()->get('layout') . ".models.category", [
            'meta' => $this->get_meta($model, $category),
            'slug' => $request->slug,
            'model' => $model,
            'category' => $category
        ]);
    }
    
    public function template(Request $request){
        $model = ModelLine::get_active_models()->where('slug', $request->model_slug)->firstOrFail();
        $template = request()->get('brand')->site->model_line_templates()->where(['var_name' => $request->var_name, 'active' => true])->firstOrFail();
        
        return view(request()->get('layout').".models.{$request->var_name}", [
            'meta' => $this->get_meta($template, $model),
            'model' => $model,
            'template' => $template
        ]);        
    }

}
