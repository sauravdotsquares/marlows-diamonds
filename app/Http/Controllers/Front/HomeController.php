<?php

namespace App\Http\Controllers\Front;

//use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;

class HomeController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('front.index');
    }
}
