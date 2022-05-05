<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use HasFactory;

    protected $table = 'faq_categories';
    
    protected $fillable = ['title'];
	
	public function getFAQData(){
		return $this->hasMany(Faqs::class,'categories','id');
	}
	
}
