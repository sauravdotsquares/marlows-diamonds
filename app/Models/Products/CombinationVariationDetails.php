<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masters;
use App\Models\Products\Combinations;

class CombinationVariationDetails extends Model
{
	
    protected $table = 'combination_varition_details';

    use HasFactory;

	protected $fillable = [
        'varition_id',
        'combination_varition_id',
        'attribute_id',
        'combination_id',
        'price',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

}
