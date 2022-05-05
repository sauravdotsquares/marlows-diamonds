<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('pay_timestamp')->nullable()->after('user_id');
            $table->string('correlationid',250)->nullable()->after('pay_timestamp');
            $table->string('acknowledge',250)->nullable()->after('correlationid');
            $table->string('build',250)->nullable()->after('acknowledge');
            $table->string('token',250)->nullable()->after('build');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
