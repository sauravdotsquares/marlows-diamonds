<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'quantity',
        'order_product_details',
        'product_price',
        'total_price',
        'status',
    ];

    protected $appends = ['product_details'];

    public function getProductDetailsAttribute()
    {
        return Products::where('id',$this->product_id)->first();
    }
}
