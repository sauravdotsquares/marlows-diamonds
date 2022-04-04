<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerDetails extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'banners_details';
    
    use HasFactory;
	
	protected $fillable = ['banner_id','description','image'];
}
