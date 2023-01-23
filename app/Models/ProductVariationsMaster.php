<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationsMaster extends Model{
    
    use HasFactory;

    protected $table = 'product_variations_master';

    protected $fillable = [
        'product_id',
        'master_id',
        'master_parent_id',
        'master_data',
        'combination_id',
        'price',
        'total_price',
        'is_active',
        'is_deleted'
    ];

    public function masterData(){
        return $this->hasOne(Masters::class,'id','master_id');
    }

    public function getParentMasterData(){
        return $this->hasOne(Masters::class,'master_parent_id','id');
    }


}
