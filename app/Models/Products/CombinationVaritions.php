<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masters;
use App\Models\Products\Combinations;

class CombinationVaritions extends Model
{
	
    protected $table = 'combination_varitions';

    use HasFactory;

	protected $fillable = [
        // 'product_type',
        // 'product_type_id',
        // 'product_type_data',
        'combination_id',
        // 'combination_attribute_id',
        // 'varition_id',
        // 'varition_data',
        // 'attribute_id',
        // 'attribute_data',
        'price',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

    public function attributeData(){
        return $this->hasOne(Masters::class,'id' ,'attribute_id');
    }
    public function varitionData(){
        return $this->hasOne(Masters::class,'id' ,'varition_id');
    }
    public function productTypeData(){
        return $this->hasOne(Masters::class,'id' ,'product_type_id');
    }
    public function combinationData(){
        return $this->hasOne(Combinations::class,'id' ,'combination_id');
    }
    public function attributeVariations(){
        return $this->hasMany(CombinationVaritions::class,'attribute_id' ,'attribute_id');
    }

}
