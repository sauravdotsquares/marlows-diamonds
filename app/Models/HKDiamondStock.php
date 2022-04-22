<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HKDiamondStock extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'hkdiamondstock';
    
    use HasFactory;
	
	protected $fillable = ['Shape','Carat','Clarity','Color'];
}