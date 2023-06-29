<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\ProductController;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Country;
use App\Models\User;
use Auth;
use billythekid\dekopay\Core\DekoPayApiClient;

class AddToCartController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $cart = session()->get('cart');
        return view('front.pages.cart');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart(Request $request)
    {
        $getActualPrice = new ProductController;
        $getPriceFunction = $getActualPrice->getProductVariationPrices($request);

        /** Add item in cart for lab grown */
        $productData = Products::with('getProductImages', 'getProductVariation')->where('slug', $request->slug)->first();
        if (!empty($productData)) {

            /** If product already exists then show exit message */
            $cart = session()->get('cart', []);
            if (isset($cart[$productData->id])) {
                return response()->json(['error' => 'This product is already exists in cart']);
            }

            $customArray = [];
            foreach ($request->all('') as $key => $value) {
                $customArray[$key] = $value;
                if (isset($key) && $key == 'jsondata') {
                    foreach ($value as $key2 => $value2) {
                        $customArray[$key2] = $value2;
                    }
                }
            }
            $customArray['Clarity'] = !empty($request['clarity']) ? $request['clarity'] : '';
            $customArray['Color'] = !empty($request['color']) ? $request['color'] : '';
            $customArray['Carat'] = !empty($request['carat']) ? $request['carat'] : '';
            $customArray['choose_diamond'] = !empty($request['diamond_type']) ? $request['diamond_type'] : '';

            unset($customArray['jsondata']);
            unset($customArray['_token']);
            unset($customArray['CertificateLink']);
            unset($customArray['ImageLink']);
            unset($customArray['CERT_NO']);
            unset($customArray['Lab']);

            $cart[$productData->id] = [
                "name" => $productData->title,
                'customArray' => $customArray,
                "quantity" => 1,
                // "price" => $request['lab_grown_price'],
                "deposited_price" => $getPriceFunction['allPrices']['discounted_price'],
                "vat" => getVATPriceFunction($request['setting_price']),
                "image" => $productData->getProductImages->image_url,
                "price_front" => $request['lab_grown_price'],
                "rrp_price" => $getPriceFunction['allPrices']['rrp_price'],
                "shop_price" => $getPriceFunction['allPrices']['shop_price'],
                'price' => $getPriceFunction['allPrices']['discounted_price'],
                "savePrice" => $getPriceFunction['allPrices']['rrp_price'] - $getPriceFunction['allPrices']['discounted_price'],
                "deposited_price" => $getPriceFunction['allPrices']['discounted_price'],
                'getLabDiamondPrices' => $getPriceFunction['getLabDiamondPrices'],
            ];

            session()->put('cart', $cart);
            return response()->json(['cartcount' => count((array) session('cart')), 'success' => 'Product added to cart successfully!']);
        }
        return response()->json(['error' => 'Please Wait...']);
    }

    /**
     * Add to cart with diamond functionality
     *
     * @param Request $request
     * @return void
     */
    public function addToCartDiamond(Request $request)
    {
        if (isset($request->CERT_NO) && !empty($request->CERT_NO) && $request->CERT_NO > 0) {
            /** If product already exists then show exit message */
            $cart = session()->get('cart', []);
            if (isset($cart[$request->CERT_NO])) {
                return response()->json(['error' => 'This diamond is already exists in cart']);
            }

            $input = $request->all('');
            unset($request['price']);
            unset($request['partial_amount']);
            unset($request['total_amount']);
            unset($request['_token']);

            $selectedAttributes = [];
            foreach ($request->all('') as $key => $finalVal) {
                if (isset($finalVal) && !empty($finalVal)) {
                    $selectedAttributes[$key] = $finalVal;
                }
            }
            $cart = session()->get('cart', []);
            $cart[$request->CERT_NO] = [
                "name" => 'Custom Diamond',
                "customArray" => $selectedAttributes,
                "quantity" => 1,
                "price" => isset($input['total_amount']) ? floatval(preg_replace('/[^\d.]/', '', $input['total_amount'])) : $input['price'],
                "deposited_price" => floatval(preg_replace('/[^\d.]/', '', $input['partial_amount'])),
                "vat" => getVATPriceFunction($input['partial_amount']),
                "image" => ''
            ];
            session()->put('cart', $cart);
            return response()->json(['cartcount' => count((array) session('cart')), 'success' => 'Product added to cart successfully!']);
        } else {
            return response()->json(['error' => 'Not Added...']);
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['status' => 200, 'msg' => 'Product removed successfully']);
        }
    }

    /**
     * Checkout order with deko pay payament gateway functionality
     *
     * @param Request $request
     * @return void
     */
    public function checkoutOrder(Request $request)
    {
        $dekoEnabled = true;
        $client = new DekoPayApiClient('', '', env('DEKOPAY_API_KEY'));
        $pay_url =  env('DEKOPAY_MODE');

        if ($dekoEnabled) {
            $url = $pay_url == 'live' ? 'https://secure.dekopay.com/js_api/FinanceDetails.js.php?api_key=' . env('DEKOPAY_API_KEY')  : 'https://test.dekopay.com/js_api/FinanceDetails.js.php?api_key=' . env('DEKOPAY_API_KEY');
        }

        $cart = session()->get('cart');
        if (isset($cart) && !empty($cart)) {
            $getCountries = Country::get();
            $getUsersDetails = [];
            if (Auth::guard('customer')->check() && isset(Auth::guard('customer')->user()->id)) {
                $getUsersDetails = User::with('getCustomerAddressFunction')->where('id', Auth::guard('customer')->user()->id)->first();
            }
            return view('front.pages.checkout', compact('getCountries', 'getUsersDetails', 'url'));
        }
        return redirect()->route('home');
    }
}
