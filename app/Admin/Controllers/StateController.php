<?php

namespace App\Admin\Controllers;

use App\State;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class StateController extends Controller
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
        $grid = new Grid(new State);

        $grid->id('Id');
        $grid->name('Name');
        $grid->slug('Slug');
        $grid->active('Active')->display(function($active) {
            return $active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
        });
		$grid->default('Default')->display(function($default) {
            return $default ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
        });
        
        $grid->filter(function($filter){
            $filter->disableIdFilter();
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
    protected function detail($id)
    {
        $show = new Show(State::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->slug('Slug');
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
        $form = new Form(new State);

        $form->text('name', 'Name')->rules('required')->required();
        $form->text('slug', 'Slug');
        $form->switch('active', 'Active')->default(1);
		$form->switch('default', 'Default')->default(1);

        return $form;
    }
}
