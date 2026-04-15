<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250)->unique();
            $table->string('slug', 250)->unique();
            $table->string('domain', 250)->unique();
            $table->boolean('active')->default(1);
            $table->string('additional_domains', 10000)->nullable();
            $table->string('template', 50);
            $table->timestamps();
            $table->index('name');
            
            $table->string('meta_title', 500)->nullable();
            $table->string('meta_description', 1000)->nullable();
            $table->string('meta_keywords', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
