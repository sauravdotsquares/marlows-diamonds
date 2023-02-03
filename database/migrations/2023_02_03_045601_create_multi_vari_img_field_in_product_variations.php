<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiVariImgFieldInProductVariations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * php artisan make:migration create_multi_vari_img_field_in_product_variations
     */
    public function up()
    {
        Schema::table('product_variations', function($table) {
            $table->text('multi_vari_img')->default(null)->after('vari_image');
            $table->text('multi_vari_video')->default(null)->after('vari_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variations', function($table) {
            $table->dropColumn('multi_vari_img');
            $table->dropColumn('multi_vari_video');
        });
    }
}
