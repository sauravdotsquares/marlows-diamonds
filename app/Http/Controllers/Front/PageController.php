<?php

namespace App\Http\Controllers\Front;
use App\Models\Pages;
//use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;

class PageController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page($slug=null)
    {
        if($slug!=null){

            $pageData = Pages::where('slug',$slug)->first();
            if($pageData){
                return view('front.pages.templates.default_template',['data'=>$pageData]);
            }
            return view('layouts.errors.404');

        }else{
            $pageData = Pages::where('slug','home')->first();
            return view('front.index',['data'=>$pageData]);  
        }
        
    }
}
