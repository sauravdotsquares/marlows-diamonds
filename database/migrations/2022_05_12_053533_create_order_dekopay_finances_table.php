<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDekopayFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_dekopay_finances', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('order_key');
            $table->string('finCodes',100);
            $table->integer('depositAmt');
            $table->decimal('totalAmts',8,2);
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
        Schema::dropIfExists('order_dekopay_finances');
    }
}
