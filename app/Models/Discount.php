<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';
    protected $fillable = [
        'category_id',
        'category_slug',
        'discount',
        'inc_percentage',
        'end_date',
        'status'
    ];

    protected $appends = ['cat_details','discount_range_details'];

    public function getCatDetailsAttribute()
    {
        return Category::where('id',$this->category_id)->value('name');
    }

    public function getDiscountRangeDetailsAttribute()
    {
        return DiscountRange::where('discount_id',$this->id)->get()->toArray();
    }
}
