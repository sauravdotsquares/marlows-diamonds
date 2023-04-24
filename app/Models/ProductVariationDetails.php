<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationDetails extends Model
{
    use HasFactory;

    protected $table = 'product_variation_details';

    protected $fillable = [
        'variation_id','key','value',
    ];
    
    // protected $appends = ['product_id'];

    // public function getProductIdAttribute()
    // {
    //     return ProductVariations::where('id', $this->variation_id)->pluck('product_id');
    // }

    public function getProductId(){
        return $this->hasOne(ProductVariations::class,'id','variation_id');
    }
}
