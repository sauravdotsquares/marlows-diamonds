<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepnetData extends Model
{
    use HasFactory;
    protected $table = 'repnet_data';
    protected $fillable = [
        'diamond_id',
        'shape_title',
        'weight',
        'color_title',
        'lab_title',
        'repnet_price',
        'final_price',
        'certificate_number',
        'vendor_stock_number',
        'symmetry_title',
        'polish_title',
        'depth_percentage',
        'table_percentage',
        'meas_length',
        'meas_width',
        'meas_depth',
        'girdle_size_min',
        'girdle_size_max',
        'culet_size_title',
        'fluorescence_intensity_title',
        'fancy_color_overtones',
        'has_cert_file',
        'currency_short_title',
        'currency_symbol',
        'total_sales_price_in_currency',
        'eye_clean_title',
        'has_image_file',
        'image_video_type_id',
        'has_video',
    ];
}
