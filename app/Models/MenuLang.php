<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuLang extends Model
{
    /**
     * @var string $table
     */
     protected $table = 'menu_lang';
     public $timestamps= false;
    
     use HasFactory;

     protected $fillable=['title','menus_id','lang'];
}
