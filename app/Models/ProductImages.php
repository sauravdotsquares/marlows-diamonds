<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductImages extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    protected $fillable = [
        'product_id','thumb_image_url','image_url','is_featured','status','type','extension','size'
    ];

    protected static function booted()
    {
        // Clear the products cache on any write operation
        $flush = function () {
            // If you use cache tags (Redis/Memcached), prefer tags:
            if (Cache::getStore() instanceof \Illuminate\Cache\TaggableStore) {
                Cache::tags(['products'])->forget('featured_products'); // if you used tags in Step 1
            } else {
                Cache::forget('featured_products');
            }
            Cache::forget('choosediamond');
            Cache::forget('featuredproduct');
            Cache::forget('visitOurShowrooms');
        };

        static::created($flush);
        static::updated($flush);
        static::deleted($flush);
        // static::restored($flush);
        // static::forceDeleted($flush);
    }
}
