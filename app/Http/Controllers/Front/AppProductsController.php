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

// use App\Models\Products;
// use App\Models\ProductVariationAttributes;
// use App\Models\Attributes;
// use App\Models\ProductVariations;
// use App\Models\ProductVariationDetails;

use View;

// use billythekid\dekopay\Core\DekoPayApiClient;
// use App\Models\AppProducts;

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
        // select(['slug','id','name'])->
        $category = Category::where('slug',$request['category_slug'])->first();
        if(empty($category)){
            return redirect()->back()->with('error','Something went wrong');
        }

        // prd($category);die;
        
        if ($request->isMethod('post')){

            $pageNo = !empty($request['pageNo']) ? (int)$request['pageNo'] : 1 ;

            /** get list of products with valid category id */
            $query = AppProducts::where(['is_deleted'=>0, 'is_active'=>1, 'is_draft'=> 0])
            ->select(['id','title','slug'])
            ->whereHas('categories', function($q) use ($category) {
                $q->where(['category_id'=> $category->id, 'is_deleted'=>0, 'is_active'=>1]);
            });
            $products = $query->paginate( $this->default_pagination_limit, ['*'], 'page', $pageNo);

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

                /** Add thumb image and thumb video  */
                $products[$p_key]->thumb_image  = AppProductImages::where(['is_deleted'=>0, 'is_active'=>1, 'parent_id'=> $p_value->id, 'belongs_from'=> 'md_app_products', 'image_type'=> 'thumb_image'])->first();
                $products[$p_key]->thumb_video  = AppProductImages::where(['is_deleted'=>0, 'is_active'=>1, 'parent_id'=> $p_value->id, 'belongs_from'=> 'md_app_products', 'image_type'=> 'thumb_video'])->first();
            }

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
        $product_attr = AppProductAttributes::with('info')->where(['product_id'=> $product->id, 'is_deleted'=>0, 'is_active'=> 1 ])->get();
        // echo $product_attr->count();die;
        // prd($product_attr->toArray());die;
        foreach ($product_attr as $product_attr_key => $product_attr_value) {
            
            $product_attr[$product_attr_key]->variations = AppProductAttributeVariationDescripiton::with('info')->groupBy('variation_id')->where([
                'product_id' => $product->id,
                'attribute_id' => $product_attr_value->id,
                'is_deleted'=>0,
                'is_active'=>1,
            ])->get()->toArray();

            // echo '<pre>';
            // print_r($product_attr[$product_attr_key]->variations->toArray());
            // echo '</pre>';
        }die;
        // prd($product_attr->toArray());

        return view($this->view_path . 'details', compact(['product']));
    }// endof productDetails


}