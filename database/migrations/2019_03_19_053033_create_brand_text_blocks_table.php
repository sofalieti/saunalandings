<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandTextBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_text_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('var_name');
            $table->text('description')->nullabel();
            $table->integer('brand_id');
            $table->integer('site_id');
            $table->integer('text_block_id');
            $table->boolean('active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_text_blocks');
    }
}
