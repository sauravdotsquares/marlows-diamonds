<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductVariations extends Model
{
    use HasFactory;

    protected $table = 'product_variations';

    protected $fillable = [
        'product_id',
        'sale_price',
        'regular_price',
        'mined_diamond',
        'mined_diamond_rrp',
        'lab_grown',
        'lab_grown_rrp',
        'stock_status',
        'vari_image',
        'vari_video',
        'multi_vari_video',
        'multi_vari_img',
    ];

    protected $appends = ['get_vari_attri_id','get_vari_details_id'];

    public function getGetVariAttriIdAttribute()
    {
        return ProductVariationAttributes::where('product_id',$this->product_id)->first();
    }
    public function getGetVariDetailsIdAttribute()
    {
        // $getVariId = self::where('product_id',$this->product_id)->pluck('id');
        return ProductVariationDetails::where('variation_id',$this->id)->select('variation_id','key','value')->get();
    }

    public function variDetails(){
        return $this->hasMany(ProductVariationDetails::class,'variation_id', 'id' );
        // return ProductVariationDetails::where('variation_id',$this->id)->select('variation_id','key','value')->get();
    }

    public function product(){
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

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
