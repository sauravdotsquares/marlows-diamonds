<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masters extends Model
{ 
    use HasFactory;
    
    /**
     * @var string $table
     * 
     * 
     * product_attributes
     * 
     * 
    */

    protected $table = 'masters';

    protected $fillable = [
        'id',
        'type',
        'slug',
        'parent_id',
        'name',
        'value',
        'is_active', 
        'is_deleted',
        'created_at',
        'updated_at'
    ];

}
