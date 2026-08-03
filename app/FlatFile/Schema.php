<?php

namespace App\FlatFile;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema as SchemaFacade;

/**
 * Creates SQLite tables matching MySQL content schema (Laravel 5.7 compatible).
 */
class Schema
{
    /**
     * Drop and recreate all content tables on the flat connection.
     */
    public function migrate()
    {
        $schema = SchemaFacade::connection('flat');

        foreach (config('flat.tables') as $table) {
            $schema->dropIfExists($table);
        }

        $schema->create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('seo_main_page_title')->nullable();
            $table->text('seo_main_page_description')->nullable();
            $table->text('seo_main_page_keywords')->nullable();
            $table->string('template')->nullable();
            $table->text('category_seo_main_page_title')->nullable();
            $table->text('category_seo_main_page_description')->nullable();
            $table->text('category_seo_main_page_keywords')->nullable();
            $table->text('product_seo_main_page_title')->nullable();
            $table->text('product_seo_main_page_description')->nullable();
            $table->text('product_seo_main_page_keywords')->nullable();
            $table->text('model_category_meta_title')->nullable();
            $table->text('model_category_meta_keywords')->nullable();
            $table->text('model_category_meta_description')->nullable();
            $table->text('model_meta_title')->nullable();
            $table->text('model_meta_keywords')->nullable();
            $table->text('model_meta_description')->nullable();
            $table->text('article_meta_title')->nullable();
            $table->text('article_meta_keywords')->nullable();
            $table->text('article_meta_description')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->string('jivosite_id')->nullable();
            $table->text('default_brand_logo')->nullable();
            $table->text('favicon')->nullable();
        });

        $schema->create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('domain')->nullable();
            $table->boolean('active')->default(1);
            $table->text('additional_domains')->nullable();
            $table->timestamps();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->boolean('use_all_states')->default(0);
            $table->unsignedInteger('site_id')->nullable();
            $table->text('main_image')->nullable();
            $table->text('favicon')->nullable();
            $table->text('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type', 50)->default('website');
            $table->string('twitter_card', 50)->default('summary_large_image');
            $table->text('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->longText('schema_org_json')->nullable();
        });

        $schema->create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('default')->default(0);
        });

        $schema->create('brand_states', function (Blueprint $table) {
            $table->unsignedInteger('brand_id');
            $table->unsignedInteger('state_id');
            $table->index(['brand_id', 'state_id']);
        });

        $schema->create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('image')->nullable();
            $table->boolean('active')->default(1);
            $table->string('slug')->nullable();
            $table->integer('position')->default(0);
            $table->unsignedInteger('site_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->text('text')->nullable();
            $table->text('text_short')->nullable();
            $table->string('type')->nullable();
            $table->boolean('main_models_category')->default(0);
            $table->string('exim_code')->nullable();
        });

        $schema->create('category_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('brand_id');
        });

        $schema->create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('image')->nullable();
            $table->text('images')->nullable();
            $table->boolean('active')->default(1);
            $table->integer('position')->default(0);
            $table->text('description')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('brand_id')->nullable();
            $table->string('exim_code')->nullable();
            $table->text('enlightensauna_size_weight_html')->nullable();
            $table->text('enlightensauna_features_html')->nullable();
            $table->text('enlightensauna_power_html')->nullable();
            $table->text('exim_link')->nullable();
        });

        $schema->create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('active')->default(1);
            $table->text('description')->nullable();
            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('site_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->timestamps();
        });

        $schema->create('text_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('var_name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('site_id')->nullable();
            $table->boolean('active')->default(1);
        });

        $schema->create('brand_text_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('var_name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('site_id')->nullable();
            $table->unsignedInteger('text_block_id')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('disable_update')->default(0);
        });

        $schema->create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('link')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('target_blank')->default(0);
            $table->integer('position')->default(0);
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
        });

        $schema->create('page_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('var_name')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedInteger('site_id')->nullable();
            $table->boolean('use_for_states')->default(0);
            $table->boolean('show_articles')->default(0);
        });

        $schema->create('page_brand_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('var_name')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedInteger('site_id')->nullable();
            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('page_template_id')->nullable();
        });

        $schema->create('category_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('var_name')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedInteger('site_id')->nullable();
            $table->boolean('show_articles')->default(0);
        });

        $schema->create('category_page_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('var_name')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedInteger('site_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('category_template_id')->nullable();
        });

        $schema->create('model_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('image')->nullable();
            $table->boolean('active')->default(1);
            $table->integer('position')->default(0);
            $table->text('description')->nullable();
        });

        $schema->create('brand_model_line', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('brand_id');
            $table->unsignedInteger('model_line_id');
            $table->timestamps();
        });

        $schema->create('model_line_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('var_name')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedInteger('site_id')->nullable();
        });

        $schema->create('brand_features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->integer('position')->default(0);
            $table->string('type')->nullable();
        });

        $schema->create('brand_brand_feature', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('brand_feature_id')->nullable();
            $table->integer('position')->nullable()->default(0);
            $table->text('value')->nullable();
        });

        $schema->create('brand_faq_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('brand_id');
            $table->text('question');
            $table->text('answer');
            $table->integer('position')->default(0);
            $table->boolean('active')->default(1);
        });

        $schema->create('custom_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('header_text')->nullable();
            $table->text('footer_text')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('use_captcha')->default(0);
            $table->string('css_class')->nullable();
            $table->text('success_text')->nullable();
            $table->string('title')->nullable();
            $table->string('button_text')->nullable();
        });

        $schema->create('form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->unsignedInteger('custom_form_id')->nullable();
            $table->string('type')->nullable();
            $table->string('css_class')->nullable();
            $table->integer('position')->default(0);
            $table->text('select_and_radio_values')->nullable();
            $table->boolean('required')->default(0);
            $table->string('placeholder')->nullable();
            $table->string('zoho_field_type')->nullable();
        });
    }
}
