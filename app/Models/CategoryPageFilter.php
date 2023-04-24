<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPageFilter extends Model
{
    use HasFactory;

    protected $table = 'category_page_filter';

    protected $fillable = [
        'page','category_id','is_active','is_deleted'
    ];
}
