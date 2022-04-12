<?php

namespace App\Http\Controllers\Front;
use App\Models\Posts;
//use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;

class PostController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // $breadcrumb = [
            // ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            // ["name" => "Posts", "url" => route("admin.posts"), "icon" => "fa fa-home"],

        // ];
        // populate_breadcrumb($breadcrumb);
		$posts = Posts::all();
		return view('front.pages.templates.blog_template', compact('posts'));
		
    }
}
