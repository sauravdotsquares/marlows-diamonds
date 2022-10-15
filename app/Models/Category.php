<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name','title','slug','parent_id','short_description','description','image_url','meta_title','meta_keyword','meta_description','enable_filter','sort_order','active_icon','hover_icon','status'];

    protected $appends = ['parent_details','parent_cate'];

    public function getParentDetailsAttribute()
    {
        if($this->parent_id > 0){
            return Category::where('id',$this->parent_id)->pluck('name')->first();
        }else{
            return "Parent";
        }
    }
    public function getParentCateAttribute()
    {
        if($this->parent_id > 0){
            return self::where('id',$this->parent_id)->select('id','parent_id','slug')->first();
        }
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->select('id','parent_id','slug','title');
    }

    public function grandchildren()
    {
        return $this->children()->with('grandchildren')->select('id','parent_id','slug','title');
    }
     
}
