<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariations extends Model
{
    use HasFactory;

    protected $table = 'product_variations';

    protected $fillable = [
        'product_id',
        'sale_price',
        'regular_price',
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

}
