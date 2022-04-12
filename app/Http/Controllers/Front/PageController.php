<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Pages;
use App\Models\Posts;
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
			//$blogdata= Posts::take(5)->orderBy('id','DESC')->where('status', 1)->get();
			
            if($pageData){
                return view('front.pages.templates.'.$pageData->template.'',['data'=>$pageData]);//,'showdata'=>$blogdata]);
            }
            return view('layouts.errors.404');
        }else{
            $pageData = Pages::where('slug','home')->first();
            return view('front.index',['data'=>$pageData]);  
        }
    }
	
	public function myPost(Request $request)
    {
    	$posts = Posts::orderBy('id','DESC')->where('status', 1)->paginate(6);
    	if ($request->ajax()) {
    		$view = view('front.pages.templates.data',compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }
    	return response()->json(['html'=>'']);
    }
}
