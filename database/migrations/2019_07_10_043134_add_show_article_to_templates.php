<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowArticleToTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_templates', function (Blueprint $table) {
              $table->boolean('show_articles')->default(false);
        });
        Schema::table('category_templates', function (Blueprint $table) {
              $table->boolean('show_articles')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_templates', function (Blueprint $table) {
            $table->dropColumn('show_articles');
        });
        Schema::table('category_templates', function (Blueprint $table) {
            $table->dropColumn('show_articles');
        });
    }
}
