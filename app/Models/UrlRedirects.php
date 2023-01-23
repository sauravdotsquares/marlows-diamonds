<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlRedirects extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'url_redirects';
	use HasFactory;
	
	protected $fillable = [
        'type',
	    'old_url',
        'new_url',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at'
	];
	
}
