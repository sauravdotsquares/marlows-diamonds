<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'reviews';
    
    use HasFactory;
	
	protected $fillable = ['title','rating','description','status'];
}
