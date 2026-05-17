<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('brands', BrandController::class);
    $router->get('brand_exim', 'BrandExportImportController@index')->name('brand_exim.index');
    $router->post('brand_exim/export', 'BrandExportImportController@export')->name('brand_exim.export');
    $router->post('brand_exim/import', 'BrandExportImportController@import')->name('brand_exim.import');
    $router->get('brand_exim/brands', 'BrandExportImportController@brandsForSite')->name('brand_exim.brands');
    $router->resource('states', StateController::class);
    $router->resource('brand_settings', BrandSettingController::class);
    $router->resource('forms', CustomFormController::class);
    $router->resource('form_results', FormResultController::class);
    $router->resource('sites', SiteController::class);
    $router->resource('categories', CategoryController::class);
    $router->resource('products', ProductController::class);
    $router->resource('model_lines', ModelLineController::class);
    $router->resource('articles', ArticleController::class);
    $router->resource('menus', MenuController::class);
    $router->resource('text_blocks', TextBlockController::class);
    $router->resource('brand_features', BrandFeatureController::class);
});
