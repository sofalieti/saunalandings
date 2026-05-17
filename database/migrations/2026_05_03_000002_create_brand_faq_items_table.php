<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandFaqItemsTable extends Migration
{
    public function up()
    {
        Schema::create('brand_faq_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('brand_id');
            $table->text('question');
            $table->text('answer');
            $table->integer('position')->default(0);
            $table->boolean('active')->default(true);

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->index('brand_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('brand_faq_items');
    }
}
