<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable flat-file content store
    |--------------------------------------------------------------------------
    |
    | When true, content models (Brand, Site, Category, ...) read/write via
    | the SQLite index built from content/ JSON files instead of MySQL.
    | form_results and admin_* tables always stay on the default DB connection.
    |
    */
    'enabled' => env('FLAT_CONTENT', false),

    /*
    |--------------------------------------------------------------------------
    | Auto-rebuild SQLite when content/ JSON is newer
    |--------------------------------------------------------------------------
    |
    | After git pull / rsync of content/, the next request rebuilds the index.
    | No manual `flat:build-index` needed. Disable only for debugging.
    |
    */
    'auto_rebuild' => env('FLAT_AUTO_REBUILD', true),

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    */
    'content_path' => base_path('content'),

    'sqlite_path' => storage_path('flat/content.sqlite'),

    /*
    |--------------------------------------------------------------------------
    | Content models that use the flat connection when enabled
    |--------------------------------------------------------------------------
    */
    'models' => [
        \App\Site::class,
        \App\Brand::class,
        \App\State::class,
        \App\BrandTextBlock::class,
        \App\BrandFaqItem::class,
        \App\TextBlock::class,
        \App\Category::class,
        \App\Product::class,
        \App\Article::class,
        \App\Menu::class,
        \App\PageTemplate::class,
        \App\PageBrandTemplate::class,
        \App\CategoryTemplate::class,
        \App\CategoryPageTemplate::class,
        \App\ModelLine::class,
        \App\ModelLineTemplate::class,
        \App\BrandFeature::class,
        \App\BrandBrandFeature::class,
        \App\CustomForm::class,
        \App\FormField::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tables synced into SQLite index (and exported from MySQL)
    |--------------------------------------------------------------------------
    */
    'tables' => [
        'sites',
        'brands',
        'states',
        'brand_states',
        'categories',
        'category_brands',
        'products',
        'articles',
        'text_blocks',
        'brand_text_blocks',
        'menus',
        'page_templates',
        'page_brand_templates',
        'category_templates',
        'category_page_templates',
        'model_lines',
        'brand_model_line',
        'model_line_templates',
        'brand_features',
        'brand_brand_feature',
        'brand_faq_items',
        'custom_forms',
        'form_fields',
    ],
];
