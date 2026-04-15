<?php

namespace App\Admin\Controllers;

use App\CustomForm;
use App\FormField;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CustomFormController extends Controller
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
        $grid = new Grid(new CustomForm);

        $grid->id('Id');
        $grid->name('Name');
        $grid->title('Title');
        $grid->column('Count Fields')->display(function($text) {
            return count($this->form_fields);
        });
        $grid->active('Active')->display(function($active) {
            return $active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
        });
        
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
    protected function detail($id)
    {
        $show = new Show(CustomForm::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->title('Title');
        $show->css_class('Css class');
        $show->header_text('Header text');
        $show->footer_text('Footer text');
        $show->active('Active');
        $show->use_captcha('Use captcha');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CustomForm);
        
        $form->tab('General info', function ($form) {
            $form->text('name', 'Name')->rules('required')->required();
            $form->text('title', 'Title')->rules('required')->required();
            $form->text('css_class', 'Css class');
            $form->text('button_text', 'Button text');
            $form->textarea('header_text', 'Header text');
            $form->textarea('footer_text', 'Footer text');
            $form->textarea('success_text', 'Success text')->rules('required')->required();
            $form->switch('active', 'Active')->default(1);
            $form->switch('use_captcha', 'Use captcha')->default(1);
        })->tab('Fields', function ($form) {
            $form->hasMany('form_fields', function ($form) {
                $form->text('name', 'Name')->rules('required')->required();
                $form->select('zoho_field_type', 'Zoho field type')->options(FormField::$zoho_field_types);
                $form->text('placeholder', 'Placeholder');
                $form->select('type', 'Type')->options(FormField::$types)->rules('required')->required();
                $form->switch('required', 'Required');
                $form->text('css_class', 'Css class');
                $form->number('position', 'Position')->default(100);
                $form->textarea('select_and_radio_values', 'Select/Radio values')->help('Example: key1:value1|key2:value2|...|keyN:valueN');
            });
        });

        return $form;
    }
}
