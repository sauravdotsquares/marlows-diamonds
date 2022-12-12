<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPricingUpdates extends Model
{
    use HasFactory;

    protected $table = 'product_pricing_updates';

    protected $fillable = [
        'product_id',
        'category_id',
        'type',
        'percentage',
        'is_applicable',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];
}
