<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoScripts extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'seo_scripts';
	use HasFactory;
	
	protected $fillable = [
        'page',
        'header_script',
        'footer_script',
        'is_all_page',
        'is_active',
        'is_deleted',
	];
}
