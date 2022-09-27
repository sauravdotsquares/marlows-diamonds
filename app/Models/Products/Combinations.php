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
}
