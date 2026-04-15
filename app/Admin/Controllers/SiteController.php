<?php

namespace App\Admin\Controllers;

use App\Site;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use File;
use App\Brand;

class SiteController extends Controller {

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
        $grid = new Grid(new Site);

        $grid->id('Id');
        $grid->name('Name');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id) {
        $show = new Show(Site::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->template('Template');
        $show->seo_main_page_title('Seo main page title');
        $show->seo_main_page_description('Seo main page description');
        $show->seo_main_page_keywords('Seo main page keywords');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form() {
        $form = new Form(new Site);

        $form->tab('General info', function ($form) {
            $form->text('name', 'Name')->rules('required')->required();
            $layouts = [];
            foreach (File::allFiles(base_path() . '/resources/views/layouts') as $file) {
                $template = preg_replace("/.*?\/([a-z_\-0-9]*?)\.blade\.php/i", "$1", $file);
                $layouts [$template] = $template;
            }

            $form->select('template', 'Template')->options($layouts)->rules('required')->required();
            $form->text('google_analytics_id', 'Google analytics id');
            $form->text('jivosite_id', 'Jivosite id');
            $form->image('default_brand_logo', 'Default brand logo')
                    ->move('images/sites/' . date('Y') . '/' . date('m') . '/' . date('d'))
                    ->uniqueName();
            $form->image('favicon', 'Favicon')
                    ->move('images/sites/' . date('Y') . '/' . date('m') . '/' . date('d'))
                    ->uniqueName();
        })->tab('Seo', function ($form) {
            $form->html('<h4>Main page</h4>');
            $form->text('seo_main_page_title', 'Page title');
            $form->text('seo_main_page_description', 'Page description');
            $form->text('seo_main_page_keywords', 'Page keywords');
            $form->html('<h4>Category detail</h4>');
            $form->text('category_seo_main_page_title', 'Page title');
            $form->text('category_seo_main_page_description', 'Page description');
            $form->text('category_seo_main_page_keywords', 'Page keywords');
            $form->html('<h4>Product detail</h4>');
            $form->text('product_seo_main_page_title', 'Page title');
            $form->text('product_seo_main_page_description', 'Page description');
            $form->text('product_seo_main_page_keywords', 'Page keywords');
            $form->html('<h4>Model category</h4>');
            $form->text('model_category_meta_title', 'Page title');
            $form->text('model_category_meta_keywords', 'Page description');
            $form->text('model_category_meta_description', 'Page keywords');
            $form->html('<h4>Model detail</h4>');
            $form->text('model_meta_title', 'Page title');
            $form->text('model_meta_keywords', 'Page description');
            $form->text('model_meta_description', 'Page keywords');
            $form->html('<h4>Article detail</h4>');
            $form->text('article_meta_title', 'Page title');
            $form->text('article_meta_keywords', 'Page description');
            $form->text('article_meta_description', 'Page keywords');
        })->tab('Text blocks', function ($form) {
            $form->hasMany('text_blocks', function ($form) {
                $form->text('name', 'Name')->rules('required')->required();
                $form->text('var_name', 'Var name')->rules('required')->required();
                $form->textarea('description', 'Description');
                $form->switch('active', 'Active')->default(true);
                //$form->switch('update_brands', 'Update all brands info');
            });
        })->tab('Page templates', function ($form) {
            $form->hasMany('page_templates', function ($form) {
                $form->text('name', 'Name')->rules('required')->required();
                $form->text('var_name', 'Template name')->rules('required')->required();
                $form->text('meta_title', 'Meta title');
                $form->text('meta_keywords', 'Meta keywords');
                $form->textarea('meta_description', 'Meta description');
                $form->switch('active', 'Active')->default(true);
                $form->switch('use_for_states', 'Use for states')->default(false);
                $form->switch('show_articles', 'Show articles')->default(false);

                //$form->switch('update_brands', 'Update all brands info');
            });
        })->tab('Category templates', function ($form) {
            $form->hasMany('category_templates', function ($form) {
                $form->text('name', 'Name')->rules('required')->required();
                $form->text('var_name', 'Template name')->rules('required')->required();
                $form->text('meta_title', 'Meta title');
                $form->text('meta_keywords', 'Meta keywords');
                $form->textarea('meta_description', 'Meta description');
                $form->switch('active', 'Active')->default(true);
                $form->switch('show_articles', 'Show articles')->default(false);
                //$form->switch('update_brands', 'Update all brands info');
            });
        })->tab('Model templates', function ($form) {
            $form->hasMany('model_line_templates', function ($form) {
                $form->text('name', 'Name')->rules('required')->required();
                $form->text('var_name', 'Template name')->rules('required')->required();
                $form->text('meta_title', 'Meta title');
                $form->text('meta_keywords', 'Meta keywords');
                $form->textarea('meta_description', 'Meta description');
                $form->switch('active', 'Active')->default(true);
            });
        });

        return $form;
    }

}
