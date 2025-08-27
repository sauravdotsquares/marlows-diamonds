<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
 

class LabPricesList extends Model
{
    use HasFactory;

    protected $table = 'lab_prices_list';

    protected $fillable = [
        'clarity',
        'color',
        'carat',
        'price',
        'is_active',
        'is_deleted'
    ];


    protected static function booted()
    {
        // Clear the featured products cache on any write operation
        $flush = function () {
            // If you use cache tags (Redis/Memcached), prefer tags:
            if (Cache::getStore() instanceof \Illuminate\Cache\TaggableStore) {
                Cache::tags(['products'])->forget('featured_products'); // if you used tags in Step 1
            } else {
                Cache::forget('featured_products');
            }
        };

        static::created($flush);
        static::updated($flush);
        static::deleted($flush);
        // static::restored($flush);
        // static::forceDeleted($flush);
    }

}
