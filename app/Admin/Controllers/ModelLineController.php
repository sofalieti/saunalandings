<?php

namespace App\Admin\Controllers;

use App\ModelLine;
use App\Site;
use App\Brand;


use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;






class ModelLineController extends Controller {

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
        $grid = new Grid(new ModelLine);

        $grid->id('Id');
        $grid->name('Name');
        $grid->slug('Slug');
        $grid->image('Image');
        $grid->active('Active');
        $grid->position('Position');
        $grid->description('Description');
        
        $grid->filter(function($filter){
            $filter->like('Name', 'name');
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
        $show = new Show(ModelLine::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->slug('Slug');
        $show->image('Image');
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
    protected function form() {
        $form = new Form(new ModelLine);

        $form->text('name', 'Name');
        $form->text('slug', 'Slug');
        $form->image('image', 'Image');
        $form->switch('active', 'Active')->default(1);
        $form->number('position', 'Position');
        $form->textarea('description', 'Description');



          // if(isset(request()->route()->parameters()['model_line'])){
        //$model = ModelLine::find(request()->route()->parameters()['model_line']);
                 
        $form->multipleSelect('brands', 'Brands')->options(Brand::all()->pluck('name', 'id'));
      
        
      //  print_r ($model->brands());
         //   $form->multipleSelect('brands', 'Show only for brands')
         //          ->options($model->site->brands()->pluck('name', 'id'))
         //         ->help('Default is shown for all brands in site.');
        
           //}

        return $form;
    }

}
