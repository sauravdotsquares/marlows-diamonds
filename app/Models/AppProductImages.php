<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProductImages extends Model{
	
    protected $table = 'app_products_images';

    use HasFactory;

	protected $fillable = [
        'parent_id',
        'belongs_from',
        'image',
        'image_type',
        'size',
        'extension',
        'original_name',
        'display_order',
        'metadata',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];


    public static function image($parent_id=null){
        if($parent_id){
            $parentData = self::where(['parent_id'=> $parent_id, 'is_deleted'=>0, 'is_active'=>1 ])->first();
            if(!empty($parentData)){
                return $parentData->toArray();
            }
            return null;
        }
        return '';
    }

    public static function getImages($conditions){
        $productImages = AppProductImages::where([
            'is_deleted' => 0,
            ...$conditions
        ])->get();

        if( !empty($productImages) && $productImages->count() ){
            $productImages = $productImages->toArray();
            $new_data_ar = [];
            foreach ($productImages as $key => $value) {
                $imageType = $value['image_type'];
                $new_data_ar[$imageType][] = $value;
                $new_data_ar[$imageType.'_img_id'][] = $value['image_id'];
            }
            return $new_data_ar;
        }
        return [];
    }
}
