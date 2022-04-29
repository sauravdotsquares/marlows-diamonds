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

    protected $appends = ['user_details','order_address','status_details','total_quantity'];

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
    public function getTotalQuantityAttribute()
    {
        return OrderDetail::where('order_id',$this->id)->sum('quantity');
    }
    public function getStatusDetailsAttribute()
    {
        if($this->status == 0){
            return "Pending";
        }elseif($this->status == 1){
            return "Processing";
        }elseif($this->status == 2){
            return "Payment Done";
        }elseif($this->status == 3){
            return "Payment Failed/Cancelled";
        }elseif($this->status == 4){
            return "Shipped";
        }elseif($this->status == 5){
            return "Delievered";
        }elseif($this->stauts == 6){
            return "Return";
        }elseif($this->status == 7){
            return "Cancelled";
        }else{
            return "Pending";
        }
    }

}
