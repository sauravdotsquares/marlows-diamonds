<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Discount;
use App\Models\DiscountRange;

class DiscountController extends Controller
{

    public function index(){
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Discount", "url" => route("admin.discount"), "icon" => "fa fa-percent"],
        ];

        populate_breadcrumb($breadcrumb);

        $getDiscountData = Discount::latest()->get();

        return view('admin.discount.index',compact('getDiscountData'));
    }

    public function addDiscount(){
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Discount Create", "url" => route("admin.create-discount"), "icon" => "fa fa-percent"],

        ];

        $getParentCategory = Category::select('name','slug','parent_id','short_description','description','id')->where('parent_id',0)->get();

        // return response()->json($getParentCategory);

        populate_breadcrumb($breadcrumb);
        return view('admin.discount.create',compact('getParentCategory'));
    }

    public function addDiscountData(Request $request){

        $isDicountForLoginUsers = empty($request['is_login_users']) ? 0 : 1;

        if(!empty($request->category_id)){

            $getDuplicateDiscount = Discount::where('category_id',$request->category_id)->first();
            if(isset($getDuplicateDiscount) && !empty($getDuplicateDiscount)){
                if(isset($request->table_id) && !empty($request->table_id)){
                    $insDiscountData = Discount::updateOrCreate(['id'=>$request->table_id],[
                        'category_id'=> $request->category_id,
                        'category_slug'=> $request->category_slug,
                        'discount'=> $request->discount,
                        'inc_percentage'=> $request->inc_percentage,
                        'end_date'=> $request->end_date,
                        'is_login_users'=>$isDicountForLoginUsers,
                        'status'=> $request->status,
                        'diamond_type' => !empty($request->diamond_type) ? $request->diamond_type : null
                    ]);
                    $this->addDiscountRanges($request->all(),$insDiscountData->id);
                }else{
                    $this->addDiscountRanges($request->all(),$getDuplicateDiscount->id);
                }

                return redirect()->action('Admin\DiscountController@index')->with('alert-success', 'Duplicate Category not allowed');
            }else{
                $insDiscountData = Discount::updateOrCreate(['category_id'=>$request->category_id],[
                    'category_id'=> $request->category_id,
                    'category_slug'=> $request->category_slug,
                    'discount'=> $request->discount,
                    'inc_percentage'=> $request->inc_percentage,
                    'end_date'=> $request->end_date,
                    'status'=> $request->status,
                    'is_login_users'=>$isDicountForLoginUsers,
                    'diamond_type' => !empty($request->diamond_type) ? $request->diamond_type : null
                ]);

                $this->addDiscountRanges($request->all(),$insDiscountData->id);

                return redirect()->action('Admin\DiscountController@index')->with('alert-success', 'Discount Added Successfully');
            }
        }else{
            return redirect()->back()->with('alert-error', 'Something went wrong');
        }
    }

    public function editPageDiscountData($discountId){
        $getDiscountData = Discount::where('id',$discountId)->first();

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Discount Create", "url" => route("admin.create-discount"), "icon" => "fa fa-percent"],

        ];

        $getParentCategory = Category::select('name','slug','parent_id','short_description','description','id')->where('parent_id',0)->get();


        populate_breadcrumb($breadcrumb);

        return view('admin.discount.create',compact('getParentCategory','getDiscountData'));
    }

    public function status(Request $request){
        $statusChange = Discount::findOrFail($request->id);
        if($statusChange){

            $statusChange->update([
                'status'=>$request->status,
            ]);
            return response()->json($statusChange);
        }
        return response()->json(['error'=>'geterror'],422);
    }

    public function delete(Request $request){
        $post = Discount::find($request->id)->delete();
        return response()->json($post);
    }

    public function addDiscountRanges($getDiscountRangeArray,$discountId){
        $arrayNew = [];

        for($i=1;$i<=7;$i++){
            $arrayNew[$i]['category_id'] = isset($getDiscountRangeArray['category_id'])?$getDiscountRangeArray['category_id']:0;
            $arrayNew[$i]['from'] = isset($getDiscountRangeArray['range'.$i.'_from'])?$getDiscountRangeArray['range'.$i.'_from']:0;
            $arrayNew[$i]['to'] = isset($getDiscountRangeArray['range'.$i.'_to'])?$getDiscountRangeArray['range'.$i.'_to']:0;
            $arrayNew[$i]['discount'] = isset($getDiscountRangeArray['discount_range'.$i])?$getDiscountRangeArray['discount_range'.$i]:0;
            $arrayNew[$i]['discount_id'] = isset($discountId)?$discountId:0;
            $arrayNew[$i]['diamond_type'] = !empty($getDiscountRangeArray['diamond_type']) ? $getDiscountRangeArray['diamond_type'] : null;
        }
        DiscountRange::where('category_id',$getDiscountRangeArray['category_id'])->delete();
        foreach($arrayNew as $key => $value){
            DiscountRange::create([
                'category_id'=> $value['category_id'],
                'discount_id'=> $value['discount_id'],
                'from_price'=> $value['from'],
                'to_price'=> $value['to'],
                'discount'=> $value['discount'],
                'diamond_type'=> $value['diamond_type'],
                'status'=> 1,
            ]);
        }

        return true;
    }
}
