<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masters;

class CombinationAttributes extends Model
{
	
    protected $table = 'combination_attributes';

    use HasFactory;

	protected $fillable = [
        'combination_id',
        'attribute_id',
        'attribute_data',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

    public function attributeData(){
        return $this->hasOne(Masters::class,'id','attribute_id');
    }

    public function variationsData(){
        return $this->hasMany(Masters::class,'parent_id','attribute_id')->where(['is_deleted'=>0, 'is_active'=>1]);
    }

}
