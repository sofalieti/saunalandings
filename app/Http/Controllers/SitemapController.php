<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Brand;
use App\State;
use App\Category;

class SitemapController extends Controller
{
    public function index(Request $request){
        //$domain = get_full_url();
        $current_domain = strtolower($request->server("HTTP_HOST"));
        $brand = Brand::where('active', 1)->where('domain', $current_domain)->firstOrFail();
        $request['brand'] = $brand;
        
        $links = [route('home')];
        
        //states
        if($brand->use_all_states){
            $states = State::where('active', true)->get();
        }else{
            $states = $brand->states;
            $states[] = State::where('active', 1)->where('default', 1)->first();
        }
        
        //pages
        foreach($brand->site->active_page_templates as $template){
            if($template->use_for_states){
                foreach($states as $state){
                    $links []= route('page_template', ['state' => $state->slug, 'slug' => $template->var_name]);
                }
            }else{
                $links []= route('page_template_without_state', ['slug' => $template->var_name]);
            }
        }
        
        //Categories
        $categories = Category::where('site_id', $brand->site->id)
            ->where('active', true)
            ->where(function($query) use($brand){
                $query->whereDoesntHave('brands');
                $query->orWhereHas('brands', function($query) use($brand){
                    $query->where('brand_id', $brand->id);
                });
            })
            ->get();
        foreach($categories as $category){
            $links []= route('category', ['slug' => $category->slug]);
            //products
            foreach($category->active_products as $product){
                $links []= route('product', ['category_slug' => $category->slug, 'product_slug' => $product->slug]);
            }
            
            //Category template
            foreach($brand->site->active_category_templates as $template){
                $links []= route('category_template', ['category_slug' => $category->slug, 'var_name' => $template->var_name]);
            }
        }
        
        //Models
        $mode_category = Category::where('main_models_category', true)->first();
        if(count($mode_category)){
            $categories = Category::where('site_id', $brand->site->id)
                ->where('active', true)
                ->where('parent_id', $mode_category->id)
                ->where(function($query) use($brand){
                    $query->whereDoesntHave('brands');
                    $query->orWhereHas('brands', function($query) use($brand){
                        $query->where('brand_id', $brand->id);
                    });
            })
            ->get();
            if(count($brand->active_models)){
                $models = $brand->active_models()->get();
            }else{
                $models = \App\ModelLine::whereDoesntHave('brands')->get();
            }

            foreach($models as $model){
                $links []= route('model', $model->slug);
                foreach($categories as $category){
                    $links []= route('model_category', ['category_slug' => $category->slug, 'slug' => $model->slug]);
                }
            }
        }
        
        return response()->view('sitemap', [
           'links' => $links
        ])->header('Content-type', 'text/xml');
    }
}
