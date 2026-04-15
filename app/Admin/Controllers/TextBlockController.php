<?php

namespace App\Admin\Controllers;

use App\TextBlock;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Site;

class TextBlockController extends Controller
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
        $grid = new Grid(new TextBlock);
        $grid->name('Name');
        $grid->var_name('Var name');
        $grid->active('Active')->display(function($active) {
            return $active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
        });
        $grid->column('site.name', 'Site');
        
        $grid->filter(function($filter){
            $filter->disableIdFilter();
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
    protected function detail($id)
    {
        $show = new Show(TextBlock::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->var_name('Var name');
        $show->description('Description');
        $show->site_id('Site id');
        $show->active('Active');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TextBlock);

        $form->text('name', 'Name');
        $form->text('var_name', 'Var name');
        $form->redactor('description', 'Description');
        $form->select('site_id', 'Site')->options(Site::all()->pluck('name', 'id'))->rules('required')->required();
        $form->switch('active', 'Active');

        return $form;
    }
}
