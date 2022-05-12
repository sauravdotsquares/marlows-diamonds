<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SlugController extends Controller
{
    public function makeNewSlugName($modelName,$nameSlug,$slugfield){

        $model = 'App\\Models\\' . $modelName;


        if(isset($slugfield) && !empty($slugfield)){
            $getNewSlug = str_replace(" ","-",trim($slugfield));
        }elseif(isset($nameSlug) && !empty($nameSlug)){
            $getNewSlug = str_replace(" ","-",trim($nameSlug));
        }else{
            $getNewSlug = " ";
        }

        $duplicateSlug = $model::where('slug','like','%'.$getNewSlug.'%')->latest('slug')->pluck('slug')->first();

        if(isset($duplicateSlug) && !empty($duplicateSlug)){
            if(preg_replace('/[^0-9]/', '', $duplicateSlug)){
                $getNewSlug = ++$duplicateSlug;
            }else{
                $getNewSlug = $duplicateSlug.'-1';
            }
        }
        return $getNewSlug;
    }
}
