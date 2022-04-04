<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationDetails extends Model
{
    use HasFactory;

    protected $table = 'product_variation_details';

    protected $fillable = [
        'variation_id','key','value',
    ];
}
