<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'faqs';
    
    use HasFactory;
	
	protected $fillable = ['title','categories','description','status'];

}
