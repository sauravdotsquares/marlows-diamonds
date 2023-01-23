<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Pages;
use App\Models\Posts;
use App\Models\PostCategory;
use App\Models\Products;
//use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;

class PageController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page($slug=null)
    {
        
        if($slug!=null){


            $pageData = Pages::where('slug',$slug)->where('status',1)->first();
            $pageCategory = PostCategory::where('slug',$slug)->first();
			//$blogdata= Posts::take(5)->orderBy('id','DESC')->where('status', 1)->get();
            if($pageData){
                return view('front.pages.templates.'.$pageData->template.'',['data'=>$pageData]);//,'showdata'=>$blogdata]);
            }elseif($pageCategory){

                $redirectTo = route('blog_list', $pageCategory->slug);
                return redirect($redirectTo, 301);
                // return redirect()->route('blog_list', $pageCategory->slug);
				// return view('front.pages.templates.blog_template',['data'=>$pageCategory, 'blog_details' => 1]);//,'showdata'=>$blogdata]);
			}

            return view('layouts.errors.404');
        }else{

            $pageData = Pages::where('slug','home')->first();
            return view('front.index',['data'=>$pageData]);
        }
    }

	public function myPost(Request $request)
    {

    	$getPostCategory = PostCategory::where('slug',$request->slug)->pluck('id')->first();

        // prd($request->all());
        

        if(isset($getPostCategory) && !empty($getPostCategory)){
            $query = Posts::orderBy('id','DESC')->where('status', 1)->whereRaw("find_in_set('".$getPostCategory."',categories)");
            if(!empty($request['searchKeyword'])){
                $search = $request['searchKeyword'];
                $query = $query->where('title','LIKE',"%$search%");
            }
            $posts = $query->paginate(6);
        }elseif(isset($request->slug)  && ($request->slug == 'blog-resources' || $request->slug == 'blog') ){
            $query = Posts::orderBy('id','DESC')->where('status', 1);
            if(!empty($request['searchKeyword'])){
                $search = $request['searchKeyword'];
                $query = $query->where('title','LIKE',"%$search%");
            }
            $posts = $query->paginate(6);
        }

    	if ($request->ajax() && isset($posts) && !empty($posts)) {
    		$view = view('front.pages.blog-data',compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }
    	return response()->json(['html'=>'']);
    }

	// For single blog post
	public function show(Request $request,$slug){
		$posts = Posts::where('slug',$slug)->first();
        if(empty($posts)){
            return view('errors.404');
        }

    	return view('front.pages.blog-details',['data'=>$posts]);
        
    }

    /** List of blogs */
    public function blogList(Request $request, $slug){
        /** If category found */
        $getPostCategory = PostCategory::where('slug',$slug)->pluck('id')->first();
        if(!empty($getPostCategory)){
            $posts = Posts::orderBy('id','DESC')->where('status', 1)->whereRaw("find_in_set('".$getPostCategory."',categories)")->paginate(6);
            if($posts->count()){
                $pageCategory = PostCategory::where('slug',$slug)->first();
                return view('front.pages.templates.blog_template',['data'=>$pageCategory, 'blog_details' => 1 ,'blogCategorySlug' => $slug ]);
            }
        }
        return view('errors.404');
    }

}
