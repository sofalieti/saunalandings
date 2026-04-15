<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Classes\CSCartApi;
use App\Brand;
use App\Category;
use App\Product;
use Image;
use Sunra\PhpSimple\HtmlDomParser;

class EximEnlightensauna extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exim:enlightensauna';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
        $this->info('Start');
        
        
        $cscartapi = new CSCartApi(
            array(
                'api_key' => 'SpaFj7059Ii28vM5b25iDI30X334wMJf',
                'user_login' => 'archinc@yandex.ru',
                'api_url' => 'https://enlightensauna.com/'
            )
        );

        try {
            $category_map = [
                "2 Person" => [
                    'Infrared Saunas' => 380,
                    'Hybrid Saunas' => 407,
                    'Traditional Saunas' => 418,
                ],
                "3 Person" => [
                    'Infrared Saunas' => 381,
                    'Hybrid Saunas' => 408,
                    'Traditional Saunas' => 419,
                ],
                "4 Person" => [
                    'Infrared Saunas' => 382,
                    'Hybrid Saunas' => 409,
                    'Traditional Saunas' => 420,
                ],
                "5 Person" => [
                    'Infrared Saunas' => 383,
                    'Hybrid Saunas' => 410,
                    'Traditional Saunas' => 421,
                ],
                "Corner" => [
                    'Infrared Saunas' => 384,
                    'Hybrid Saunas' => 411,
                    'Traditional Saunas' => 422,
                ]
            ];
            
            $site_id = 16;
            
            $this->info('Create categories');
            $parent_id = 69;
            $position = 0;
            $product_category_map = [];
            foreach($category_map as $cm_prefix => $cm){
                $position += 100;
                
                $parent_category = Category::firstOrCreate([
                    'exim_code' => $cm_prefix,
                    'site_id' => $site_id,
                    'name' => $cm_prefix
                ]);
                
                $parent_category->parent_id = $parent_id;
                $parent_category->position = $position;
                $parent_category->save();
                
                $this->info("Created {$cm_prefix}");
                
                foreach($cm as $type => $exim_code){
                    
                    $position += 100;
                    
                    $category = Category::firstOrCreate([
                        'exim_code' => $exim_code,
                        'site_id' => $site_id,
                        'name' => $type
                    ]);

                    $category->parent_id = $parent_category->id;
                    $category->position = $position;
                    $category->save();
                    
                    $product_category_map[$exim_code]= $category->id;

                    $this->info("- Created $type");
                }
            }
            
            $this->info('-------------');
            $this->info('Create products API');
            
            foreach($product_category_map as $outer_category_id => $category_id){

                $this->info("Category {$outer_category_id}");

                $api_products = $cscartapi->get("products?" . http_build_query([
                    'sort_by' => 'position',
                    'sort_order' => 'asc',
                    'status' => array('A', 'H'),
                    'limit' => 999,//Zcfvehfq1 Jyboerflatron
                    'cid' => $outer_category_id,
                    'pfull' => 'Y',
                    'pshort' => 'Y',
                    'pkeywords' => 'Y',
                    'extend' => ['description']
                ]));
                
                $position = 0;
                foreach($api_products['products'] as $api_product){
                    $position += 100;
                    $data = [
                        'exim_code' => "enlightensauna{$api_product->product_id}",
                        'name' => $api_product->product,
                        'exim_link' => "https://enlightensauna.com/{$api_product->seo_name}.html",
                        //'image' => $api_product->main_pair->detailed->image_path,
                        'description' => $api_product->full_description,
                        'category_id' => $category_id,
                        'position' => $position
                    ];
                        
                    
                    //Parse features
                    $link = "https://enlightensauna.com/{$api_product->seo_name}.html";
                    $this->info($link);
                    
                    $html = HtmlDomParser::str_get_html(file_get_contents($link));
                    $data['enlightensauna_size_weight_html'] = str_replace(["col-md-8","col-md-16" ], ["col-md-6","col-md-12" ], $html->find('#size-weight > div', 0)->innertext);
                    $data['enlightensauna_features_html'] = str_replace(["col-md-8","col-md-16" ], ["col-md-6","col-md-12" ], $html->find('#features > div', 0)->innertext);
                    $data['enlightensauna_power_html'] = str_replace(["col-md-8","col-md-16" ], ["col-md-6","col-md-12" ], $html->find('#power > div', 0)->innertext);
                    $this->info("Parse features");
                        
                    $product = Product::where('exim_code', $data['exim_code'])->first();
                    
                    if(!$product){
                        $product = Product::create($data);
                        $this->info("Created {$product->name}");
                    }else{
                        $product->update($data);
                        $this->info("Updated {$product->name}");
                    }
                    
                    //images
                    $image_path_info = pathinfo($api_product->main_pair->detailed->image_path);
                    $image_src = "/images/products/{$product->id}.".strstr($image_path_info['extension'], '?', true);
                    $image_path = '/var/www/landings/data/www/precisiontherapysaunapart.com/public/uploads'.$image_src;
                    Image::make($api_product->main_pair->detailed->image_path)->save($image_path);
                    $product->image = $image_src;
                    $product->save();
                    
                    //Thumb
                    $thumb = Image::make($image_path);
                    $thumb_src = "/images/products/{$product->id}_400.".strstr($image_path_info['extension'], '?', true);
                    $thumb_path = '/var/www/landings/data/www/precisiontherapysaunapart.com/public/uploads'.$thumb_src;
                    $thumb->resize(400, null, function ($const) {
                        $const->aspectRatio();
                    })->save($thumb_path);
                    
                    $this->info('Upload images');
                }
            }
            
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
