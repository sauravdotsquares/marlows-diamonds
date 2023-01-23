<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppProductCategories;

class DiscountRange extends Model
{
    use HasFactory;

    protected $table = "discount_ranges";

    protected $fillable = [
        'category_id',
        'discount_id',
        'from_price',
        'diamond_type',
        'to_price',
        'discount',
        'status',
    ];

    public function discount_data(){
        return $this->hasOne(Discount::class,'id','discount_id');
    }

    /** 
     * This function is use to get product discount percentage after every calculation 
     * 
     * */
    public static function discount_percentage($productId=null, $price=0){
        
        if(empty($productId)){ return 0; };
        if(empty($price)){ return 0; };

        $discount_percentage=0;
        $product_categories = AppProductCategories::where(['product_id'=>$productId, 'is_deleted'=>0, 'is_active'=>1])->get();
        foreach ($product_categories as $categories_key => $categories_value) {
            $getDiscountRange = self::whereHas('discount_data', function($q) use ($categories_value, $price) {
                $q->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->where(['status'=>1, 'category_id' => $categories_value->category_id ]);
            })
            ->where('from_price', '<=', $price)
            ->where('to_price', '>=', $price)
            ->first();
            if(!empty($getDiscountRange)){
                $discount_percentage = $getDiscountRange->discount;
                break;
            }
        }
        return $discount_percentage;

    }// endof discount_percentage

}
