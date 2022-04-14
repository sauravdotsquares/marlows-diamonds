<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepnetDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repnet_data', function (Blueprint $table) {
            $table->id();
            $table->string('diamond_id')->nullable();
            $table->string('shape_title')->nullable();
            $table->string('weight')->nullable();
            $table->string('color_title')->nullable();
            $table->string('lab_title')->nullable();
            $table->string('repnet_price')->nullable();
            $table->string('final_price')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('vendor_stock_number')->nullable();
            $table->string('symmetry_title')->nullable();
            $table->string('polish_title')->nullable();
            $table->string('depth_percentage')->nullable();
            $table->string('table_percentage')->nullable();
            $table->string('meas_length')->nullable();
            $table->string('meas_width')->nullable();
            $table->string('meas_depth')->nullable();
            $table->string('girdle_size_min')->nullable();
            $table->string('girdle_size_max')->nullable();
            $table->string('culet_size_title')->nullable();
            $table->string('fluorescence_intensity_title')->nullable();
            $table->string('fancy_color_overtones')->nullable();
            $table->string('has_cert_file')->nullable();
            $table->string('currency_short_title')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('total_sales_price_in_currency')->nullable();
            $table->string('eye_clean_title')->nullable();
            $table->string('has_image_file')->nullable();
            $table->string('image_video_type_id')->nullable();
            $table->string('has_video')->nullable();
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
        Schema::dropIfExists('repnet_data');
    }
}
