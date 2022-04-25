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
    public function diamondSearch(Request $request)
    {
    	
        $results = HKDiamondStock::
        		where('Shape','LIKE',$request->shape)
        		->whereBetween('Carat', [$request->carat_min, $request->carat_max])
        		->orderBy('id','ASC')
        		->paginate(5);
        $array=$results->toArray();
       /* foreach ($array['data'] as $key => $result) {
        	$array['data'][$key]['shape'] = $result['Shape'];
        	$array['data'][$key]['carat'] = $result['Carat'];
        }*/

		return response($array);
         //echo '<pre>'; echo $results->current_page; die;
    }
}
