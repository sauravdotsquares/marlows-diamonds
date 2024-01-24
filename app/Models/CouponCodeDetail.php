<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCodeDetail extends Model
{
    use HasFactory;

    protected $table = 'coupon_code_details';

    protected $fillable = [
        'diamond_type','category_id','coupon_code','discount','status'
    ];
}
