<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SettingsLang;

class Settings extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'settings';
	use HasFactory;
	
	protected $fillable = [
	'option_value','option_name'
	];
	
	function get_options($option_key)
	{
		
		return Self::where('option_name',$option_key)->value('option_value');
		
	}
	public function langSettings()
    {
      return $this->hasMany(SettingsLang::class);
    }
}
