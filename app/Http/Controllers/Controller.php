<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function get_meta($obj = false, $obj2 = false, $obj3 = false)
    {
        switch (Route::currentRouteName()) {
            case 'home':
                return $this->applyPartsCategoryDefaultTitle([
                    'title' => empty(request()->get('brand')->meta_title) ? request()->get('brand')->site->seo_main_page_title : request()->get('brand')->meta_title,
                    'description' => empty(request()->get('brand')->meta_description) ? request()->get('brand')->site->seo_main_page_description : request()->get('brand')->meta_description,
                    'keywords' => empty(request()->get('brand')->meta_keywords) ? request()->get('brand')->site->seo_main_page_keywords : request()->get('brand')->meta_keywords,
                ]);
            case 'page_template':
                return $this->applyPartsCategoryDefaultTitle([
                    'title' => $obj->meta_title,
                    'description' => $obj->meta_description,
                    'keywords' => $obj->meta_keywords,
                ]);
            case 'page_template_without_state':
                return $this->applyPartsCategoryDefaultTitle([
                    'title' => $obj->meta_title,
                    'description' => $obj->meta_description,
                    'keywords' => $obj->meta_keywords,
                ]);
            case 'category_template':
                if (count($obj) && count($obj2)) {
                    return $this->applyPartsCategoryDefaultTitle([
                        'title' => str_replace('!category!', $obj2->name, $obj->meta_title),
                        'description' => str_replace('!category!', $obj2->name, $obj->meta_description),
                        'keywords' => str_replace('!category!', $obj2->name, $obj->meta_keywords),
                    ]);
                }
                // no break: прежнее поведение — переход к case 'category'
            case 'category':
                if (count($obj)) {
                    return $this->applyPartsCategoryDefaultTitle([
                        'title' => str_replace('!category!', $obj->name, request()->get('brand')->site->category_seo_main_page_title),
                        'description' => str_replace('!category!', $obj->name, request()->get('brand')->site->category_seo_main_page_description),
                        'keywords' => str_replace('!category!', $obj->name, request()->get('brand')->site->category_seo_main_page_keywords),
                    ]);
                }
                // no break
            case 'model_category':
                if (count($obj) && count($obj2)) {
                    return $this->applyPartsCategoryDefaultTitle([
                        'title' => str_replace(['!model!', '!category!'], [$obj->name, $obj2->name], request()->get('brand')->site->model_category_meta_title),
                        'description' => str_replace(['!model!', '!category!'], [$obj->name, $obj2->name], request()->get('brand')->site->model_category_meta_description),
                        'keywords' => str_replace(['!model!', '!category!'], [$obj->name, $obj2->name], request()->get('brand')->site->model_category_meta_keywords),
                    ]);
                }
                // no break
            case 'model':
                if (count($obj) && count($obj2)) {
                    return $this->applyPartsCategoryDefaultTitle([
                        'title' => str_replace(['!model!', '!category!'], [$obj->name, $obj2->name], request()->get('brand')->site->model_meta_title),
                        'description' => str_replace(['!model!', '!category!'], [$obj->name, $obj2->name], request()->get('brand')->site->model_meta_description),
                        'keywords' => str_replace(['!model!', '!category!'], [$obj->name, $obj2->name], request()->get('brand')->site->model_meta_keywords),
                    ]);
                }
                // no break
            case 'article':
                if (count($obj)) {
                    return $this->applyPartsCategoryDefaultTitle([
                        'title' => str_replace(['!article!'], [$obj->name], request()->get('brand')->site->article_meta_title),
                        'description' => str_replace(['!article!'], [$obj->name], request()->get('brand')->site->article_meta_description),
                        'keywords' => str_replace(['!article!'], [$obj->name], request()->get('brand')->site->article_meta_keywords),
                    ]);
                }
                // no break
            case 'product':
                if (count($obj) && count($obj2)) {
                    return $this->applyPartsCategoryDefaultTitle([
                        'title' => str_replace('!product!', $obj2->name, str_replace('!category!', $obj->name, request()->get('brand')->site->product_seo_main_page_title)),
                        'description' => str_replace('!product!', $obj2->name, str_replace('!category!', $obj->name, request()->get('brand')->site->product_seo_main_page_description)),
                        'keywords' => str_replace('!product!', $obj2->name, str_replace('!category!', $obj->name, request()->get('brand')->site->product_seo_main_page_keywords)),
                    ]);
                }
        }

        return $this->applyPartsCategoryDefaultTitle(null);
    }

    /**
     * Шаблон parts_category: если title пустой — "{Brand name} for Infrared Saunas".
     */
    protected function applyPartsCategoryDefaultTitle($meta)
    {
        if (request()->get('layout') !== 'parts_category' || !request()->get('brand')) {
            return $this->appendBrandSeoFields($meta);
        }

        if (!is_array($meta)) {
            $meta = ['title' => '', 'description' => '', 'keywords' => ''];
        }

        $title = isset($meta['title']) ? trim((string) $meta['title']) : '';
        if ($title === '') {
            $meta['title'] = trim(request()->get('brand')->name).' for Infrared Saunas';
        }

        return $this->appendBrandSeoFields($meta);
    }

    /**
     * Append extended SEO fields (OpenGraph, Twitter Card, Schema.org, FAQ)
     * from the current brand onto the $meta array.
     */
    protected function appendBrandSeoFields($meta)
    {
        $brand = request()->get('brand');

        if (!$brand || !is_array($meta)) {
            return $meta;
        }

        $meta['og_title']            = $brand->og_title;
        $meta['og_description']      = $brand->og_description;
        $meta['og_image']            = $brand->og_image;
        $meta['og_type']             = $brand->og_type ?: 'website';
        $meta['twitter_card']        = $brand->twitter_card ?: 'summary_large_image';
        $meta['twitter_title']       = $brand->twitter_title;
        $meta['twitter_description'] = $brand->twitter_description;
        $meta['twitter_image']       = $brand->twitter_image;
        $meta['canonical_url']       = $brand->canonical_url;
        $meta['schema_org_json']     = $brand->schema_org_json;
        $meta['faq_items']           = $brand->faq_items()->where('active', 1)->get();

        return $meta;
    }
}
