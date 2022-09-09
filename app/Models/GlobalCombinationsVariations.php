<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalCombinationsVariations extends Model
{
	protected $table = 'global_combinations_variations';

    use HasFactory;

	protected $fillable = ['global_combinations_id','variations_id','is_active','is_deleted','created_at','updated_at'];
}
