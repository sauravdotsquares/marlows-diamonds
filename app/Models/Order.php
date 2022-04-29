<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'pay_timestamp',
        'correlationid',
        'acknowledge',
        'build',
        'token',
        'final_price',
        'payment_type',
        'paymentccdetails',
        'depositpercentage',
        'status',
    ];

    protected $appends = ['user_details','order_address'];

    public function getOrderDetailsFunction()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getUserDetailsAttribute()
    {
        return User::where('id',$this->user_id)->first();
    }
    public function getOrderAddressAttribute()
    {
        return CustomerAddress::where('order_id',$this->id)->first();
    }

}
