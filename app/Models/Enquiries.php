<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiries extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'enquiries';

    use HasFactory;

	protected $fillable = ['title','email','custom_url','description','status'];
}
