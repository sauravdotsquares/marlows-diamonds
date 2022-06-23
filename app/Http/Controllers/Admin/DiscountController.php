<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class DiscountController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Discount", "url" => route("admin.discount"), "icon" => "fa fa-percent"],

        ];
        populate_breadcrumb($breadcrumb);
        // echo "Checking";
        // die;
        return view('admin.discount.index');
    }

    public function addDiscount()
    {
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Discount Create", "url" => route("admin.create-discount"), "icon" => "fa fa-percent"],

        ];

        $getParentCategory = Category::select('name','slug','parent_id','short_description','description')->where('parent_id',0)->get();

        // return response()->json($getParentCategory);

        populate_breadcrumb($breadcrumb);
        return view('admin.discount.create',compact('getParentCategory'));
    }

    public function addDiscountData(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all(''));
        // die;
    }

    public function status(Request $request)
    {
        $statusChange = Discount::findOrFail($request->id);
        if($statusChange){

            $statusChange->update([
                'status'=>$request->status,
            ]);
            return response()->json($statusChange);
        }
        return response()->json(['error'=>'geterror'],422);
    }

    public function delete(Request $request)
    {
        $post = Discount::find($request->id)->delete();
        return response()->json($post);
    }
}
