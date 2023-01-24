<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiamondStock;
use App\Models\HariKrishna;

class HariKrishnaController extends Controller
{
    public function index()
    {
        ini_set('MAX_EXECUTION_TIME', '-1');
        set_time_limit(5000);
        ini_set('max_execution_time', 3000);

        //$basket_data = DiamondStock::get()->toArray();
        //  echo "done sdfdf";
        // echo "Done<pre>";
        // // print_r($basket_data);
        // die;
        $basket_data = DiamondStock::orderBy('Sr_No','asc')->get()->toArray();
        HariKrishna::truncate();
        foreach($basket_data as $records)
        {
            unset($records['id']);
            $records['created_at'] = date('Y-m-d h:i:s');
            $records['updated_at'] = date('Y-m-d h:i:s');
            HariKrishna::create($records);
        }
        // echo "done sdfdf";
        // echo "Done<pre>";
        // die;
    }
}
