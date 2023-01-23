<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProductAttributeVariationDescripiton extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'app_product_attribute_variation_descripiton';

    use HasFactory;

	protected $fillable = [
        'product_id',
        'attribute_id',
        'variations_id',
        'selected_variation_name',
        'selected_variation_id',
        'selected_variation_parent_id',
        'selected_variation_data',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    public function getSelectedVariationDataAttribute($value){
        if(gettype($value) == 'string'){
            return json_decode($value, true);
        }else{
            return $value;
        }
    }

    public function info(){
        return $this->hasOne(Masters::class,'id','variation_id');
    }
}
