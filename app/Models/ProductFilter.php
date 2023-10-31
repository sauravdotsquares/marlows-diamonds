<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductFilterItems;

class ProductFilter extends Model
{
    use HasFactory;

    protected $table = 'product_filter';

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'is_deleted'
    ];


    public function product_items(){
        return $this->hasMany(ProductFilterItems::class, 'product_filter_id')->orderBy('item_name','asc');
    }
}
