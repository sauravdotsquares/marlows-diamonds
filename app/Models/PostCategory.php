<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $table = 'post_categories';

    protected $fillable = ['name','slug','parent_id','description','image_url','meta_title','meta_keyword','meta_description','status'];

    protected $appends = [
        'blog_title_details'
    ];

    public function getBlogTitleDetailsAttribute()
    {
        return Pages::where('slug','blog-resources')->first();
    }

}
