<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFilterItems extends Model
{
    use HasFactory;

    protected $table = 'product_filter_items';

    protected $fillable = [
        'product_filter_id',
        'item_name',
        'item_slug',
        'item_id',
        'item_value',
        'min_price',
        'max_price',
        'is_active',
        'is_deleted'
    ];
}
