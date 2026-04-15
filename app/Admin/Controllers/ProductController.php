<?php

namespace App\Admin\Controllers;

use App\Product;
use App\Category;
use App\Brand;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
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
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->id('Id');
        $grid->name('Name');
        $grid->slug('Slug');
        $grid->active('Active')->display(function($active) {
            return $active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
        });
        $grid->position('Position');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->slug('Slug');
        $show->image('Image');
        $show->images('Images');
        $show->active('Active');
        $show->position('Position');
        $show->description('Description');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product);
        
        $form->saving(function (Form $form) {
            $form->brand_id = (int)$form->brand_id;
        });
        
        if(request()->route()->parameters()['product'] ?? false){
           $site_id = (Product::find(request()->route()->parameters()['product'])->category->site_id) ?? false;
        }

        $form->tab('General info', function ($form) {
            
            $form->text('name', 'Name')->rules('required')->required();
            $form->select('category_id', 'Category')->options(Category::categories_tree_for_select())->rules('required')->required();
            $form->switch('active', 'Active')->default(1);
            $form->number('position', 'Position');
            $form->textarea('description', 'Description');
            
        })->tab('Images', function ($form) {
            
            $form->image('image', 'Image')
                    ->move('images/products/'.date('Y').'/'.date('m').'/'.date('d'))
                    ->uniqueName();
            $form->multipleImage('images', 'Images')
                ->move('images/products/additionals/'.date('Y').'/'.date('m').'/'.date('d'))
                ->uniqueName()
                ->removable();
            
        })->tab('Brand', function ($form) {            
            $form->select('brand_id', 'Use Only Brand')->options(Brand::orderBy('name', 'ASC')->pluck('name', 'id'));            
        });
        
        if(isset($site_id) && $site_id == 16){
            $form->tab('Enlightensauna fields', function ($form) {     
                $form->text('exim_link', 'Link');
                $form->textarea('enlightensauna_size_weight_html', 'Size/Weight');  
                $form->textarea('enlightensauna_features_html', 'Features');
                $form->textarea('enlightensauna_power_html', 'Power');
            });
        }

        return $form;
    }
}
