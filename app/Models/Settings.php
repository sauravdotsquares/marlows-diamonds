<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'settings';
	use HasFactory;
	
	
	function get_options($option_key)
	{
		
		return Self::where('option_name',$option_key)->value('option_value');
		
	}
}
