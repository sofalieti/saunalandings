<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/admin/get_banner_data-secret121314125', 'PageController@get_banner_data');
Route::get('/sitemap.xml', 'SitemapController@index');
Route::post('/send_to_zoho_first_msg', 'JivositeController@send_to_zoho_first_msg')->name('send_to_zoho_first_msg');
Route::post('/send_to_zoho_contacts', 'JivositeController@send_to_zoho_contacts')->name('send_to_zoho_contacts');
Route::post('/send_to_zoho_events', 'JivositeController@send_to_zoho_events')->name('send_to_zoho_events');
Route::group(['middleware' => ['landing']], function () {
    Route::get('/', 'PageController@index')->name('home');
    Route::get('/{state}/set', 'PageController@set_state')->name('home_with_state');
    Route::post('/{state}/send_form', 'FormController@send_form')->name('send_form');
    Route::post('/send_pay_form', 'FormController@send_pay_form')->name('send_pay_form');
    
    
    //Articles
    Route::get("/article/{slug}", 'ArticleController@show')->name('article');
    
    //Catalog
    Route::get("/categories", 'CategoryController@categories')->name('categories');
    Route::get("/category/{category_slug}/{product_slug}", 'CategoryController@product')->name('product');
    Route::get("/category/{slug}", 'CategoryController@index')->name('category');
    Route::get("/category/page/{category_slug}/{var_name}", 'CategoryController@template')->name('category_template');
    
    //Model Lines
    Route::get("/model/{slug}", 'ModelController@model')->name('model');
    Route::get("/model/{category_slug}/{slug}", 'ModelController@model_category')->name('model_category');
    Route::get("/model/page/{model_slug}/{var_name}", 'ModelController@template')->name('model_template');
    
    
    //Temlates
    Route::get("/{state}/{slug}", 'PageController@page_template')->name('page_template');
    Route::get("/{slug}", 'PageController@page_template')->name('page_template_without_state');
    Route::get("/model_page/{slug}", 'PageController@page_template')->name('model_page_template_without_state');
    
});
