<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetaToSite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->string('model_category_meta_title', 500)->default('');
            $table->string('model_category_meta_keywords', 500)->default('');
            $table->string('model_category_meta_description', 500)->default('');
            $table->string('model_meta_title', 500)->default('');
            $table->string('model_meta_keywords', 500)->default('');
            $table->string('model_meta_description', 500)->default('');
            $table->string('article_meta_title', 500)->default('');
            $table->string('article_meta_keywords', 500)->default('');
            $table->string('article_meta_description', 500)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('model_category_meta_title');
            $table->dropColumn('model_category_meta_keywords');
            $table->dropColumn('model_category_meta_description');
            $table->dropColumn('model_meta_title');
            $table->dropColumn('model_meta_keywords');
            $table->dropColumn('model_meta_description');
            $table->dropColumn('article_meta_title');
            $table->dropColumn('article_meta_keywords');
            $table->dropColumn('article_meta_description');
        });
    }
}
