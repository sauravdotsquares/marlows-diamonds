<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use SoapClient;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\AppProducts;
use App\Models\AppProductCategories;
use App\Models\AppProductImages;
use App\Models\AppProductAttributeVariations;
use App\Models\AppProductAttributes;
use App\Models\AppProductAttributeVariationDescripiton;
use App\Models\Masters;
use App\Models\Category;
use App\Models\GlobalCombinations;
use App\Models\GlobalCombinationsVariations;
use App\Models\Discount;
use App\Models\DiscountRange;
use App\Models\Products\Combinations;
use App\Models\Products\CombinationVaritions;
use App\Models\Products\CombinationAttributes;
use App\Models\Products\CombinationVariationDetails;

use View, Validator;

class AppProductsController extends Controller{

    public function __construct(Request $request){
        $this->view_path = "front.pages.app_products.";
        $this->default_pagination_limit = defaultProductPagination();
        $this->module_name = "Products";
        $this->route_path = "front.app_products";
    }


    /**
     * getProductList
     * works as html render and api for products list
     * @param slug
     */
    public function getProductList(Request $request){

        /** Check if category exists with received slug */
        $category = Category::where('slug',$request['category_slug'])->first();
        if(empty($category)){
            return redirect()->back()->with('error','Something went wrong');
        }

        if ($request->isMethod('post')){

            $pageNo = !empty($request['pageNo']) ? (int)$request['pageNo'] : 1 ;

            /** get list of products with valid category id */
            $query = AppProducts::where(['is_deleted'=>0, 'is_active'=>1, 'is_draft'=> 0])
            ->select(['id','title','slug'])
            ->whereHas('categories', function($q) use ($category) {
                $q->where(['category_id'=> $category->id, 'is_deleted'=>0, 'is_active'=>1]);
            });
            $products = $query->paginate($this->default_pagination_limit, ['*'], 'page', $pageNo);

            $totalPage = ceil($products->total() / $this->default_pagination_limit);
            $nextPage = ($totalPage > $pageNo);

            foreach ($products as $p_key => $p_value) {

                /** Add minimum and maximum price range for product */
                $price = AppProductAttributeVariations::where(['product_id'=> $p_value->id, 'is_deleted'=>0, 'is_active'=>1])->pluck('sale_price');
                if( !empty($price) && $price->count()){
                    $price = array_map(function($element) { return (float)$element; }, $price->toArray());
                    $products[$p_key]->minimum = formatPrice(min($price));
                    $products[$p_key]->maximum = formatPrice(max($price));
                }else{
                    $products[$p_key]->minimum = "0";
                    $products[$p_key]->maximum = "0";
                }

                $products[$p_key]['images'] = AppProductImages::getImages([
                    'belongs_from' => 'md_app_products',
                    'parent_id' => $p_value->id
                ]);

                /** Add thumb image and thumb video  */
                // $products[$p_key]->thumb_image  = AppProductImages::where(['is_deleted'=>0, 'is_active'=>1, 'parent_id'=> $p_value->id, 'belongs_from'=> 'md_app_products', 'image_type'=> 'thumb_image'])->first();
                // $products[$p_key]->thumb_video  = AppProductImages::where(['is_deleted'=>0, 'is_active'=>1, 'parent_id'=> $p_value->id, 'belongs_from'=> 'md_app_products', 'image_type'=> 'thumb_video'])->first();
            }

            // prd($products->toArray());
            $response = [
                'status' => true,
                'data' => $products->items(),
                'isNextPage' => $nextPage,
                'nextPage' => ($products->currentPage()+1),
                'currentPage' => $products->currentPage()
            ];
            return response()->json($response);
        }

        return view($this->view_path . 'list', compact(['category']));

    } /** endof getProductList */

    /**
     * productDetails
     */
    public function productDetails(Request $request){

        /** 
         * TODO: Add product in recent views
         */

        /** get product information */
        $product = AppProducts::with(['images'=>function($query){
            $query->where([
                'is_deleted'=>0, 
                'is_active'=>1,
                'image_type' => 'product_gallery',
                'belongs_from'=>'md_app_products'
            ]);
        }])->where('slug', $request['product_slug'])->first();
        if(empty($product)){
            return redirect()->back()->with('error','Product not identified');
        }

        /** select product variations */
        $product_attr = AppProductAttributes::with('info')->orderBy('display_order','ASC')->where(['product_id'=> $product->id, 'is_deleted'=>0, 'is_active'=> 1 ])->get();
        $varitaions_html = "";
        if($product_attr->count()){
            $product_attr = $product_attr->toArray();
            foreach ($product_attr as $product_attr_key => $product_attr_value) {   
                $varitaions = AppProductAttributeVariationDescripiton::with('info')->groupBy('variation_id')->where([
                    'product_id' => $product->id,
                    'attribute_id' => $product_attr_value['id'],
                    'is_deleted'=>0,
                    'is_active'=>1,
                ])->get();

                if(!$varitaions->count()){
                    /** Attributes for all variations */
                    $varitaions = Masters::with('info')->where(['is_deleted'=>0, 'is_active'=>1, 'parent_id'=> $product_attr_value['attribute_id'] ])->get();
                    if($varitaions->count()){
                        $varitaions = $varitaions->toArray();
                    }else{
                        $varitaions = [];
                    }
                    $isPriceAffected = false;
                }else{
                    $isPriceAffected = true;
                    $varitaions = $varitaions->toArray();
                }
                
                $product_attr_value['variations'] = $varitaions;
                $product_attr_value['isPriceAffected'] = $isPriceAffected;
                $product_attr[$product_attr_key]['variations'] = $varitaions;
                $product_attr[$product_attr_key]['isPriceAffected'] = $isPriceAffected;
                $varitaions_html .= View::make('front.pages.app_products.elements.variations', compact(['product_attr_value']));
            }
        }

        return view($this->view_path . 'details', compact(['product','varitaions_html']));
    }// endof productDetails

    /**
     * getVariationPrice
     * function is used to find the price of selected variations
     */
    public function getVariationPrice(Request $request){

        $validation = Validator::make(request()->all(),[ 
            'productSlug' => 'required',
            'varitaion' => 'required',
        ]);
        if($validation->fails()){
            return response()->json(['status'=>false, 'message'=> 'Validaton errors', 'error'=> $validation->errors() ]);
        }else{

            $response = [
                'original_price' => 0,
                'price_after_combination' => 0,
                'price_after_discount' => 0,
            ];

            /** Check if product is valid or not using slug */
            $product = AppProducts::where('slug', $request['productSlug'])->first();
            if(empty($product)){
                return response()->json(['status'=>false, 'message'=> 'Product not identified' ]);
            }
            $varitaion =  explode(',', $request['varitaion']);

            /** get price using selected variations */
            $all_variations = AppProductAttributeVariations::where(['product_id'=> $product->id])->get()->toArray();
            foreach ($all_variations as $key => $value) {
                $all_variations[$key]['variations'] = AppProductAttributeVariationDescripiton::where(['attribute_variation_id'=>$value['id'], 'is_deleted'=>0, 'is_active'=>1])->pluck('variation_id')->toArray();
            }
            $varitaionData = [];
            foreach ($all_variations as $all_key => $all_value) {
                $result=array_diff($all_value['variations'], $varitaion);
                if(!count($result)){
                    $varitaionData = $all_value;
                    break;
                }
            }
            // prd($varitaionData);die;
            if(empty($varitaionData)){
                return response()->json(['status'=>false, 'message'=> 'Something went wrong', 'error'=> $validation->errors() ]);
            }

            /** Pricing using global combinations You can find the function in Combination Model */
            $combinationsPercentage = Combinations::combination_value($product->combination_id, $varitaion);
            $price_after_combination = ($combinationsPercentage / 100) * $varitaionData['sale_price'];
           

            /** discount of product you can find this function in DiscountRange Model */
            $discount_percentage = DiscountRange::discount_percentage($product->id, $price_after_combination);

            /** Varitation image to send */
            $vr_image = AppProductImages::where(['belongs_from'=>'md_app_product_attribute_variations', 'is_deleted'=> 0, 'is_active'=>1, 'parent_id'=> $varitaionData['id'] ])->first();

            $response['price_after_discount'] = getPercentage($price_after_combination, $discount_percentage);
            $response['price_after_combination'] = round($price_after_combination, 0);
            $response['combination_percentage'] = round($combinationsPercentage, 0);
            $response['original_price'] = round($varitaionData['sale_price'], 0);
            $response['discount_percentage'] = round($discount_percentage, 0);
            

            return response()->json(['status'=>true, 'message'=> 'Price found successfully', 'price'=> $response ,'image'=> $vr_image, 'product' => $product ]);
        }

        

        // prd($varitaionData);
    }


}