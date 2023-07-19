<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFilterItems extends Model
{
    use HasFactory;

    protected $table = 'product_filter_items';

    protected $fillable = [
        'product_filter_id',
        'item_name',
        'item_slug',
        'item_id',
        'item_value',
        'min_price',
        'max_price',
        'top_text',
        'bottom_text',
        'is_active',
        'is_deleted'
    ];
    protected $appends = [
        'parent_filter_name','category_images','parent_category_slug'
    ];

    public function getParentFilterNameAttribute()
    {
        return ProductFilter::where('id',$this->product_filter_id)->pluck('name')->first();
    }
    public function getCategoryImagesAttribute()
    {
        return Category::where('slug',$this->item_slug)->pluck('image_url')->first();
    }
    public function getParentCategorySlugAttribute()
    {
        return Category::where('slug',$this->item_slug)->first();
    }
}
