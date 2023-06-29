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
        $posts = Posts::orderBy('id', 'DESC')->where('status', 1)->get();
        return view('front.pages.templates.blog_template', compact('posts'));
    }
}
