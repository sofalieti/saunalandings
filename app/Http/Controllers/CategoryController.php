<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\CustomForm;
use App\FormField;
use Validator;

use App\Category;
use App\Product;
use App\Article;


class CategoryController extends Controller
{
    public function index(Request $request){
        
        $category = Category::withBrandAndSite()
                ->where('slug', $request->slug)
                ->where('active', true)
                ->firstOrFail();
        $products = $category->active_products()->paginate(20);
        return view(request()->get('layout').".categories.index", [
            'meta' => $this->get_meta($category),
            'category' => $category,
            'products' => $products,
            'category_slug' => $request->slug
        ]);
    }
    public function product(Request $request){
        $category = Category::withBrandAndSite()
                ->where('slug', $request->category_slug)
                ->where('active', true)
                ->firstOrFail();
        $product = $category->active_products()
                ->where('slug', $request->product_slug)
                ->where('active', true)
                ->firstOrFail();
        return view(request()->get('layout').".products.index", [
            'meta' => $this->get_meta($product->category, $product),
            'product' => $product,
            'category' => $category,
            'category_slug' => $category->slug
        ]);
    }
    
    public function template(Request $request){
        if($request->var_name == 'repair'){
            $repair = page_template('repair');
            
            $link = $repair->use_for_states ? 
                    route_with_state('page_template', ['slug' => $repair->var_name]) :
                    route('page_template_without_state', ['slug' => $repair->var_name]);
            
            return redirect($link, 301);
        }
        $category = Category::withBrandAndSite()
                ->where('slug', $request->category_slug)
                ->where('active', true)
                ->firstOrFail();
        $template = request()->get('brand')->site->category_templates()->where(['var_name' => $request->var_name, 'active' => true])->firstOrFail();
        
        $articles =$category->articles()->withBrandAndSite()->get();
        
        return view(request()->get('layout').".categories.{$request->var_name}", [
            'meta' => $this->get_meta($template, $category),
            'category' => $category,
            'articles' => $articles,
            'template' => $template
        ]);        
    }
    
    public function categories(Request $request){
        $categories = \App\Category::get_main_categories();
        return view(request()->get('layout').".categories.categories", [
            'categories' => $categories,
            'meta' => $this->get_meta(''),
        ]); 
    }
}
