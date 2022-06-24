<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Discount", "url" => route("admin.discount"), "icon" => "fa fa-percent"],
        ];

        populate_breadcrumb($breadcrumb);

        $getDiscountData = Discount::latest()->get();

        return view('admin.discount.index',compact('getDiscountData'));
    }

    public function addDiscount()
    {
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Discount Create", "url" => route("admin.create-discount"), "icon" => "fa fa-percent"],

        ];

        $getParentCategory = Category::select('name','slug','parent_id','short_description','description','id')->where('parent_id',0)->get();

        // return response()->json($getParentCategory);

        populate_breadcrumb($breadcrumb);
        return view('admin.discount.create',compact('getParentCategory'));
    }

    public function addDiscountData(Request $request)
    {
        $getDuplicateDiscount = Discount::where('category_id',$request->category_id)->first();
        if(isset($getDuplicateDiscount) && !empty($getDuplicateDiscount)){
            if(isset($request->table_id) && !empty($request->table_id)){
                $insDiscountData = Discount::updateOrCreate(['id'=>$request->table_id],[
                    'category_id'=> $request->category_id,
                    'category_slug'=> $request->category_slug,
                    'discount'=> $request->discount,
                    'end_date'=> $request->end_date,
                    'status'=> $request->status,
                ]);
            }
            return redirect()->action('Admin\DiscountController@index')->with('alert-success', 'Duplicate Category not allowed');
        }else{
            $insDiscountData = Discount::updateOrCreate(['category_id'=>$request->category_id],[
                'category_id'=> $request->category_id,
                'category_slug'=> $request->category_slug,
                'discount'=> $request->discount,
                'end_date'=> $request->end_date,
                'status'=> $request->status,
            ]);

            return redirect()->action('Admin\DiscountController@index')->with('alert-success', 'Banner Added Successfully');
        }
    }

    public function editPageDiscountData($discountId)
    {
        $getDiscountData = Discount::where('id',$discountId)->first();

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Discount Create", "url" => route("admin.create-discount"), "icon" => "fa fa-percent"],

        ];

        $getParentCategory = Category::select('name','slug','parent_id','short_description','description','id')->where('parent_id',0)->get();


        populate_breadcrumb($breadcrumb);

        return view('admin.discount.create',compact('getParentCategory','getDiscountData'));
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
