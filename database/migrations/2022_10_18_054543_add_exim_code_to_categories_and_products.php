<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEximCodeToCategoriesAndProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('exim_code', 30)->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('exim_code', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('exim_code');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('exim_code');
        });
    }
}
