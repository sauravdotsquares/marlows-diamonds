<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProductImages extends Model{
	
    protected $table = 'app_products_images';

    use HasFactory;

	protected $fillable = [
        'product_id',
        'image',
        'image_type',
        'size_in_bytes',
        'extension',
        'original_image_name',
        'metadata',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];
}
