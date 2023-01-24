<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'image_gallery';
    
    use HasFactory;
	
	protected $fillable = [
        'image',
        'size',
        'extension',
        'original_name',
        'metadata',
        'display_order',
        'is_active',
        'is_deleted'
    ];

    /**
     * Save media in required place
     * @param class which to save data (db table, modal)
     * @param parentId
     * @param belongsFrom table name
     * @param type image type
     * @param data comma saprated image ids
     */
    public static function saveMedia($class,$parentId, $belongsFrom, $type, $data ){

        $data = explode(',',$data);
        $validMediaIds = [];
        foreach ($data as $data_key => $data_value) {
            $img_data = self::where(['id'=> $data_value, 'is_deleted'=>0])->first();
            if(!empty($img_data)){
                /** if file exists */
                if(file_exists( public_path() . '/uploads/' . $img_data->image )){
                    $exists = $class::where(['parent_id'=> $parentId, 'belongs_from'=> $belongsFrom, 'image_type' => $type , 'image_id' => $img_data->id ])->first();
                    if(empty($exists)){
                        $new_item = new $class();
                        $new_item->parent_id = $parentId;
                        $new_item->image_id = $img_data->id;
                        $new_item->belongs_from = $belongsFrom;
                        $new_item->image = $img_data->image;
                        $new_item->size = $img_data->size;
                        $new_item->extension = $img_data->extension;
                        $new_item->original_name = $img_data->original_name;
                        $new_item->metadata = $img_data->metadata;
                        $new_item->image_type = $type;
                        $new_item->save();
                        $id = $new_item->id;
                    }else{
                        $id = $exists->id;
                    }
                    $validMediaIds[] = $id;
                }
            }
        }

        /** Delete extra un-used images */
        if(count($validMediaIds)){
            $class::where([
                'parent_id'=> $parentId, 
                'belongs_from'=> $belongsFrom,
                'image_type' => $type,
            ])
            ->whereNotIn('id',$validMediaIds)
            ->update(['is_deleted'=>1]);
        }
    }
}