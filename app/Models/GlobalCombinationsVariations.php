<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalCombinationsVariations extends Model
{
	protected $table = 'global_combinations_variations';

    use HasFactory;

	protected $fillable = ['global_combinations_id','variations_id','is_active','is_deleted','created_at','updated_at'];

	// protected $casts = [
    //     'variations_id' =>'array',
    // ];

    public function getVariationsIdAttribute($value){
        return (array)json_decode($value);
    }

    public function getCombinationHtmlById($combinationId=null){
        // return self::where(['id'])
    }

}
