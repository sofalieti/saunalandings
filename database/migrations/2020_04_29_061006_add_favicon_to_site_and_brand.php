<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFaviconToSiteAndBrand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('favicon')->nullable();
        });
        Schema::table('sites', function (Blueprint $table) {
            $table->string('favicon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('favicon');
        });
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('favicon');
        });
    }
}
