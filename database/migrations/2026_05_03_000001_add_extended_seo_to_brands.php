<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtendedSeoToBrands extends Migration
{
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->text('og_title')->nullable()->after('meta_keywords');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->string('og_type', 50)->default('website')->after('og_image');
            $table->string('twitter_card', 50)->default('summary_large_image')->after('og_type');
            $table->text('twitter_title')->nullable()->after('twitter_card');
            $table->text('twitter_description')->nullable()->after('twitter_title');
            $table->string('twitter_image')->nullable()->after('twitter_description');
            $table->string('canonical_url')->nullable()->after('twitter_image');
            $table->longText('schema_org_json')->nullable()->after('canonical_url');
        });
    }

    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn([
                'og_title', 'og_description', 'og_image', 'og_type',
                'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image',
                'canonical_url', 'schema_org_json',
            ]);
        });
    }
}
