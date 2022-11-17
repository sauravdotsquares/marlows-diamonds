<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountRange extends Model
{
    use HasFactory;

    protected $table = "discount_ranges";

    protected $fillable = [
        'category_id',
        'discount_id',
        'from_price',
        'to_price',
        'discount',
        'status',
    ];

    public function discount_data(){
        return $this->hasOne(Discount::class,'id','discount_id');
    }

}
