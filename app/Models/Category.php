<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryPrecontent;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name','title','slug','parent_id','short_description','description','image_url','meta_title','meta_keyword','meta_description','enable_filter','sort_order','active_icon','hover_icon','status','is_category_page'];

    protected $appends = ['parent_details','parent_cate','pre_content','post_content'];

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


    public static function category_options($type="options", $categories = [], $level=0, $prefix="", $selected_categories=[] ){
        $rows = self::select(['name','title','id','parent_id','slug'])->where('parent_id',$level)->get();
        $html = '';
        if($rows->count()){
            $rows = $rows->toArray();
            foreach ($rows as $row) {

                switch ($type) {
                    case 'options':{

                        $isSelected = in_array($row['id'], $categories) ? 'selected' : '';

                        $html .= '<option value="'.$row['id'].'"    '.$isSelected.'  >' . $prefix . $row['name'] . "</option>";
                        break;
                    }
                    case 'new_line':{
                        $html .= $prefix . $row['name'] . "<br />";
                        break;
                    }
                    default:{
                        $html .= $prefix . $row['name'];
                        break;
                    }
                }
                $html .= self::category_options($type, $categories, $row['id'], $prefix . '----');
            }
        }
        
        return $html;
    }

    public static function get_all_childs($parent_id="", $childs=[]){

        $data = self::where('parent_id', $parent_id)->select('id')->get();
        if($data->count()){ $data = $data->toArray(); }

        $result = array();
        foreach ($data as $row) {
            $result[] = $row;
            $result[]['children'] = self::get_all_childs($row['id']);
        }

        return $result;
    }

    public static function get_all_child_ids($parentData, $all_ids=[]){

        if(gettype($parentData) == 'array'){

            /** Starts from parentdata */
            $all_childs = [];
            foreach ($parentData as $key => $value) {
                $tree = self::where('parent_id',$value)->select('id')->get();
                if($tree->count()){
                    $all_childs = array_merge($all_childs,$tree->pluck('id')->toArray());
                }
            }
            if(count($all_childs)){
                $all_ids = array_merge($all_ids, $all_childs); 
                return self::get_all_child_ids($all_childs, $all_ids); 
            }else{
                return $all_ids;
            }


        }else{
            /** Starts from 1 id */
            $tree = self::where('parent_id',$parentData)->select('id')->get();
            if($tree->count()){
                $all_ids = array_merge($all_ids,[$parentData], $tree->pluck('id')->toArray());
                return self::get_all_child_ids($tree->pluck('id')->toArray(), $all_ids);
            }
            else{ return [$parentData];}
        }
    }

    public function getPreContentAttribute()
    {
        return CategoryPrecontent::where('category_id',$this->id)->where('content_position',1)->where('status',1)->latest()->limit(4)->get();
    }
    public function getPostContentAttribute()
    {
        return CategoryPrecontent::where('category_id',$this->id)->where('content_position',2)->where('status',1)->latest()->limit(4)->get();
    }
     
}
