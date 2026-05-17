<?php

namespace App\Admin\Controllers;

use App\Brand;
use App\BrandFeature;
use App\BrandFaqItem;
use App\State;
use App\Site;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use File;

class BrandController extends Controller {

    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content) {
        return $content
                        ->header('Index')
                        ->description('description')
                        ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content) {
        return $content
                        ->header('Detail')
                        ->description('description')
                        ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content) {
        return $content
                        ->header('Edit')
                        ->description('description')
                        ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content) {
        return $content
                        ->header('Create')
                        ->description('description')
                        ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid() {
        $grid = new Grid(new Brand);

        $grid->id('Id');
        $grid->name('Name');
        $grid->column('site.name', 'Site');
        $grid->domain('Domain');
        $grid->active('Active')->display(function($active) {
            return $active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
        });

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->like('Name', 'name');
            $filter->like('Domain', 'domain');
            $filter->like('Additional Domains', 'additional_domains');
            $filter->equal('site_id', 'Site')->select(Site::get()->pluck('name', 'id'));
        });



        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id) {
        $show = new Show(Brand::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->domain('Domain');
        $show->slug('Slug');
        $show->active('Active');
        $show->additional_domains('Additional domains');
        $show->meta_title('Title');
        $show->meta_description('Description');
        $show->meta_keywords('Keywords');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form() {
        $form = new Form(new Brand);

        $form->saving(function (Form $form) {
            $form->additional_domains = str_replace("\r", "", $form->additional_domains);
            $form->additional_domains = str_replace(" ", "", $form->additional_domains);
            $form->additional_domains = str_replace("\n", "|", $form->additional_domains);
        });

        $form->tab('General info', function ($form) {
            $form->image('main_image', 'Image')
                    ->move('images/brands/' . date('Y') . '/' . date('m') . '/' . date('d'))
                    ->uniqueName();
            $form->text('name', 'Name')->rules('required')->required();
            if (isset(request()->route()->parameters()['brand'])) {
                //$form->select('site_id', 'Site')->options(Site::all()->pluck('name', 'id'))->disable();
            } else {
                $form->select('site_id', 'Site')->options(Site::all()->pluck('name', 'id'))->rules('required')->required();
            }
            $form->text('domain', 'Domain')->rules('required')->required();
            $form->switch('active', 'Active')->default(1);
            $form->textarea('additional_domains', 'Additional domains')->help('Each domain from a new line');
            $form->image('favicon', 'Favicon')
                    ->move('images/brands/' . date('Y') . '/' . date('m') . '/' . date('d'))
                    ->uniqueName();
        })->tab('Seo', function ($form) {

            $form->text('meta_title', 'Title');
            $form->text('meta_description', 'Description');
            $form->text('meta_keywords', 'Keywords');

            $form->divider('OpenGraph');
            $form->text('og_title', 'OG Title')->help('Falls back to meta title if empty. Supports !brand! token.');
            $form->text('og_description', 'OG Description')->help('Falls back to meta description if empty.');
            $form->text('og_image', 'OG Image URL')->help('Absolute URL to the sharing image (1200×630 recommended).');
            $form->select('og_type', 'OG Type')
                ->options(['website' => 'website', 'article' => 'article', 'product' => 'product'])
                ->default('website');

            $form->divider('Twitter Card');
            $form->select('twitter_card', 'Card Type')
                ->options(['summary_large_image' => 'summary_large_image', 'summary' => 'summary'])
                ->default('summary_large_image');
            $form->text('twitter_title', 'Twitter Title')->help('Falls back to meta title if empty.');
            $form->text('twitter_description', 'Twitter Description')->help('Falls back to meta description if empty.');
            $form->text('twitter_image', 'Twitter Image URL');

            $form->divider('Technical');
            $form->text('canonical_url', 'Canonical URL')->help('Leave blank to use the current page URL automatically.');
            $form->textarea('schema_org_json', 'Schema.org JSON-LD')->rows(12)
                ->help('Paste a complete JSON-LD block (Organization, LocalBusiness, Service, etc.). Will be output as-is inside &lt;script type="application/ld+json"&gt;.');
        })->tab('FAQ', function ($form) {

            $form->hasMany('faq_items', 'FAQ Items', function ($form) {
                $form->number('position', 'Order')->default(0);
                $form->text('question', 'Question')->rules('required');
                $form->textarea('answer', 'Answer')->rows(4)->rules('required');
                $form->switch('active', 'Active')->default(1);
            });
        })->tab('States', function ($form) {

            $form->switch('use_all_states', 'Use All States')->default(0);
            $form->multipleSelect('states', 'States')->options(State::all()->pluck('name', 'id'));
        })->tab('Text blocks', function ($form) {

            $form->hasMany('brand_text_blocks', function ($form) {
                $form->text('name', 'Name')->disable();
                $form->text('var_name', 'Var name')->disable();
                $form->textarea('description', 'Description');
                $form->switch('active', 'Active')->default(true);
                $form->switch('disable_update', 'Disable update');
            })->disableCreate()->disableDelete();
        })->tab('Features', function ($form){
            $form->multipleSelect('brand_features', 'Features')
                ->options(BrandFeature::orderBy('position', 'asc')->get()->pluck('name','id'));
            
            $form->hasMany('brand_feature_values', function ($form) {
                $form->number('position', 'Position');
                $form->text('type_name')->disable();
                $form->textarea('value')->help("For select, checkbox multiply, radio - values with |, e.g. value1|value2|...|value n");
                
            });
        });
        /* ->tab('Page templates', function ($form) {

          $form->hasMany('page_brand_templates', function ($form) {
          $form->text('name', 'Name')->disable();
          $form->text('var_name', 'Var name')->disable();
          $form->text('meta_title', 'Meta title');
          $form->text('meta_keywords', 'Meta keywords');
          $form->textarea('meta_description', 'Meta description');
          $form->switch('active', 'Active')->default(true);
          })->disableCreate()->disableDelete();

          }) */;

        return $form;
    }

}
