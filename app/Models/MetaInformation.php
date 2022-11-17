<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaInformation extends Model{
	
    protected $table = 'meta_information';

    use HasFactory;

	protected $fillable = [
        'belongs_from',
        'parent_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];


    protected function saveMetaInformation($id=null, $information=[]){

        if($id){
            $meta_record = self::where(['id'=> $id, 'is_deleted'=>0])->first();
            if(empty($meta_record)){
                $meta_record = new self();    
            }
        }else{
            $meta_record = new self();
        }
    
        $meta_record->parent_id = $information['parent_id'];
        $meta_record->belongs_from = $information['belongs_from'];
        $meta_record->meta_title = $information['meta_title'];
        $meta_record->meta_description = $information['meta_description'];
        $meta_record->meta_keywords = $information['meta_keyword'];
        $meta_record->save();
        return $meta_record;
    }

}
