<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
			$table->string('title');
			$table->string('subtitle')->nullable();
			$table->string('slug')->nullable();
			$table->text('short_description')->nullable();
			$table->text('description');
			$table->boolean('status')->default(1)->comment('1:Active, 0:Inactive');
			$table->string('image')->nullable();
			$table->text('meta_title')->nullable();
			$table->text('meta_description')->nullable();
			$table->string('meta_keyword')->nullable();
			$table->softDeletes();
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
        Schema::dropIfExists('posts');
    }
}
