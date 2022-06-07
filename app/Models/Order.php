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
        'custom_order_id',
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

    protected $appends = ['user_details','order_address','status_details','total_quantity','status_details_designs'];

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
        return CustomerAddress::where('user_id',$this->user_id)->first();
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
        }elseif($this->status == 6){
            return "Return";
        }elseif($this->status == 7){
            return "Cancelled";
        }else{
            return "Pending";
        }
    }
    public function getStatusDetailsDesignsAttribute()
    {
        if($this->status == 0){
            return '<span class="badge badge-warning">Pending</span>';
        }elseif($this->status == 1){
            return '<span class="badge badge-info">Processing</span>';
        }elseif($this->status == 2){
            return '<span class="badge badge-success">Payment Done</span>';
        }elseif($this->status == 3){
            return '<span class="badge badge-danger">Payment Failed/Cancelled</span>';
        }elseif($this->status == 4){
            return '<span class="badge badge-success">Shipped</span>';
        }elseif($this->status == 5){
            return '<span class="badge badge-danger">Delievered</span>';
        }elseif($this->status == 6){
            return '<span class="badge badge-warning">Return</span>';
        }elseif($this->status == 7){
            return '<span class="badge badge-warning">Cancelled</span>';
        }else{
            return '<span class="badge badge-warning">Processing</span>';
        }
    }

}
