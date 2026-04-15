<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFormFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_fields', function (Blueprint $table) {
            $table->string('type', 50);
            $table->string('css_class', 100)->nullable();
            $table->integer('position')->default(0);
            $table->string('select_and_radio_values', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_fields', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('css_class');
            $table->dropColumn('position');
            $table->dropColumn('select_and_radio_values');
        });
    }
}
