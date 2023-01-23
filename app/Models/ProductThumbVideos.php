<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductThumbVideos extends Model{

    protected $table = 'product_thumb_videos';
    
    protected $fillable = [
        'product_id','thumb_image_url','image_url','is_featured','status','type','extension','size'
    ];
    
}