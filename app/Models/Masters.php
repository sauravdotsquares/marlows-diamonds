<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GlobalCombinations;
use App\Models\AppProductAttributes;
use App\Models\AppProductAttributeVariationDescripiton;

class Masters extends Model
{ 
    use HasFactory;


    protected $table = 'masters';

    protected $fillable = [
        'id',
        'type',
        'slug',
        'parent_id',
        'name',
        'value',
        'is_active', 
        'is_deleted',
        'created_at',
        'updated_at'
    ];


    // public static function attributes(){
    //     $attributes = self::where('type','product_attributes')->latest()->where(['is_deleted'=>0, 'is_active'=>1])->get()->toArray();
    //     // $global_combinations = GlobalCombinations::where(['is_deleted'=>0, 'is_active'=>1])->get()->toArray();
    //     // $attributes_all =  array_merge($attributes, $global_combinations);
    //     // usort($attributes_all, function($a, $b) {
    //     //     return $a['id'] <=> $b['id'];
    //     // });
    //     return $attributes;
    // }


    
    public function info(){
        return $this->hasOne(Masters::class,'id','id');
    }

    public static function attributes(){
        $attributes = self::where('type','product_attributes')->latest()->where(['is_deleted'=>0, 'is_active'=>1])->get();
        if($attributes->count()){
            return $attributes->toArray();
        }
        return [];
    }

    public static function combinations(){
        $global_combinations = GlobalCombinations::where(['is_deleted'=>0, 'is_active'=>1])->get()->toArray();
        return $global_combinations;
    }


    public static function product_variations($product_id=null){
        $attributes = AppProductAttributes::where(['is_deleted'=>0,'is_active'=>1,'product_id'=>$product_id])->where('attribute_id','!=',null)->get()->toArray();

        foreach ($attributes as $attributes_key => $attributes_value) {

            
            $attributeItem = self::where('id', $attributes_value['attribute_id'])->first();
            $attributes[$attributes_key]['name'] = $attributeItem['name'];
            $attributes[$attributes_key]['slug'] = $attributeItem['slug'];

            $attributes[$attributes_key]['variations'] = self::where(['is_deleted'=>0,'is_active'=>1, 'parent_id'=>$attributes_value['attribute_id'] ])->get()->toArray();
        }
        return $attributes;
    }


    public static function attribute_variations($attributeId=null, $product_id=null){
        if(empty($product_id)){
            return self::where(['parent_id'=> $attributeId, 'is_deleted'=>0 ])->select(['id','name','slug'])->get()->toArray();
        }else{
            $variations = self::where(['parent_id'=> $attributeId, 'is_deleted'=>0 ])->select(['id','name','slug'])->get();
            foreach ($variations as $key => $value) {
                $isSelected = AppProductAttributeVariationDescripiton::where(['product_id'=>$product_id, 'is_deleted'=> 0 ,'variation_id'=>$value['id'] ])->first();
                $variations[$key]['selected'] = !empty($isSelected) ? true : false;
                
            }
            return $variations->toArray();
        }
    }

}
