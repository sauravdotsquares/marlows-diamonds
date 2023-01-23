<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabPricesList extends Model
{
    use HasFactory;

    protected $table = 'lab_prices_list';

    protected $fillable = [
        'clarity',
        'color',
        'carat',
        'price',
        'is_active',
        'is_deleted'
    ];

}
