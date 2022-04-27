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
}
