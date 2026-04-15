<?php

namespace App\Admin\Controllers;

use App\FormResult;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class FormResultController extends Controller
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
        $grid = new Grid(new FormResult);
        $grid->model()->orderBy('id', 'desc');
        $grid->id('Id');
        $grid->form_name('Form name');
        $grid->data('Data')->display(function($data) {
            $data = collect(json_decode($data, true))->map(function($data){
                return $data['name']." - ".$data['value'];
            })->toArray();
            return str_limit(join(', ', $data), 100, '...');
        });
        $grid->created_at('Created at')->display(function($created_at){
            return date('d.m.Y H:i', strtotime($created_at));
        });
        
        $grid->actions(function ($actions) {
            $actions->disableEdit();
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
        $show = new Show(FormResult::findOrFail($id));

        $show->id('Id');
        $show->form_name('Form name');
        $show->data('Data');
        $show->created_at('Created at');
        
         $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FormResult);

        $form->number('custom_form_id', 'Custom form id');
        $form->text('form_name', 'Form name');
        $form->text('data', 'Data');

        return $form;
    }
}
