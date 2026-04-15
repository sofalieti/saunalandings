<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Brand;
use App\Category;
use App\Product;
use Image;

class EximParts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exim:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Update domain text');
        
        $old_domains = DB::connection('landings_old')->select('SELECT * FROM pages');
        foreach($old_domains as $old_domain){
            $brand = Brand::where('domain', $old_domain->domain)->first();
            if(count($brand)){
                $text_block = $brand->brand_text_blocks()->where('var_name', 'BRAND_TEXT')->first();
                if(count($text_block)){
                    $this->info($brand->domain);
                    $text = strip_tags($old_domain->text1);
                    if(strlen($text) > 30){
                        $text_block->disable_update = true;
                    }
                    $text_block->description = $text ?? "";
                    $text_block->save();
                }
            }
        }
        
        exit;
        $this->info('Import domains');
        $old_domains = DB::connection('landings_old')->select('SELECT * FROM pages');
        foreach($old_domains as $old_domain){
            if($old_domain->domain != 'default'){
                $site_id = 1;
                if($old_domain->template == 'app_category') $site_id = 13;
                if($old_domain->template == 'app_guru') $site_id = 14;
                $data = [
                    'name' => empty($old_domain->brand) ? $old_domain->domain : $old_domain->brand,
                    'domain' => $old_domain->domain,
                    'additional_domains' => $old_domain->domains,
                    'site_id' => $site_id
                ];
                
                $brand = Brand::firstOrCreate([
                    'name' => $data['name'], 
                    'domain' => $data['domain'], 
                    'site_id' => $data['site_id'],
                    'use_all_states' => true
                ]);
                $brand->additional_domains = $data['additional_domains'];
                $brand->save();
                
                //Main text
                if($site_id == 1){
                    $this->info('- Main text');
                    $main_text = $brand->brand_text_blocks()->where('var_name', 'main_page_text_block')->first();
                    if(trim(strip_tags($old_domain->text1)) != ''){
                        $main_text->disable_update = true;
                    }
                    $main_text->description = $old_domain->text1 ?? "";
                    $main_text->save();
                }else{
                    $this->info('- Main text');
                    $main_text = $brand->brand_text_blocks()->where('var_name', 'main_page_text_block')->first();
                    if(trim(strip_tags($old_domain->text1)) != ''){
                        $main_text->disable_update = true;
                    }
                    $main_text->description = $old_domain->text1 ?? "";
                    $main_text->save();
                }
                
                $this->info($brand->name);
            }
        }
        
        $this->info('Import categories');
        $old_categories = DB::connection('landings_old')->select('SELECT * FROM categories');
        foreach ($old_categories as $old_category){
            $category = Category::firstOrCreate([
                'name' => $old_category->name,
                'site_id' => 1
            ]);
            $category->active = true;
            $category->site_id = 1;
            $category->position = $old_category->position;
            $category->slug = $old_category->slug;
            $category->save();
            $this->info($category->name);
            
            $this->info('Import products');
            $old_products = DB::connection('landings_old')->select('SELECT * FROM products WHERE category_id = '.$old_category->id);
            foreach ($old_products as $old_product){
                $product = Product::firstOrCreate([
                    'name' => $old_product->name ?? 'empty',
                    'category_id' => $category->id
                ]);
                
                /*if(!empty($old_product->image)){
                    $image = 'https://wasaunapart.com/storage/'.$old_product->image;
                    $image_path_info = pathinfo($image);
                    $image_path = '/images/products/'.date('Y').'/'.date('m').'/'.date('d')."/{$product->id}.{$image_path_info['extension']}";
                    $product->image = $image_path;
                    Image::make($image)->save('/var/www/html/landings2.mxstd.ru/public/uploads'.$image_path);
                }*/
                
                if((int)$old_product->page_id > 0){
                    $old_page = DB::connection('landings_old')->select("SELECT * FROM pages WHERE id = {$old_product->page_id} LIMIT 1");
                    
                    if($old_page){
                        $brand = Brand::where('domain', $old_page[0]->domain)->first();
                        if($brand){
                            $product->brand_id = $brand->id;
                        }else{
                            print_r($old_page->domain);
                            exit;
                        }
                    }else{
                        $product->brand_id = 9999;
                    }
                    //print_r($brand->domain);
                }
                
                $product->description = $old_product->description;
                $product->position = $old_product->position ?? 0;
                $product->slug = $old_product->slug;
                $product->save();
                $this->info("-".$product->name);
            }
        }
        
    }
}
