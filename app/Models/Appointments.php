<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'appointments';

    use HasFactory;

	protected $fillable = ['title','email','custom_url','phone','description','status'];
}
