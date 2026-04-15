<?php

namespace App\Http\Middleware;

use Closure;
use App\Brand;
use App\State;

class Landing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Штаты в ссылках
        $route_name = $request->route()->getName();
        $current_domain = strtolower($request->server("HTTP_HOST"));
        $states = State::where('active', true)->get();
        
        if(in_array($route_name, ['model_page_template_without_state', 'article', 'product', 'category', 
            'category_template', 'page_template_without_state', 'categories','model','model_category', 
            'model_template', 'send_pay_form'])){
            if(isset($_COOKIE['state'])){
                $state = json_decode($_COOKIE['state']);
                $current_state = $state->slug;
            }else{
                $default_state = State::where('active', 1)->where('default', 1)->first();
                if($default_state){
                    $current_state = $default_state->slug;
                }else{
                    die('404 Default State not found');
                    abort(404);
                    exit;                    
                }
            }
        }else{

            $path = $request->getPathInfo();		
            preg_match('/^\/(.{3,50}?)\/|^\/(.{3,50}?)$/i', $path, $state_result);	
            if(isset($state_result[2])){
                $current_state = $state_result[2];
            }elseif(isset($state_result[1])){
                $current_state = $state_result[1];
            }else{
                if(isset($_COOKIE['state'])){
                    $state = json_decode($_COOKIE['state']);
                    $current_state = $state->slug;
                }else{
                    $default_state = State::where('active', 1)->where('default', 1)->first();
                    if($default_state){
                        $current_state = $default_state->slug;
                    }else{
                        die('404 Default State not found');
                        abort(404);
                        exit;                    
                    }
                }
            }
        }
        
        

        
        $domain = Brand::where('active', 1)->where(function($query) use($current_domain){
            $query->where('domain', $current_domain);
            $query->orWhere(function($query) use($current_domain){
                preg_match("/(www\.(.*?)s\.)|((.*?)s\.)|(www\.(.*?)\.)|((.*?)\.)/i", $current_domain, $d_result);
                $d_result = array_values(array_diff($d_result, array('', NULL, false)));
                
                if(isset($d_result[2])){
                    $query->where('additional_domains', $d_result[2]);
                    $query->orWhere('additional_domains', 'like', "{$d_result[2]}|%");
                    $query->orWhere('additional_domains', 'like', "%|{$d_result[2]}|%");
                    $query->orWhere('additional_domains', 'like', "%|{$d_result[2]}");
                }
            });
        })->first();
		
        if($domain){
            $domain->domain = strtolower($domain->domain);
            if(isset($current_state)){
                $state = State::where('active', 1)->where('slug', $current_state)->first();
                if($state){
                    setcookie('state', json_encode($state->toArray()), time() + 60*60*24*7, '/'); 
                    if(!$domain->use_all_states){
                        $default_state = State::where('active', 1)->where('default', 1)->first();
                        if(!$domain->states()->where('slug', $current_state)->orWhere('slug', $default_state->slug)->first() && $default_state->slug != $current_state){
                            //die('404 State for this domain not found'); 
                            abort(404);
                            exit;
                        }
                        $states = $domain->states;
                        $states []= State::where('active', 1)->where('default', 1)->first();
                    }
                }else{
                    die('404 State not found');
                    abort(404);
                    exit;                   
                } 
            }
        }else{
            //die('404 domain no found');
            abort(404);
            exit;
        }
        
        if($current_domain != $domain->domain){
            $new_url = $request->fullUrl();
            $new_url = str_replace($current_domain, $domain->domain, $new_url);
            return redirect($new_url, 301); 
        }
		
        if(!file_exists(base_path().'/resources/views/layouts/'.$domain->site->template.".blade.php")){
            die('Template not found');
            abort(404);
            exit;
        }
        
        
        $request->attributes->add([
            'brand' => $domain, 
            'state' => $state ?? false,
            'layout' => $domain->site->template,
            'states' => $states
        ]);
        
        return $next($request);
        
        
        exit;
		
        //Ниже код для поддоменов
        
        $current_domain = strtolower($request->server("HTTP_HOST"));
        
        preg_match('/^(.*?)\.(.*?\..*)$/i', $current_domain, $state_search);
        if(isset($state_search[1]) && isset($state_search[2])){
            $current_state = $state_search[1];
            $current_domain = $state_search[2];
        }
        
        
        $domain = Brand::where('active', 1)->where(function($query) use($current_domain){
            $query->where('domain', $current_domain);
            $query->orWhere(function($query) use($current_domain){
                $query->where('additional_domains', $current_domain);
                $query->orWhere('additional_domains', 'like', "$current_domain|%");
                $query->orWhere('additional_domains', 'like', "%|$current_domain|%");
                $query->orWhere('additional_domains', 'like', "%|$current_domain");
            });
        })->first();
        
        if($domain){
            $domain->domain = strtolower($domain->domain);
            if(isset($current_state)){
                $state = State::where('active', 1)->where('slug', $current_state)->first();
                if($state){
                    if(!$domain->use_all_states){
                        if(!$domain->states()->where('slug', $current_state)->first()){
                            abort(404);
                            //die('404 State for this domain not found');
                        }
                        $states = $domain->states;
                        array_unshift($states, State::where('active', 1)->where('default', 1)->first());
                    }else{
                        $states = State::where('active', true)->get();
                    }
                }else{
                    die('404 State not found');
                }
            }
        }else{
            die('404 domain no found');
        }
        
        if($current_domain != $domain->domain){
            $new_url = $request->fullUrl();
            $new_url = str_replace($current_domain, $domain->domain, $new_url);
            return redirect($new_url, 301); 
        }
        
        if(!file_exists(base_path().'/resources/views/layouts/'.$domain->site->template.".blade.php")){
            die('Template not found');
        }
        
        $request->attributes->add([
            'brand' => $domain, 
            'state' => $state ?? false,
            'layout' => $domain->site->template,
            'states' => $states
        ]);
        
        return $next($request);
    }
}
