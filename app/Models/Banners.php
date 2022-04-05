<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
	/**
     * @var string $table
     */
    protected $table = 'banners';
    
    use HasFactory;
	
	protected $fillable = ['page_id','title','description','image','status'];
	
	public function getBannerDetails(){
		return $this->hasMany('App\Models\BannerDetails','banner_id','id');
	}
}
