<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPrecontent extends Model
{
    use HasFactory;

    protected $table = 'category_precontents';

    protected $fillable = [
        'category_id','content_position','title','heading','description','image_url','slug','status','style_changes','button_title','button_check','button_url'
    ];
}
