<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\ModelLine;
use App\Brand;
use App\Category;




class PageController extends Controller
{
    public function index(){
        //print_r(request()->get('layout'));
        //print_r(request()->get('state'));
        //print_r(request()->get('brand'));
        return view(request()->get('layout').".pages.index", [
            'meta' => $this->get_meta()
        ]);
    }
    
    public function set_state(Request $request){
        //echo $request->server('HTTP_REFERER');exit;
        if($request->server('HTTP_REFERER')){
            //page_template
            $url = $request->server('HTTP_REFERER');
            $route_name = app('router')->getRoutes()->match(app('request')->create($request->server('HTTP_REFERER')))->getName();
            if($route_name == 'page_template'){
                preg_match("/.*?:\/\/.*?\/(.*?)\//i", $url, $url_obj);
                if(isset($url_obj[1])){
                    $url = str_replace($url_obj[1], $request->state, $url);
                }
            }
        }else{
            $url = "/";
        }
        return redirect($url); 
    }
    
    public function page_template(Request $request){
        $template = request()->get('brand')->site->page_templates()->where(['var_name' => $request->slug, 'active' => true])->firstOrFail();
        $categories = Category::withBrandAndSite()->withArticles()->get();
        
        return view(request()->get('layout').".pages.{$request->slug}", [
            'meta' => $this->get_meta($template),
            'template' => $template,
            'categories' => $categories
        ]);        
    }
    
    public function get_banner_data(){
        $settings = $this->file_get_contents_curl('https://infraredsaunaparts.com/index.php?dispatch=links.get_custom_settings&secret1213124');
        
        
        file_put_contents(public_path().'/banner3.json', $settings);
        
        //$block = file_get_contents('https://infraredsaunaparts.com/index.php?dispatch=promotions.get_pr_banner1&secret1213124');
        //file_put_contents(public_path().'/banner.json', $block);

        
        //$block2 = file_get_contents('https://enlightensauna.com/index.php?dispatch=links.get_custom_settings&secret1213124');
        //file_put_contents(public_path().'/banner2.json', $block2);
        die('Banner updated');
    }
    
    private function file_get_contents_curl($url) {

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

        $data = curl_exec( $ch );
        curl_close( $ch );

        return $data;

      }
}
