<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\HKDiamondStock;

//use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;

class DiamondFinderController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function diamondSearch()
    {

        $data = HKDiamondStock::paginate(10);
        dd($data);
    }
}
