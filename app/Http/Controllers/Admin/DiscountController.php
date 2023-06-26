<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Discount;
use App\Models\DiscountRange;
use App\Models\PercentageRange;
use App\Models\MarginApiRange;

class DiscountController extends Controller
{
    /**
     * Display records
     *
     * @return void
     */
    public function index()
    {
        $breadcrumb = [
            ["name" => "Discount", "url" => route("admin.discount"), "icon" => "fa fa-percent"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
        ];

        populate_breadcrumb($breadcrumb);

        $getDiscountData = Discount::latest()->get();

        return view('admin.discount.index', compact('getDiscountData'));
    }

    /**
     * Add discount functionality
     *
     * @return void
     */
    public function addDiscount()
    {
        $breadcrumb = [
            ["name" => "Discount Create", "url" => route("admin.create-discount"), "icon" => "fa fa-percent"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
        ];

        $getParentCategory = Category::select('name', 'slug', 'parent_id', 'short_description', 'description', 'id')->where('parent_id', 0)->get();

        populate_breadcrumb($breadcrumb);
        return view('admin.discount.create', compact('getParentCategory'));
    }

    /**
     * Add discount Data
     *
     * @param Request $request
     * @return void
     */
    public function addDiscountData(Request $request)
    {
        $diamondTypeArr = [];
        if (isset($request->diamond_type) && !empty($request->diamond_type)) {
            array_push($diamondTypeArr, $request->diamond_type);
            $diamondTypeArr = implode(',', $diamondTypeArr);
        } else {
            $diamondAllType = [
                'mined_diamond',
                'lab_grown'
            ];
            $diamondTypeArr = implode(',', $diamondAllType);
        }
        $isDicountForLoginUsers = empty($request['is_login_users']) ? 0 : 1;

        if (!empty($request->category_id)) {
            $getDuplicateDiscount = Discount::where('category_id', $request->category_id)->first();
            if (isset($getDuplicateDiscount) && !empty($getDuplicateDiscount)) {
                if (isset($request->table_id) && !empty($request->table_id)) {
                    $insDiscountData = Discount::updateOrCreate(['id' => $request->table_id], [
                        'title' => $request->title,
                        'category_id' => $request->category_id,
                        'category_slug' => $request->category_slug,
                        'discount' => $request->discount,
                        'inc_percentage' => $request->inc_percentage,
                        'end_date' => $request->end_date,
                        'is_login_users' => $isDicountForLoginUsers,
                        'status' => $request->status,
                        'diamond_type' => $diamondTypeArr,
                    ]);
                    $this->addDiscountRanges($request->all(), $insDiscountData->id, $diamondTypeArr);
                    $this->addPercentageRanges($request->all(), $insDiscountData->id);
                } else {
                    $this->addDiscountRanges($request->all(), $getDuplicateDiscount->id, $diamondTypeArr);
                    $this->addPercentageRanges($request->all(), $getDuplicateDiscount->id);
                }

                return redirect()->action('Admin\DiscountController@index')->with('alert-success', 'Duplicate Category not allowed');
            } else {
                $insDiscountData = Discount::updateOrCreate(['category_id' => $request->category_id], [
                    'title' => $request->title,
                    'category_id' => $request->category_id,
                    'category_slug' => $request->category_slug,
                    'discount' => $request->discount,
                    'inc_percentage' => $request->inc_percentage,
                    'end_date' => $request->end_date,
                    'status' => $request->status,
                    'is_login_users' => $isDicountForLoginUsers,
                    'diamond_type' => $diamondTypeArr,
                ]);

                $this->addDiscountRanges($request->all(), $insDiscountData->id, $diamondTypeArr);
                $this->addPercentageRanges($request->all(), $insDiscountData->id);

                return redirect()->action('Admin\DiscountController@index')->with('alert-success', 'Discount Added Successfully');
            }
        } else {
            return redirect()->back()->with('alert-error', 'Something went wrong');
        }
    }

    /**
     * Edit Page Discount Data
     *
     * @param [type] $discountId
     * @return void
     */
    public function editPageDiscountData($discountId)
    {
        $getDiscountData = Discount::where('id', $discountId)->first();

        $breadcrumb = [
            ["name" => "Edit Discount", "url" => route("admin.create-discount"), "icon" => "fa fa-percent"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
        ];

        $getParentCategory = Category::select('name', 'slug', 'parent_id', 'short_description', 'description', 'id')->where('parent_id', 0)->get();

        populate_breadcrumb($breadcrumb);

        return view('admin.discount.create', compact('getParentCategory', 'getDiscountData'));
    }

    /**
     * Change Status
     *
     * @param Request $request
     * @return void
     */
    public function status(Request $request)
    {
        $statusChange = Discount::findOrFail($request->id);
        if ($statusChange) {
            $statusChange->update([
                'status' => $request->status,
            ]);
            return response()->json($statusChange);
        }
        return response()->json(['error' => 'geterror'], 422);
    }

    /**
     * Removed records
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request)
    {
        $post = Discount::find($request->id)->delete();
        return response()->json($post);
    }

    /**
     * Add Discount Ranges
     *
     * @param [type] $getDiscountRangeArray
     * @param [type] $discountId
     * @param [type] $discountType
     * @return void
     */
    public function addDiscountRanges($getDiscountRangeArray, $discountId, $discountType)
    {
        $arrayNew = [];

        for ($i = 1; $i <= 7; $i++) {
            $arrayNew[$i]['category_id'] = isset($getDiscountRangeArray['category_id']) ? $getDiscountRangeArray['category_id'] : 0;
            $arrayNew[$i]['from'] = isset($getDiscountRangeArray['range' . $i . '_from']) ? $getDiscountRangeArray['range' . $i . '_from'] : 0;
            $arrayNew[$i]['to'] = isset($getDiscountRangeArray['range' . $i . '_to']) ? $getDiscountRangeArray['range' . $i . '_to'] : 0;
            $arrayNew[$i]['discount'] = isset($getDiscountRangeArray['discount_range' . $i]) ? $getDiscountRangeArray['discount_range' . $i] : 0;
            $arrayNew[$i]['discount_id'] = isset($discountId) ? $discountId : 0;
            $arrayNew[$i]['diamond_type'] = !empty($getDiscountRangeArray['diamond_type']) ? $getDiscountRangeArray['diamond_type'] : null;
        }
        DiscountRange::where('category_id', $getDiscountRangeArray['category_id'])->delete();
        foreach ($arrayNew as $key => $value) {
            DiscountRange::create([
                'category_id' => $value['category_id'],
                'discount_id' => $value['discount_id'],
                'from_price' => $value['from'],
                'to_price' => $value['to'],
                'discount' => $value['discount'],
                'diamond_type' => $discountType,
                'status' => 1,
            ]);
        }
        return true;
    }

    /**
     * Add Percentage Ranges
     *
     * @param [type] $getDiscountRangeArray
     * @param [type] $discountId
     * @return void
     */
    public function addPercentageRanges($getDiscountRangeArray, $discountId)
    {
        $arrayPercentageValue = [];

        for ($i = 1; $i <= 7; $i++) {
            $arrayPercentageValue[$i]['category_id'] = isset($getDiscountRangeArray['category_id']) ? $getDiscountRangeArray['category_id'] : 0;
            $arrayPercentageValue[$i]['from'] = isset($getDiscountRangeArray['range' . $i . '_inc_from']) ? $getDiscountRangeArray['range' . $i . '_inc_from'] : 0;
            $arrayPercentageValue[$i]['to'] = isset($getDiscountRangeArray['range' . $i . '_inc_to']) ? $getDiscountRangeArray['range' . $i . '_inc_to'] : 0;
            $arrayPercentageValue[$i]['discount'] = isset($getDiscountRangeArray['discount_inc_range' . $i]) ? $getDiscountRangeArray['discount_inc_range' . $i] : 0;
            $arrayPercentageValue[$i]['discount_id'] = isset($discountId) ? $discountId : 0;
            $arrayPercentageValue[$i]['diamond_type'] = !empty($getDiscountRangeArray['diamond_type']) ? $getDiscountRangeArray['diamond_type'] : null;
        }

        PercentageRange::where('category_id', $getDiscountRangeArray['category_id'])->delete();
        foreach ($arrayPercentageValue as $key => $value) {
            if ($value['to'] != 0) {
                PercentageRange::create([
                    'category_id' => $value['category_id'],
                    'discount_id' => $value['discount_id'],
                    'from_price' => $value['from'],
                    'to_price' => $value['to'],
                    'percentage' => $value['discount'],
                    'diamond_type' => $value['diamond_type'],
                    'status' => 1,
                ]);
            }
        }
        return true;
    }

    /**
     * API Margin Module
     *
     * @param [type] $apiType
     * @return void
     */
    public function apiMarginModule($apiType = null)
    {
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Margin Create", "url" => route("admin.api-margin-module"), "icon" => "fa fa-percent"],

        ];
        populate_breadcrumb($breadcrumb);
        if (is_null($apiType)) {
            $apiType = 'harikrishna';
        }
        $getApiMarginData = MarginApiRange::where('api_type', $apiType)->get();
        return view('admin.margin.create', compact('getApiMarginData', 'apiType'));
    }

    /**
     * Add Margin Module
     *
     * @param Request $request
     * @return void
     */
    public function addMarginModule(Request $request)
    {
        $getApiMarginRangeArray = $request->all();

        $arrayNew = [];
        for ($i = 1; $i <= 7; $i++) {
            $arrayNew[$i]['api_type'] = isset($getApiMarginRangeArray['api_type']) ? $getApiMarginRangeArray['api_type'] : 0;
            $arrayNew[$i]['from'] = isset($getApiMarginRangeArray['from_price' . $i]) ? $getApiMarginRangeArray['from_price' . $i] : 0;
            $arrayNew[$i]['to'] = isset($getApiMarginRangeArray['to_price' . $i]) ? $getApiMarginRangeArray['to_price' . $i] : 0;
            $arrayNew[$i]['percentage'] = isset($getApiMarginRangeArray['percentage' . $i]) ? $getApiMarginRangeArray['percentage' . $i] : 0;
        }
        MarginApiRange::where('api_type', $getApiMarginRangeArray['api_type'])->delete();
        foreach ($arrayNew as $key => $value) {
            if ($value['from'] != 0) {
                MarginApiRange::updateOrCreate(['id' => $request->table_id], [
                    'api_type' => $value['api_type'],
                    'from_price' => $value['from'],
                    'to_price' => $value['to'],
                    'percentage' => $value['percentage'],
                    'status' => 1,
                ]);
            }
        }
        return redirect()->action('Admin\DiscountController@apiMarginModule')->with('alert-success', 'Margin Added Successfully');
    }
}
