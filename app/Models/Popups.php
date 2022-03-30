<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popups extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'popups';
    
    use HasFactory;
	
	protected $fillable = ['title','description'];
}
