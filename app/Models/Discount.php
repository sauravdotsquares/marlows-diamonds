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
        'end_date',
        'status'
    ];

    protected $appends = ['cat_details'];

    public function getCatDetailsAttribute()
    {
        return Category::where('id',$this->category_id)->value('name');
    }
}
