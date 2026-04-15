<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnlightensaunaFieldsToProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text("enlightensauna_size_weight_html")->nullable();
            $table->text("enlightensauna_features_html")->nullable();
            $table->text("enlightensauna_power_html")->nullable();
            $table->string("exim_link")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn("exim_link");
            $table->dropColumn("enlightensauna_size_weight_html");
            $table->dropColumn("enlightensauna_features_html");
            $table->dropColumn("enlightensauna_power_html");
        });
    }
}
