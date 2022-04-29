<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $table = "customer_addresses";

    protected $fillable = [
        'user_id',
        'order_id',
        'first_name',
        'last_name',
        'company_name',
        'country_id',
        'street_address_l1',
        'street_address_l2',
        'town_city',
        'state',
        'pin_code',
        'mobile',
        'email',
        'order_notes',
    ];

    protected $appends = ['country_name'];

    public function getCountryNameAttribute()
    {
        if($this->country_id){
            return Country::where('shortname',$this->country_id)->pluck('name')->first();
        }else{
            return "Not Selected";
        }
    }
}
