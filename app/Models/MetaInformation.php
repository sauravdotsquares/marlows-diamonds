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
        $new_record = new self();
        $new_record->parent_id = $information['parent_id'];
        $new_record->belongs_from = $information['belongs_from'];
        $new_record->meta_title = $information['meta_title'];
        $new_record->meta_description = $information['meta_description'];
        $new_record->meta_keywords = $information['meta_keyword'];
        $new_record->save();
        return $new_record;
    }

}
