<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Pages;
use App\Models\Posts;
use App\Models\PostCategory;
use App\Models\Products;
use App\Models\Category;
use App\Models\Attributes;
// use App\Models\CategoryPageFilter;
use DB;
use App\Http\Controllers\Front\ProductController;

class PageController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page($slug=null,$slug2=null, $slug3=null)
    {
        
        if($slug!=null){


            $pageData = Pages::where('slug',$slug)->where(['status'=>1, 'is_deleted'=>0])->first();
            $pageCategory = PostCategory::where('slug',$slug)->first();
            $productCategories = Category::where('slug',$slug)->first();
            
            if($pageData){
                /** Slug belongs to page */
                return view('front.pages.templates.'.$pageData->template.'',['data'=>$pageData]);//,'showdata'=>$blogdata]);
            }elseif($pageCategory){
                /** Slug belongs to blog Category */
                $redirectTo = route('blog_list', $pageCategory->slug);
                return redirect($redirectTo, 301);
			}elseif($productCategories && env('APP_DEBUG') ){
                $productController = new ProductController();
                return $productController->productListPage(request()->path());
            }else{
                return view('layouts.errors.404');
            }

            // elseif($productCategories){
            //     $productListingData = getProductListing($slug, $slug2, $slug3, request()->all());
            //     if($productListingData['status'] == 404){
            //         return view('layouts.errors.404');
            //     }else if($productListingData['status'] == 200){
            //         $productItems = $productListingData['productItems'];
            //         $isNextPage = $productListingData['isNextPage'];
            //         $nextPage = $productListingData['nextPage'];

            //         $path = request()->path();                    
            //         $categoiresForFilter = CategoryPageFilter::where('page',$path)->pluck('category_id');
            //         $metalTypesForFilter = Attributes::where('slug','metal-type')->first();
            //         $metalTypesForFilter = explode('|',$metalTypesForFilter->values);
                    
            //         $categories = Category::select(['name','id','status','parent_id'])
            //         ->whereIn('id', $categoiresForFilter)
            //         ->where(['is_category_page'=>0, 'status'=>1,'parent_id'=> 0 ])->get();

            //         return view('front.pages.product_listing_page',compact([
            //             'productItems',
            //             'isNextPage',
            //             'nextPage',
            //             "slug", 
            //             "slug2", 
            //             "slug3",
            //             "categories",
            //             "metalTypesForFilter"
            //         ]));
            //     }
            //     else{
            //         return view('layouts.errors.404');
            //     }
            // }

            
        }else{

            $pageData = Pages::where('slug','home')->first();
            return view('front.index',['data'=>$pageData]);
        }
    }

	public function myPost(Request $request)
    {

    	$getPostCategory = PostCategory::where('slug',$request->slug)->pluck('id')->first();

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
		
		
        if(empty($posts) || $posts->status == 0){
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
