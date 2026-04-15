<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetasToSite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->string('category_seo_main_page_title')->nullable();
            $table->string('category_seo_main_page_description')->nullable();
            $table->string('category_seo_main_page_keywords')->nullable();
            $table->string('product_seo_main_page_title')->nullable();
            $table->string('product_seo_main_page_description')->nullable();
            $table->string('product_seo_main_page_keywords')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('category_seo_main_page_title');
            $table->dropColumn('category_seo_main_page_description');
            $table->dropColumn('category_seo_main_page_keywords');
            $table->dropColumn('product_seo_main_page_title');
            $table->dropColumn('product_seo_main_page_description');
            $table->dropColumn('product_seo_main_page_keywords');
        });
    }
}
