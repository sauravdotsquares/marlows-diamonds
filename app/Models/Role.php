<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'user_roles';
    
    use HasFactory;
}
