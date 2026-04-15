<?php

namespace App\Admin\Controllers;

use App\Menu;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Category;

use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Tree;
use Encore\Admin\Facades\Admin;

class MenuController extends Controller
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
        return Admin::content(function (Content $content) {            
            $content->header('Menu');
            $content->body(Menu::tree());
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
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Menu);
        $grid->name('Name');
        $grid->link('Link');
        $grid->active('Active');
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
        $show = new Show(Menu::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->slug('Slug');
        $show->active('Active');
        $show->target_blank('Target blank');
        $show->position('Position');
        $show->category_id('Category id');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $menus = Menu::where('category_id', 0)->orderBy('position', 'ASC')->get()->pluck('name', 'id');
        
        if(isset(request()->route()->parameters()['menu'])){
            unset($menus[request()->route()->parameters()['menu']]);
        }
        
        $form = new Form(new Menu);

        $form->text('name', 'Name')->rules('required')->required();
        $form->text('slug', 'Slug');
        $form->select('parent_id', 'Parent')->options($menus);
        $form->text('link', 'Link');
        $form->switch('active', 'Active')->default(1);
        $form->switch('target_blank', 'Target blank');
        $form->number('position', 'Position');
        $form->select('category_id', 'Category')->options(Category::categories_tree_for_select());
        
        $form->saving(function (Form $form) {
            $form->category_id = (int)$form->category_id;
            $form->parent_id = (int)$form->parent_id;
        });

        return $form;
    }
}
