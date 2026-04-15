<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandBrandFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_brand_feature', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->integer('brand_feature_id');
            $table->integer('position')->nullable();
            $table->string('value', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_brand_feature');
    }
}
