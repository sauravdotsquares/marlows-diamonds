<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProducts extends Model{
	
    protected $table = 'app_products';

    use HasFactory;

	protected $fillable = [
        'title',
        'slug',
        'tags',
        'is_variable',
        'dfinder_status',
        'diamond_shape',
        'short_description',
        'description',
        'sale_price',
        'regular_price',
        'is_featured',
        'is_taxable',
        'status',
        'is_draft',
        'stock_status',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    public function productMeta(){
        return $this->hasOne(MetaInformation::class,'parent_id','id');
    }

    public function productAttributes(){
        return $this->hasMany(AppProductAttributes::class,'product_id','id');
    }

    public function productImages(){
        return $this->hasMany(AppProductImages::class,'parent_id','id');
    }

    public function getProductVariation(){
        return $this->hasMany(AppProductAttributeVariations::class,'product_id','id');
    }

    /** Categories that are selected for products */
    public function categories(){
        return $this->hasMany(AppProductCategories::class,'product_id','id');
    }

    /** variations that are selected for products */
    public function variations(){
        return $this->hasMany(AppProductAttributeVariations::class,'product_id','id');
    }

    /** images that are selected for a product */
    public function images(){
        return $this->hasMany(AppProductImages::class,'parent_id','id');
    }
}
