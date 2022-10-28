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
}
