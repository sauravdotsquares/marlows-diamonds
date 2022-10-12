<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProductImages extends Model{
	
    protected $table = 'app_products_images';

    use HasFactory;

	protected $fillable = [
        'parent_id',
        'belongs_from',
        'image',
        'image_type',
        'size',
        'extension',
        'original_name',
        'display_order',
        'metadata',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];
}
