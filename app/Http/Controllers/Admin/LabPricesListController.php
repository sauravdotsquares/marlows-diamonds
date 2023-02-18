<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LabPricesList;

use URL;
class LabPricesListController extends Controller
{
   public function index(Request $request){
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        $page_title = "Lab Price";

        $query = LabPricesList::orderBy('id','DESC')->where(['is_deleted'=>0]);

        $query = getFilter(LabPricesList::class, $query, $request->query());

        $data = $query->paginate(20);

        return view('admin.labprices.index', compact(['data','page_title']));
    }//endof 


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
