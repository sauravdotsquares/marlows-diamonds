<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combinations extends Model
{
	
    protected $table = 'combinations';

    use HasFactory;

	protected $fillable = [
        'name',
        'slug',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

    public static function combinations(){
        $data = self::where(['is_deleted'=>0, 'is_active'=>1])->latest()->get();
        if($data->count()){
            return $data->toArray();
        }
        return null;
    }

    public function variations(){
        return $this->hasMany(CombinationVaritions::class,'combination_id','id');
    }

    /**
     * combination_value
     * This function return the percentage from combinations.
     */
    public static function combination_value($combinationId,$varitaion=[]){
        if(!count($varitaion)){
            return 100;
        }
        $combinationsData = null;
        $combinations = self::whereHas('variations', function($q){
            $q->where(['is_deleted'=>0, 'is_active'=>1]);
        })
        ->with(['variations'=> function($q){
            $q->where(['is_deleted'=>0, 'is_active'=>1]);
        }])
        ->where(['id'=> $combinationId, 'is_active'=>1, 'is_deleted'=> 0 ])
        ->first();
        
        if(!empty($combinations)){
            foreach ($combinations['variations'] as $variations_key => $variations_value) {
                $combinations_variations = CombinationVariationDetails::where(['combination_varition_id'=> $variations_value->id, 'is_deleted'=>0, 'is_active'=>1 ])->pluck('varition_id');
                if($combinations_variations->count()){
                    $containsAllValues = !array_diff($combinations_variations->toArray(), $varitaion);
                    if($containsAllValues){ $combinationsData = $variations_value; break; }
                }
            }
        }
        return $combinationsData ? $combinationsData->price : 100;
    }// endof combination_value

}
