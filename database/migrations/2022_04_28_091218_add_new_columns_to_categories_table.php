<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('enable_filter')->default(0)->comment('1:Enable, 0:Disable')->after('image_url');
            $table->integer('sort_order')->nullable()->after('enable_filter');
            $table->string('active_icon')->nullable()->after('sort_order');
            $table->string('hover_icon')->nullable()->after('active_icon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('enable_filter');
            $table->dropColumn('sort_order');
            $table->dropColumn('active_icon');
            $table->dropColumn('hover_icon');
        });
    }
}
