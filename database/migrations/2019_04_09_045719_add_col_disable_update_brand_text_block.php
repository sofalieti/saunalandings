<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColDisableUpdateBrandTextBlock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_text_blocks', function (Blueprint $table) {
            $table->boolean('disable_update')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_text_blocks', function (Blueprint $table) {
            $table->dropColumn('disable_update');
        });
    }
}
