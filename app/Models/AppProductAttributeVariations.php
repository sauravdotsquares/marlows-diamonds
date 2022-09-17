<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProductAttributeVariations extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'app_product_attribute_variations';

    use HasFactory;

	protected $fillable = [
        'name',
        'product_id',
        'attribute_id',
        'sale_price',
        'price',
        'image',
        'video',
        'stock',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];
}
