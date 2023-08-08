<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;


class SettingsLang extends Model
{
  /**
   * @var string $table
   */
  protected $table = 'settings_lang';
  public $timestamps = false;

  use HasFactory;

  function get_options($option_key)
  { 
    if((str_contains(url()->current(),'/admin/header-settings')||str_contains(url()->current(),'/admin/footer-settings')||str_contains(url()->current(),'/admin/settings'))){
     
    $temp_value = Self::where('option_name', $option_key)->where('lang', getDefultAdminLanguage())->value('option_value');
    if (!$temp_value) {
      $temp_value = Self::where('option_name', $option_key)->where('lang', env('DEFULT_LANG_CODE'))->value('option_value');
    }
  }else{
    
      
    $temp_value = Self::where('option_name', $option_key)->where('lang', session()->get('language'))->value('option_value');
    if (!$temp_value) {
      $temp_value = Self::where('option_name', $option_key)->where('lang', env('DEFULT_LANG_CODE'))->value('option_value');
    }
  }
 
    return $temp_value;
  }



  protected $fillable = ['site_title', 'settings_id', 'site_tagline', 'lang', 'option_name', 'option_value'];
}
