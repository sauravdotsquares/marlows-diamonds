<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GlobalCombinationsVariations;

class GlobalCombinations extends Model
{
	protected $table = 'global_combinations';

    use HasFactory;

	protected $fillable = ['name','slug','is_active','is_deleted','created_at','updated_at'];


	public function variations(){
		return $this->hasMany('App\Models\GlobalCombinationsVariations','global_combinations_id','id');
	}
}
