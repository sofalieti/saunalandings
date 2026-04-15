<?php

namespace App\Admin\Controllers;

use App\Category;
use App\Site;
use App\Brand;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Tree;
use Encore\Admin\Facades\Admin;

class CategoryController extends Controller
{
    //use HasResourceActions;
    use ModelForm;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            
            $content->header('Categories');
            $content->body(Category::tree());
        });
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
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
    public function edit($id, Content $content)
    {
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
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Category::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->active('Active');
        $show->slug('Slug');
        $show->position('Position');
        $show->site_id('Site id');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null)
    {
        $categories = Category::categories_tree_for_select();
        if(isset(request()->route()->parameters()['category'])){
            unset($categories[request()->route()->parameters()['category']]);
        }
        
        
        $form = new Form(new Category);
        $form->tab('General info', function ($form) use ($categories) {
            $form->text('name', 'Name')->rules('required')->required();
            $form->text('slug', 'Slug');
            $form->select('parent_id', 'Parent')->options($categories);
            $form->switch('main_models_category', 'Main models category');
            if(isset(request()->route()->parameters()['category'])){
                
            }else{
                $form->select('site_id', 'Site')->options(Site::all()->pluck('name', 'id'))->rules('required')->required();
            }
            $form->switch('active', 'Active')->default(1);
            $form->image('image', 'Image')
                    ->move('images/categories/'.date('Y').'/'.date('m').'/'.date('d'))
                    ->uniqueName();
            $form->number('position', 'Position');
            $form->textarea('text', 'Text');
            $form->textarea('text_short', 'Text short');
            $form->text('type', 'Type');
        })->tab('Brands', function ($form) {
            if(isset(request()->route()->parameters()['category'])){
                
                $category = Category::find(request()->route()->parameters()['category']);
                $form->multipleSelect('brands', 'Show only for brands')
                        ->options($category->site->brands()->pluck('name', 'id'))
                        ->help('Default is shown for all brands in site.');
            }else{
                $form->html('After creating a category, you can select brands.');
            }
        })/*->tab('Category templates', function ($form) {
            
            $form->hasMany('category_page_templates', function ($form) {
                $form->text('name', 'Name')->disable();
                $form->text('var_name', 'Var name')->disable();
                $form->text('meta_title', 'Meta title');
                $form->text('meta_keywords', 'Meta keywords');
                $form->textarea('meta_description', 'Meta description');
                $form->switch('active', 'Active')->default(true);
            })->disableCreate()->disableDelete();
            
        })*/;
        
        $form->saving(function (Form $form) {
            $form->parent_id = (int)$form->parent_id;
        });

        return $form;
    }
}
