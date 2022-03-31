<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__images', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('image_url');
            $table->tinyInteger('is_featured'); // 0= No Featured and 1 = Featured
            $table->tinyInteger('status'); // 0 = Disable and 1 = Enable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__images');
    }
}
