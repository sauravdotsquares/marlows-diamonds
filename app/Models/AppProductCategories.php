<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProductCategories extends Model{
	
    protected $table = 'app_products_categories';

    use HasFactory;

	protected $fillable = [
        'product_id',
        'category_id',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];


    public function info(){
        return $this->belongsTo(Category::class,'id','category_id');
    }
}
