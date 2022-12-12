<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProductAttributeVariations extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'app_product_attribute_variations';

    use HasFactory;

	protected $fillable = [
        'name',
        'product_id',
        'attribute_id',
        'sale_price',
        'regular_price',
        'in_stock',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    public function variations(){
        return $this->hasMany(AppProductAttributeVariationDescripiton::class,'attribute_variation_id','id');
    }


    public function images(){
        return $this->hasMany(AppProductImages::class,'parent_id','id');
    }

    
}
