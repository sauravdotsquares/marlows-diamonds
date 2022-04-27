<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('order_id');
            $table->string('first_name',150);
            $table->string('last_name',150)->nullable();
            $table->string('country_id',10);
            $table->text('street_address_l1');
            $table->text('street_address_l2')->nullable();
            $table->string('town_city',190)->nullable();
            $table->string('state',190);
            $table->string('pin_code',10);
            $table->string('mobile',50);
            $table->string('email',190);
            $table->text('order_notes')->nullable();
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
        Schema::dropIfExists('customer_addresses');
    }
}
