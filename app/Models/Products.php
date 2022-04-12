<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title','slug','tags','short_description','description','categories','sale_price','regular_price','meta_title','meta_keyword','meta_description','status','is_featured','is_taxable'
    ];

    protected $appends = ['cat_details'];

    public function getProductImages(){
        return $this->hasOne(ProductImages::class,'product_id','id')->where('is_featured',1);
    }
    
    public function getProductGallery(){
        return $this->hasMany(ProductImages::class,'product_id','id');
    }

    public function getCatDetailsAttribute()
    {
        $ids = explode(',',$this->categories);
        $users = Category::whereIn('id',$ids)->pluck('name')->toArray();
        return implode(',',$users);
    }

}
