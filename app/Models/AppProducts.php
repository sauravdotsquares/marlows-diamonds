<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProducts extends Model{
	
    protected $table = 'app_products';

    use HasFactory;

	protected $fillable = [
        'title',
        'slug',
        'tags',
        'is_variable',
        'dfinder_status',
        'diamond_shape',
        'short_description',
        'description',
        'sale_price',
        'regular_price',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'is_featured',
        'is_taxable',
        'status',
        'is_draft',
        'stock_status',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];
}
