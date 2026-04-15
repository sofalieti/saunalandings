<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePageTemplateAndBrandPageTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_templates', function (Blueprint $table) {
            $table->boolean('active')->default(false)->change();
        });
        Schema::table('page_brand_templates', function (Blueprint $table) {
            $table->boolean('active')->default(false)->change();
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
            $table->boolean('active')->default(true)->change();
        });
        Schema::table('page_brand_templates', function (Blueprint $table) {
            $table->boolean('active')->default(true)->change();
        });
    }
}
