<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProductAttributes extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'app_product_attributes';

    use HasFactory;

	protected $fillable = [
        'product_id',
        'attribute_id',
        'information',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    public function info(){
        return $this->hasOne(Masters::class,'id','attribute_id');
    }

    // public function getInformationAttribute($value){
    //     if(gettype($value) == 'string'){
    //         return json_decode($value, true);
    //     }else{
    //         return $value;
    //     }
    // }
    // public function selectedVariations(){
    //     return $this->hasMany(AppProductAttributeVariationDescripiton::class,'selected_variation_parent_id','attribute_id')->where(['is_active'=>1, 'is_deleted'=>0]);
    // }
}




