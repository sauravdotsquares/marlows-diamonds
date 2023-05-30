<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarginApiRange extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_type',
        'from_price',
        'to_price',
        'percentage',
        'status'
    ];
}
