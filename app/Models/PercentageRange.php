<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PercentageRange extends Model
{
    use HasFactory;
    protected $table = 'percentage_ranges';

    protected $fillable = [
        'category_id',
        'discount_id',
        'from_price',
        'diamond_type',
        'to_price',
        'percentage',
        'status',
    ];
}
