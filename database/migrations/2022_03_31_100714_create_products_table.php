<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title',180);
            $table->string('slug',250)->nullable();
            $table->string('tags',250)->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('categories');
            $table->decimal('sale_price',8,2)->nullable();
            $table->decimal('regular_price',8,2)->nullable();
            $table->string('meta_title',250)->nullable();
            $table->string('meta_keyword',250)->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('is_featured')->default(0); // 0 for Not featured and 1 for Featured;
            $table->tinyInteger('status')->default(0); // 0 for disable and 1 for enable;
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
        Schema::dropIfExists('products');
    }
}
