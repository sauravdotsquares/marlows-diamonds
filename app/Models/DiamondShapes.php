<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiamondShapes extends Model
{
    use HasFactory;

    protected $table = 'diamond_shapes';

    protected $fillable = [
        'value','name'
    ];

}
