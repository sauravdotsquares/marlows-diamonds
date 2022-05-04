<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title','slug','tags','is_variable','diamond_shape','short_description','description','categories','sale_price','regular_price','meta_title','meta_keyword','meta_description','status','dfinder_status','is_featured','is_taxable','stock_status'
    ];

    protected $appends = ['cat_details','ProductVariationMinMaxPrice'];

    public function getProductImages(){
        return $this->hasOne(ProductImages::class,'product_id','id')->where('is_featured',1);
    }
    
    public function getProductGallery(){
        return $this->hasMany(ProductImages::class,'product_id','id');
    }

    public function getProductVariation(){
        return $this->hasMany(ProductVariations::class,'product_id','id');
    }
    
    public function getProductVariationMinMaxPriceAttribute(){
        return ProductVariations::select(\DB::raw('MIN(regular_price) AS MinPrice, MAX(regular_price) AS MaxPrice'))->where('product_id',$this->id)->first();
        // return $this->hasOne(ProductVariations::class,'product_id','id')->select(\DB::raw('MIN(regular_price) AS minPrice, MAX(regular_price) AS MaxPrice'));
    }

    public function getCatDetailsAttribute()
    {
        $ids = explode(',',$this->categories);
        $users = Category::whereIn('id',$ids)->pluck('name')->toArray();
        return implode(',',$users);
    }

}
