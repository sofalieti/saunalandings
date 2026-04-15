<?php
use App\BrandTextBlock;
use Storage;
function get_favicon(){
    if(!empty(request()->get('brand')->favicon)){
        return '<link rel="shortcut icon" href="/uploads/'.request()->get('brand')->favicon.'">';
    }elseif(!empty(request()->get('brand')->site->favicon)){
        return '<link rel="shortcut icon" href="/uploads/'.request()->get('brand')->site->favicon.'">';
    }
    return '';
}
function get_logo(){
    if(!empty(request()->get('brand')->logo)){
        return "/uploads/".request()->get('brand')->logo;
    }elseif(!empty(request()->get('brand')->site->default_brand_logo)){
        return "/uploads/".request()->get('brand')->site->default_brand_logo;
    }
    return false;
}
function rt($text){
    $text = str_replace("!brand!", request()->get('brand')->name, $text);
    if(!request()->get('state')->default) {
        $text = str_replace("!state!", request()->get('state')->name, $text);
        $text = str_replace("!in_state!", "In ".request()->get('state')->name, $text);
        $text = str_replace("!state_slug!", request()->get('state')->slug, $text);
    }else{
        $text = str_replace("!state!", '', $text);
        $text = str_replace("!in_state!", '', $text);
        $text = str_replace("/!state_slug!", '', $text);
    }
    return $text;
}
function text_block($var_name){
    $text_block = request()->get('brand')->brand_text_blocks()->where(['var_name' => $var_name, 'active' => true])->first();
    if(count($text_block)){
        return rt($text_block->description);
    }
    return '';
}
function category_text_block($category, $text){
    $text = str_replace('!category!', $category->name, $text);
    return rt($text);
}
function page_template($var_name){
    $template = request()->get('brand')->site->page_templates()->where(['var_name' => $var_name, 'active' => true])->first();
    if(count($template)){
        return $template;
    }
    return false;
}
function model_template($var_name){
    $template = request()->get('brand')->site->model_line_templates()->where(['var_name' => $var_name, 'active' => true])->first();
    if(count($template)){
        return $template;
    }
    return false;
}
function category_template($var_name){
    $template = request()->get('brand')->site->category_templates()->where(['var_name' => $var_name, 'active' => true])->first();
    if(count($template)){
        return $template;
    }
    return false;
}
function generate_image($image, $folder = 'others', $action = 'resize', $width = null, $height = null){
    if($image){
        if(Storage::disk('admin')->exists($image)){
            if(!Storage::disk('admin')->exists($folder.$image)){
                $path = pathinfo(Storage::disk('admin')->path($folder.$image))['dirname'];
                if(!file_exists($path)){
                    mkdir($path, 0755, true);
                }
                if($action == 'resize'){
                    Image::make(Storage::disk('admin')->path($image))
                        ->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save(Storage::disk('admin')->path($folder.$image));
                }elseif($action == 'crop'){
                    $canvas = Image::canvas($width, $height);
                    $image_obj = Image::make(Storage::disk('admin')->path($image))->resize($width, $height, function($constraint){
                        $constraint->aspectRatio();
                    });
                    $canvas->insert($image_obj, 'center');
                    $canvas->save(Storage::disk('admin')->path($folder.$image));
                }
            }
            return Storage::disk('admin')->url($folder.$image);
        }else{
            return false;
        }
    }
}
function route_with_state($name, $params){
    $params['state'] = request()->get('state')->slug;
    return route($name, $params);
}

function get_promo_banner(){
    if(file_exists(public_path().'/banner.json')){
        $banner = file_get_contents(public_path().'/banner3.json');
        $banner = json_decode($banner, true);
        return $banner;
    }
    /*if(file_exists(public_path().'/banner.json')){
        $banner1 = file_get_contents(public_path().'/banner.json');
        $banner1 = json_decode($banner1, true);
        
        $banner2 = file_get_contents(public_path().'/banner2.json');
        $banner2 = json_decode($banner2, true);
        
        if(is_array($banner1) && is_array($banner2)){
            return array_merge($banner1, $banner2);
        }
    }*/
    return false;
}

function get_full_url(){
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domain = $_SERVER['HTTP_HOST'];
    return $protocol.$domain;
}
?>