<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppWishList extends Model
{
	
    protected $table = 'app_wishlist';

    use HasFactory;

	protected $fillable = [
        'user_id',
        'product_id',
        'is_session',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

}
