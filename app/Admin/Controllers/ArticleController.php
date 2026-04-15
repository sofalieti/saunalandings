<?php

namespace App\Admin\Controllers;

use App\Article;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

use App\Site;
use App\Category;
use App\Brand;

class ArticleController extends Controller
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
        $grid = new Grid(new Article);

        $grid->id('Id');
        $grid->name('Name');
        $grid->active('Active')->display(function($active) {
            return $active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
        });
        $grid->column('site.name', 'Site');
        $grid->column('brand.name', 'Brand');
        $grid->column('category.name', 'Category');

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
        $show = new Show(Article::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->active('Active');
        $show->description('Description');
        $show->brand_id('Brand id');
        $show->site_id('Site id');
        $show->category_id('Category id');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        
        $form = new Form(new Article);

        $form->text('name', 'Name')->required();
        $form->text('slug', 'Slug')->required();
        $form->switch('active', 'Active')->default(1);
        $form->redactor('description', 'Description')->required();
        $form->select('site_id', 'Site')->options(Site::all()->pluck('name', 'id'))->rules('required')->required();
        $form->select('brand_id', 'Brand')->options(Brand::all()->pluck('name', 'id'));
        $form->select('category_id', 'Category')->options(Category::categories_tree_for_select())->rules('required')->required();
        
        $form->saving(function (Form $form) {
            $form->brand_id = (int)$form->brand_id;
        });
        
        return $form;
    }
}
