<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDekopayFinance extends Model
{
    use HasFactory;

    protected $table = 'order_dekopay_finances';

    protected $fillable = [
        'order_id',
        'order_key',
        'finCodes',
        'depositAmt',
        'totalAmts',
    ];

}
