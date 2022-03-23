<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('title');
            $table->string('slug')->nullable()->after('subtitle');
			$table->text('short_description')->nullable()->after('slug');
			$table->string('meta_keyword')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
           $table->dropColumn('subtitle');
           $table->dropColumn('slug');
           $table->dropColumn('short_description');
           $table->dropColumn('meta_keyword');
        });
    }
}
