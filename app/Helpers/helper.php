<?php

/**
 * Created by PhpStorm.
 * User: shehbaz
 * Date: 1/21/19
 * Time: 12:19 PM
 */


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Reviews;
use App\Models\PostCategory;
use App\Models\Posts;
use App\Models\Pages;
use App\Models\Faqs;
use App\Models\FaqCategory;
use App\Models\HKDiamondStock;
use App\Models\Products;
use App\Models\InstagramData;
use App\Models\Masters;
use App\Models\Category;
use App\Models\Attributes;
use App\Models\Popups;
use App\Models\MarginApiRange;
use App\Models\DiscountRange;
use App\Models\ProductVariations;
use App\Models\ProductVariationDetails;
use App\Models\ProductThumbVideos;
use App\Models\UrlRedirects;
use App\Models\LabPricesList;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Cache;

//use SoapClient;
use billythekid\dekopay\Core\DekoPayApiClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

if (!function_exists("helper_test")) {
    function helper_test()
    {
        echo "it is working";
    }
}
if (!function_exists("getVAT")) {
    function getVAT()
    {
        return 1.2;
    }
}

if (!function_exists("single_image_upload")) {
    function single_image_upload($imageUrl, $folderName, $height = null, $width = null)
    {
        if (!file_exists(storage_path('app/public/' . $folderName))) {
            mkdir(storage_path('app/public/' . $folderName), 0777);
        }
        $uploadpath = public_path() . '\images\\' . $folderName;
        if (is_array($imageUrl)) {
            foreach ($imageUrl as $file) {

                $filenameWithExt = $file->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $file->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $folderName . '/' . $filename . '_' . time() . '.' . $extension;
                // Upload Image
                $path = $file->storeAs('public', $fileNameToStore);
                // return $fileNameToStore;

                // $original_name = $file->getClientOriginalName();
                // $filename = $folderName.'/'.rand().time() . '_' . $file->getClientOriginalName();
                // $file->move($uploadpath, $filename);
                $data[] = $fileNameToStore;
            }
        } else {

            $filenameWithExt = $imageUrl->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $imageUrl->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $folderName . '/' . $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $imageUrl->storeAs('public', $fileNameToStore);

            // $original_name = $imageUrl->getClientOriginalName();
            // $filename = $folderName.'/'.rand().time() . '_' . $imageUrl->getClientOriginalName();
            // $imageUrl->move($uploadpath, $filename);
            $data['f2'] = $fileNameToStore;
        }
        return $data;
    }
}

if (!function_exists("single_storage_image_upload")) {
    function single_storage_image_upload($imageUrl, $folderName, $height = 0, $width = 0)
    {
        if (!file_exists(storage_path('app/public/' . $folderName))) {
            mkdir(storage_path('app/public/' . $folderName), 0777);
        }
        // $height = 200;
        // $width = 200;
        $image = $imageUrl;
        // echo '<pre>';print_r($image); die;
        $imageName = $image->getClientOriginalName();

        if (!empty($height) && !empty($width)) {
            $fileName =  $folderName . '/' . time() . '-' . $height . 'x' . $width . $imageName;
            Image::make($image)->resize($height, $width)->save(storage_path('app/public/' . $fileName));
        } else {
            $fileName =  $folderName . '/' . time() . $imageName;
            Image::make($image)->save(storage_path('app/public/' . $fileName));
        }


        return $fileName;
    }
}



if (!function_exists("product_image_upload")) {
    function product_image_upload($imageUrl, $folderName)
    {

        $filenameWithExt = $imageUrl->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $imageUrl->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $folderName . '/' . $filename . '_' . time() . '.' . $extension;
        // Upload Image
        $path = $imageUrl->storeAs('public', $fileNameToStore);

        return  $fileNameToStore;

        // return $data;
    }
}
if (!function_exists("product_video_upload")) {
    function product_video_upload($imageUrl, $folderName)
    {
        $filenameWithExt = $imageUrl->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $imageUrl->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $folderName . '/' . $filename . '_' . time() . '.' . $extension;
        // Upload Image
        $path = $imageUrl->storeAs('public', $fileNameToStore);

        return  $fileNameToStore;

        // return $data;
    }
}

if (!function_exists("multiple_image_upload")) {
    function multiple_image_upload()
    {
        echo "it is working multiple";
    }
}


if (!function_exists("populate_breadcrumb")) {
    /**
     * popular data to layouts.admin.app when send from controller
     *
     *<h1> controller example </h1>
     * <pre>
     *  $data = [
     * ["name" => "Dashboard1", "url" => route("admin.dashboard")],
     * ["name" => "Products1", "url" => request()->fullUrl()]
     * ];
     *
     * populate_breadcrumb($data)
     * </pre>
     *
     * @param $data
     * @return void
     */
    function populate_breadcrumb($data)
    {
        $validated = validate_breadcrumb($data);
        if ($validated["valid"] === true) {
            view()->composer([
                "layouts.admin.app"
            ], function ($view) use ($data) {
                $view->with(
                    [
                        "breadcrumbs" => $data
                    ]
                );
            });
        }
    }
}

if (!function_exists('validate_breadcrumb')) {

    /**
     * validate breadcrumb data
     * @param $data
     * @return array
     */
    function validate_breadcrumb($data)
    {
        $validated = false;
        $errors = [];
        foreach ($data as $key => $item) {
            $messages = [
                'required' => "The :attribute field is required at index: $key.",
                "url" => "The :attribute format is invalid at index: $key"

            ];
            $validator = Validator::make($item, [
                'name' => 'required',
                'url' => "required|url",
                // "icon" => ""
            ], $messages);
            if ($validator->fails()) {
                $validated = false;
                $errors[] = $validator->errors();
            } else {
                $validated = true;
            }
        }
        return ["errors" => $errors, "valid" => $validated];
    }

    if (!function_exists('in_array_r')) {
        // Function to iteratively search for a given value
        function in_array_r($item, $array)
        {
            return preg_match('/"' . preg_quote($item, '/') . '"/i', json_encode($array));
        }
    }


    if (!function_exists("getReviews")) {
        function getReviews()
        {
            try {
                $reviews = Reviews::where('status', 1)->get();
                return ($reviews);
            } catch (\Throwable $th) {
                return [];
            }
        }
    }

    if (!function_exists("getCategories")) {
        function getCategories()
        {
            try {
                $postcategories = PostCategory::orderBy('name', 'asc')->get();
                return ($postcategories);
            } catch (\Throwable $th) {
                return [];
            }
        }
    }

    if (!function_exists("getRecentPosts")) {
        function getRecentPosts()
        {
            try {
                $recentposts = Posts::take(5)->orderBy('id', 'DESC')->where('status', 1)->get();
                return ($recentposts);
            } catch (\Throwable $th) {
                return [];
            }
        }
    }
    if (!function_exists("getRelatedPosts")) {
        function getRelatedPosts()
        {
            try {
                $relatedposts = Posts::take(5)->orderBy('id', 'DESC')->where('status', 1)->get();
                return ($relatedposts);
            } catch (\Throwable $th) {
                return [];
            }
        }
    }
    if (!function_exists("getEngagementRingsPosts")) {
        function getEngagementRingsPosts()
        {
            try {
                $relatedposts = Posts::take(10)->orderBy('id', 'DESC')->where('categories', 18)->where('status', 1)->select('title', 'slug', 'description', 'image')->get();
                return ($relatedposts);
            } catch (\Throwable $th) {
                return [];
            }
        }
    }
    if (!function_exists("getFaqs")) {
        function getFaqs()
        {
            $faqs = FaqCategory::with('getFAQData')->take(5)->get();
            return ($faqs);
        }
    }

    if (!function_exists("getFaqsAllCategory")) {
        function getFaqsAllCategory()
        {
            $faqs = FaqCategory::get();
            return ($faqs);
        }
    }
    if (!function_exists("getEngagementFaqs")) {
        function getEngagementFaqs()
        {
            $getengagementfaqs = Faqs::take(50)->orderBy('id', 'DESC')->where('status', 1)->where('categories', 0)->get();
            return ($getengagementfaqs);
        }
    }

    if (!function_exists("getFeaturedProducts")) {
        // function getFeaturedProducts()
        // {
        //     $featured = Products::with(['getProductImages'])->where('is_featured', 1)->limit(10)->get();
        //     return $featured;
        // }

        // Deepak Sharma
        /**
         * Returns up to 10 featured products, cached.
         * Cache key is 'featured_products'.
         */
        // function getFeaturedProducts()
        // {
        //     // Adjust TTL (seconds) as you like
        //     $ttl = 3600;

        //     return Cache::remember('featured_products', $ttl, function () {
        //         return Products::where('is_featured', 1)
        //             ->with(['getProductImages'])
        //             ->limit(10)
        //             ->get();
        //     });
        // }
        function getFeaturedProducts()
        {
            $ttl = 3600; // cache time in seconds (1 hour)

            return Cache::remember('featured_products', $ttl, function () {
                // preload lab price once
                $labPrice = LabPricesList::whereBetween('carat', [1.00, 1.19])
                    ->where(['color' => 'D', 'clarity' => 'VS2', 'is_active' => 1, 'is_deleted' => 0])
                    ->first();

                // preload products + variations + images
                $products = Products::where('is_featured', 1)
                    ->with(['getProductImages'])
                    ->limit(10)
                    ->get();

                // compute getMinimumPriceFunction for each product
                foreach ($products as $product) {
                    $product->getMinimumPriceFunction = getMinimumPriceFunction($product, $labPrice);
                }

                return $products;
            });
        }
    }

    function getFaqByCategory($category = "", $in_array = false)
    {
        $category = empty($category) ? 0 : $category;
        if (is_array($category)) {
            $faqs = Faqs::whereIn('categories', $category)->get();
        } else {
            $faqs = Faqs::where(['categories' => $category])->get();
        }

        if ($in_array && $faqs->count()) {
            return $faqs->toArray();
        }
        return $faqs;
    }

    /*
    ** Hari Krishna API function
    * @params : data as array
    */
    if (!function_exists("getHKApiRecords")) {

        function getHKApiRecords($data = array())
        {
            $results = HKDiamondStock::where('Shape', 'LIKE', $data['shape'])
                ->whereBetween('Carat', [$data['caratFrom'], $data['caratTo']])
                ->orderBy('Amount', 'ASC');

            if (!empty($data['colour'])) {
                $results = $results->whereIn('Color', $data['colour']);
            }

            if (!empty($data['clarity'])) {
                $results = $results->whereIn('Clarity', $data['clarity']);
            }

            if (!empty($data['grade'])) {
                $results = $results->whereIn('Cut', $data['grade']);
            }

            if (!empty($data['polish'])) {
                $results = $results->whereIn('Polish', $data['polish']);
            }

            if (!empty($data['symmetry'])) {
                $results = $results->whereIn('Symmetry', $data['symmetry']);
            }

            if (!empty($data['fluorescence'])) {
                $results = $results->whereIn('Flourescent', $data['fluorescence']);
            }

            if (!empty($data['certificate'])) {
                $results = $results->whereIn('Lab', $data['certificate']);
            }

            $results = $results->orderBy('id', 'ASC');

            if (isset($data['paging']))
                $results = $results->paginate($data['paging']);
            else if (isset($data['num_of_row']))
                $results = $results->take($data['num_of_row'])->get();
            else
                $results = $results->get();

            return $results->toArray();
        }
    }
    /*
    ** Rapnet API function
    * @params : data as array
    */
    if (!function_exists("getRapnetApiRecords")) {

        function getRapnetApiRecords($data = array(), $pageNumber = null)
        {

            $client = new SoapClient("https://technet.rapaport.com/WebServices/RetailFeed/Feed.asmx?WSDL", array("trace" => 1, "exceptions" => 0, "cache_wsdl" => 0));

            $params = array('Username' => '95503', 'Password' => '@diamond1');
            $client->__soapCall("Login", array($params), NULL, NULL, $output_headers);

            $ticket = $output_headers["AuthenticationTicketHeader"]->Ticket;

            // $client1 = new SoapClient("https://technet.rapaport.com/WebServices/RetailFeed/Feed.asmx?WSDL", array( "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0) );

            $rapnetData = $rapnetAllData = array();

            $ns = "http://technet.rapaport.com/";
            $headerBody = array("Ticket" => $ticket);
            $header = new \SoapHeader($ns, 'AuthenticationTicketHeader', $headerBody);
            $client->__setSoapHeaders($header);

            if (isset($data['gradeFrom'])) {
                if ($data['gradeFrom'] == 'EX') {
                    $gradeFrom = 'EXCELLENT';
                } elseif ($data['gradeFrom'] == 'VG') {
                    $gradeFrom = 'VERY_GOOD';
                } elseif ($data['gradeFrom'] == 'GD') {
                    $gradeFrom = 'GOOD';
                }
            }
            if (isset($data['gradeTo'])) {
                if ($data['gradeTo'] == 'EX') {
                    $gradeTo = 'EXCELLENT';
                } elseif ($data['gradeTo'] == 'VG') {
                    $gradeTo = 'VERY_GOOD';
                } elseif ($data['gradeTo'] == 'GD') {
                    $gradeTo = 'GOOD';
                }
            }
            if (isset($data['symmetryFrom'])) {
                if ($data['symmetryFrom'] == 'EX') {
                    $symmetryFrom = 'Excellent';
                } elseif ($data['symmetryFrom'] == 'VG') {
                    $symmetryFrom = 'Very_Good';
                } elseif ($data['symmetryFrom'] == 'GD') {
                    $symmetryFrom = 'Good';
                }
            }
            if (isset($data['symmetryTo'])) {
                if ($data['symmetryTo'] == 'EX') {
                    $symmetryTo = 'Excellent';
                } elseif ($data['symmetryTo'] == 'VG') {
                    $symmetryTo = 'Very_Good';
                } elseif ($data['symmetryTo'] == 'GD') {
                    $symmetryTo = 'Good';
                }
            }
            if (isset($data['polishFrom'])) {
                if ($data['polishFrom'] == 'EX') {
                    $polishFrom = 'Excellent';
                } elseif ($data['polishFrom'] == 'VG') {
                    $polishFrom = 'Very_Good';
                } elseif ($data['polishFrom'] == 'GD') {
                    $polishFrom = 'Good';
                }
            }
            if (isset($data['polishTo'])) {
                if ($data['polishTo'] == 'EX') {
                    $polishTo = 'Excellent';
                } elseif ($data['polishTo'] == 'VG') {
                    $polishTo = 'Very_Good';
                } elseif ($data['polishTo'] == 'GD') {
                    $polishTo = 'Good';
                }
            }


            $searchParams = array(
                "ShapeCollection" => array($data['shape']),
                "LabCollection" => $data['certificate'],
                "ColorFrom" => $data['colorFrom'],
                "ColorTo" => $data['colorTo'],
                "ClarityFrom" => $data['clarityFrom'],
                "ClarityTo" => $data['clarityTo'],
                "SizeFrom" => $data['caratFrom'],
                "SizeTo" => $data['caratTo'],
                "CutFrom" => $gradeFrom,
                "CutTo" => $gradeTo,
                "SymmetryFrom" => $symmetryFrom,
                "SymmetryTo" => $symmetryTo,
                "PolishFrom" => $polishFrom,
                "PolishTo" => $polishTo,
                "FluorescenceIntensityCollection" => $data['fluorescence'],
                "PriceFrom" => "1",
                "PriceTo" => "999999",
                "PageNumber" => $pageNumber,
                "PageSize" => $data['PageSize'],
                "SortDirection" => "ASC",
                "SortBy" => "PRICE"
            );


            $params1 = array("SearchParams" => $searchParams, "DiamondsFound" => 0);

            $results = $client->__soapCall("GetDiamonds", array($params1), NULL, NULL, $output_headers);

            if (isset($results->GetDiamondsResult) && !empty($results->GetDiamondsResult->any)) {
                $apiXmlResponse = simplexml_load_string($results->GetDiamondsResult->any);
                $object = json_decode(json_encode($apiXmlResponse->NewDataSet));
            } else {
                $object = new \stdclass;
                $object->Table1 = '';
            }

            if (isset($object->Table1) && !empty($object->Table1)) {
                $allData[] = $object->Table1;
            } else {
                $allData = [
                    '0' => '',
                ];
            }

            if (!empty($allData)) {
                $rapnetAllData = array_merge($rapnetData, $allData);
            }

            return $rapnetAllData;
        }
    }

    /*
    ** Rapnet API function
    * @params : data as array
    */
    if (!function_exists("getRapnetApiRecordsDiamondSearch")) {

        function getRapnetApiRecordsDiamondSearch($data = array(), $pageNumber = null)
        {

            $client = new SoapClient("https://technet.rapaport.com/WebServices/RetailFeed/Feed.asmx?WSDL", array("trace" => 1, "exceptions" => 0, "cache_wsdl" => 0));

            $params = array('Username' => '95503', 'Password' => '@diamond1');
            $client->__soapCall("Login", array($params), NULL, NULL, $output_headers);
            $ticket = $output_headers["AuthenticationTicketHeader"]->Ticket;

            // $client1 = new SoapClient("https://technet.rapaport.com/WebServices/RetailFeed/Feed.asmx?WSDL", array( "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0) );

            $rapnetData = $rapnetAllData = array();

            $ns = "http://technet.rapaport.com/";
            $headerBody = array("Ticket" => $ticket);
            $header = new \SoapHeader($ns, 'AuthenticationTicketHeader', $headerBody);
            $client->__setSoapHeaders($header);

            if (isset($data['gradeFrom'])) {
                if (strtoupper($data['gradeFrom']) == 'EX') {
                    $gradeFrom = 'EXCELLENT';
                } elseif (strtoupper($data['gradeFrom']) == 'VG') {
                    $gradeFrom = 'VERY_GOOD';
                } elseif (strtoupper($data['gradeFrom']) == 'GD') {
                    $gradeFrom = 'GOOD';
                }
            }
            if (isset($data['gradeTo'])) {
                if (strtoupper($data['gradeTo']) == 'EX') {
                    $gradeTo = 'EXCELLENT';
                } elseif (strtoupper($data['gradeTo']) == 'VG') {
                    $gradeTo = 'VERY_GOOD';
                } elseif (strtoupper($data['gradeTo']) == 'GD') {
                    $gradeTo = 'GOOD';
                }
            }
            if (isset($data['symmetryFrom'])) {
                if (strtoupper($data['symmetryFrom']) == 'EX') {
                    $symmetryFrom = 'Excellent';
                } elseif (strtoupper($data['symmetryFrom']) == 'VG') {
                    $symmetryFrom = 'Very_Good';
                } elseif (strtoupper($data['symmetryFrom']) == 'GD') {
                    $symmetryFrom = 'Good';
                }
            }
            if (isset($data['symmetryTo'])) {
                if (strtoupper($data['symmetryTo']) == 'EX') {
                    $symmetryTo = 'Excellent';
                } elseif (strtoupper($data['symmetryTo']) == 'VG') {
                    $symmetryTo = 'Very_Good';
                } elseif (strtoupper($data['symmetryTo']) == 'GD') {
                    $symmetryTo = 'Good';
                }
            }
            if (isset($data['polishFrom'])) {
                if (strtoupper($data['polishFrom']) == 'EX') {
                    $polishFrom = 'Excellent';
                } elseif (strtoupper($data['polishFrom']) == 'VG') {
                    $polishFrom = 'Very_Good';
                } elseif (strtoupper($data['polishFrom']) == 'GD') {
                    $polishFrom = 'Good';
                }
            }
            if (isset($data['polishTo'])) {
                if (strtoupper($data['polishTo']) == 'EX') {
                    $polishTo = 'Excellent';
                } elseif (strtoupper($data['polishTo']) == 'VG') {
                    $polishTo = 'Very_Good';
                } elseif (strtoupper($data['polishTo']) == 'GD') {
                    $polishTo = 'Good';
                }
            }

            $dataNew['request']['header'] = [
                "username" => "cdf1xxse9ynns85lwkxl7heviq8vlo",
                "password" => "zoDi5QNW"
            ];

            $fluroscenceArray = [
                "F" => "Faint",
                "M" => "Medium",
                "ST" => "Strong",
                "VS" => "Very Strong",
                "N" => "None"
            ];
            $fluroscenceArraySmall = [
                "f" => "Faint",
                "m" => "Medium",
                "st" => "Strong",
                "vs" => "Very Strong",
                "n" => "None"
            ];

            $fluroscenceNewArray = [];
            if (count($data['fluorescence']) > 0) {
                foreach ($data['fluorescence'] as $newKey => $valuePass) {
                    if (preg_match('/[a-z]/', $valuePass)) {
                        $getFluValue = $fluroscenceArraySmall[$valuePass];
                        $fluroscenceNewArray[] = $getFluValue;
                    } else {
                        $getFluValue = $fluroscenceArray[$valuePass];
                        $fluroscenceNewArray[] = $getFluValue;
                    }
                }
            }


            $dataNew['request']['body'] = array(
                "shapes" => array($data['shape']),
                "labs" => isset($data['certificate']) && count($data['certificate']) ? $data['certificate'] : ['GIA', 'IGI'],
                "fluorescence_intensities" => $fluroscenceNewArray,
                "color_from" => $data['colorFrom'],
                "color_to" => $data['colorTo'],
                "clarity_from" => $data['clarityFrom'],
                "clarity_to" => $data['clarityTo'],
                "size_from" => $data['caratFrom'],
                "size_to" => $data['caratTo'],
                "cut_from" => $gradeFrom,
                "cut_to" => $gradeTo,
                "symmetry_from" => $symmetryFrom,
                "symmetry_to" => $symmetryTo,
                "polish_from" => $polishFrom,
                "polish_to" => $polishTo,
                "price_from" => "1",
                "price_to" => "999999",
                "page_number" => $pageNumber,
                "sort_direction" => "ASC",
                "sort_by" => "PRICE",
                'search_type' => 'White',
                'page_size' => $data['PageSize'],
            );

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://technet.rapaport.com/HTTP/JSON/RetailFeed/GetDiamonds.aspx',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($dataNew),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: Application/x-www-form-urlencoded',
                    'Authorization: Basic Y2RmMXh4c2U5eW5uczg1bHdreGw3aGV2aXE4dmxvOnpvRGk1UU5X',
                    'Cookie: ASP.NET_SessionId=y3dkpr4cgnpf3mvs2w314du4'
                ),
            ));

            $response = curl_exec($curl);
            $response = json_decode($response);


            if (isset($response->response->header) && !empty($response->response->body->diamonds)) {
                $response = $response->response->body->diamonds;
            } else {
                $response = '';
            }
            return $response;
        }
    }


    if (!function_exists("getInstagramDataDetails")) {
        function getInstagramDataDetails()
        {
            $getInstaData = InstagramData::limit(15)->where('media_type', '!=', 'VIDEO')->get();
            return $getInstaData;
        }
    }

    if (!function_exists("getDekoPayFormulaURL")) {
        function getDekoPayFormulaURL()
        {
            $dekoEnabled = true;
            $client = new DekoPayApiClient('', '', env('DEKOPAY_API_KEY'));
            $pay_url =  env('DEKOPAY_MODE');

            if ($dekoEnabled) {
                $url = $pay_url == 'live' ? 'https://secure.dekopay.com/js_api/FinanceDetails.js.php?api_key=' . env('DEKOPAY_API_KEY')  : 'https://test.dekopay.com/js_api/FinanceDetails.js.php?api_key=' . env('DEKOPAY_API_KEY');
            }

            return $url;
        }
    }

    if (!function_exists("getVATPriceFunction")) {
        function getVATPriceFunction($getTotal)
        {
            $getTotal = floatval(preg_replace('/[^\d.]/', '', $getTotal));
            return number_format($getTotal - ($getTotal / 1.2), 2);
        }
    }
    if (!function_exists("prefunc")) {
        function prefunc($getData)
        {
            echo "<pre>";
            print_r($getData);
            die;
        }
    }

    if (!function_exists("getPromotionalPOPup")) {
        function getPromotionalPOPup()
        {
            return Popups::where('status', 1)->first();
        }
    }

    // if (!function_exists("final_image_upload_single_function")) {
    //     function final_image_upload_single_function($imageUrl,$modelName,$modelId,$height=null,$width=null)
    //     {
    //         $modelId = base64_encode($modelId);
    //         if (!file_exists(storage_path('app/public/' . $modelName.'/'.$modelId.'/thumb'))) {
    //             mkdir(storage_path('app/public/' . $modelName.'/'.$modelId.'/thumb'), 777, true);
    //         }

    //         $imageName = $imageUrl->getClientOriginalName();
    //         $fileName =  rand().$imageName;
    //         $fileNameThumb =  'thumbnail_'. rand() . '- '.$height.'x'.$width.''. $imageName;

    //         Image::make($imageUrl)->save(storage_path('app/public/' . $modelName.'/'.$modelId.'/'.$fileName));
    //         Image::make($imageUrl)->resize($height,$width)->save(storage_path('app/public/' . $modelName.'/'.$modelId.'/'.'thumb'.'/'.$fileNameThumb));

    //         $data['f2']['R'] = $modelName.'/'.$modelId.'/'.$fileName;
    //         $data['f2']['T'] = $modelName.'/'.$modelId.'/'.'thumb'.'/'.$fileNameThumb;

    //         return $data;
    //     }
    // }

    if (!function_exists("final_image_upload_single_function")) {
        function final_image_upload_single_function($imageUrl, $modelName, $modelId, $height = null, $width = null)
        {
            $imagePath = 'app/public/' . $modelName . '/';
            $modelId = base64_encode($modelId);
            if (!file_exists(storage_path($imagePath))) {
                mkdir(storage_path($imagePath), 777, true);
            }

            $imageName = $imageUrl->getClientOriginalName();
            $fileName =  rand() . slugify($imageName);
            $fileNameThumb =  'thumbnail_' . rand() . '- ' . $height . 'x' . $width . '' . $imageName;

            Image::make($imageUrl)->save(storage_path($imagePath . $fileName));
            Image::make($imageUrl)->resize($height, $width)->save(storage_path($imagePath . $fileNameThumb));

            $data['f2']['R'] = $modelName . '/' . $fileName;
            $data['f2']['T'] = $modelName . '/' . $fileNameThumb;

            return $data;
        }
    }

    // if (!function_exists("final_image_upload_array_function")) {
    //     function final_image_upload_array_function($imageUrlArray,$modelName,$modelId,$height=null,$width=null)
    //     {
    //         $modelId = base64_encode($modelId);
    //         if (!file_exists(storage_path('app/public/' . $modelName.'/'.$modelId.'/thumb'))) {
    //             mkdir(storage_path('app/public/' . $modelName.'/'.$modelId.'/thumb'), 777, true);
    //         }

    //         if(is_array($imageUrlArray)){
    //             $data= [];
    //             foreach($imageUrlArray as $key => $file) {
    //                 $imageName = $file->getClientOriginalName();
    //                 $fileName =  rand().$imageName;
    //                 $fileNameThumb =  'thumbnail_'. rand() . '- '.$height.'x'.$width.''. $imageName;

    //                 Image::make($file)->save(storage_path('app/public/' . $modelName.'/'.$modelId.'/'.$fileName));
    //                 Image::make($file)->resize($height,$width)->save(storage_path('app/public/' . $modelName.'/'.$modelId.'/'.'thumb'.'/'.$fileNameThumb));

    //                 $data[$key]['R'] = $modelName.'/'.$modelId.'/'.$fileName;
    //                 $data[$key]['T'] = $modelName.'/'.$modelId.'/'.'thumb'.'/'.$fileNameThumb;
    //             }
    //         }
    //         return $data;
    //     }
    // }

    if (!function_exists("final_image_upload_array_function")) {

        function final_image_upload_array_function($imageUrlArray, $modelName, $modelId, $height = null, $width = null)
        {
            $modulePath = 'app/public/' . $modelName . '/';
            $modelId = base64_encode($modelId);
            $video_extensions = ['mp4'];
            $file_extensions = [];
            if (!file_exists(storage_path($modulePath))) {
                mkdir(storage_path($modulePath), 777, true);
            }
            if (is_array($imageUrlArray)) {
                $data = [];
                foreach ($imageUrlArray as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $file_extensions[] = $extension;
                    $imageName = $file->getClientOriginalName();
                    $fileName =  rand() . slugify($imageName);
                    $fileNameThumb =  'thumbnail_' . rand() . '- ' . $height . 'x' . $width . '' . $imageName;



                    if (in_array($extension, $video_extensions)) {

                        $fileName = product_video_upload($file, $modelName);
                        $data[$key]['R'] = $fileName;
                        $data[$key]['T'] = '';
                        // Storage::disk('public')->put($modulePath. $fileName . '.'.$extension, $file);
                        // $data[$key]['R'] = $modelName .'/'. $fileName . '.'.$extension;
                        // $data[$key]['T'] = '';
                        // Image::save(storage_path($modulePath . $fileName));
                        // $file->store($modulePath .$fileName.'.'.$extension );
                        // Image::make($file)->resize($height,$width)->save(storage_path( $modulePath .$fileNameThumb));
                    } else {
                        Image::make($file)->save(storage_path($modulePath . $fileName));
                        Image::make($file)->resize($height, $width)->save(storage_path($modulePath . $fileNameThumb));
                        $data[$key]['R'] = $modelName . '/' . $fileName;
                        $data[$key]['T'] = $modelName . '/' . $fileNameThumb;
                    }
                }
            }
            // print_r($file_extensions);die;
            return $data;
        }
    }


    function generateSlug($title = "", $table = "", $keyName = "slug", $number = 0)
    {
        $slug = slugify($title);
        $slug = $number ? $slug . '-' . $number : $slug;
        $isSlugExists = $table::where($keyName, $slug)->first();
        if (!empty($isSlugExists)) {
            $number = $number + 1;
            return generateSlug($title, $table, $keyName, $number);
        } else {
            return $slug;
        }
    }


    function generateSlugProductPurpose($title = "", $table = "", $keyName = "slug", $skip_id = "", $number = 0)
    {
        $slug = slugify($title);
        $slug = $number ? $slug . '-' . $number : $slug;

        $queryToCheck = $table::where($keyName, $slug);
        if (!empty($skip_id)) {
            $queryToCheck = $queryToCheck->where('id', '!=', $skip_id);
        }
        $isSlugExists = $queryToCheck->first();

        if (!empty($isSlugExists)) {
            $number = $number + 1;
            return generateSlugProductPurpose($title, $table, $keyName, $skip_id, $number);
        } else {
            return $slug;
        }
    }


    function slugify($text, string $divider = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }


    function prd($data = '')
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }



    function getMasterById($id = '')
    {
        return  Masters::where('id', $id)->first()->toArray();
    }

    function getMasterValuesByType($type = '')
    {
        $data =  Masters::where('type', $type)->pluck('value');
        if ($data->count()) {
            return $data->toArray();
        } else {
            return [];
        }
    }


    function getFilter($table, $query, $filter = [])
    {
        if (count($filter)) {
            foreach ($filter as $key => $value) {
                if (Schema::hasColumn(app($table)->getTable(), $key)) {
                    $query = $query->where($key, 'like', '%' . $filter[$key] . '%');
                }
            }
        }
        return $query;
    }


    function unique_code($limit = 30)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    function in_array_multi($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }


    function getThumbnailGif($productId = "")
    {
        $image = ProductThumbVideos::where([
            'status' => 1,
            'type' => 'thumbnail_rotation_image',
            'product_id' => $productId
        ])->first();

        if (!empty($image)) {
            return $image;
        } else {
            return null;
        }
    }


    function getProductVariationImage($productId = "", $request = [])
    {

        $getProductVariationId = ProductVariations::where('product_id', $productId)->pluck('id');
        if (!empty($getProductVariationId) && $getProductVariationId->count()) {
            $getProductVariationId = $getProductVariationId->toArray();

            // Statement 2
            // $getVariDetails = ProductVariationDetails::groupBy('value')
            //                     ->whereIn('variation_id', $getProductVariationId)
            //                     ->whereIn('value', $request['variations'])
            //                     ->get();
            // if(!empty($getVariDetails) && $getVariDetails->count()){
            //     $getVariDetails = $getVariDetails->toArray();
            // }
            // // endof statement 2

            $variationDetails = [];
            $attributeCount = count($request->variations);
            foreach ($getProductVariationId as $key1 => $productVariationId) {
                $variationDetails = array();
                foreach ($request->variations as $key2 => $variations) {
                    $getVariDetails =   ProductVariationDetails::where('variation_id', $productVariationId)
                        ->where('value', $variations)
                        ->get()
                        ->toArray();

                    if (!empty($getVariDetails))
                        $variationDetails[] = $getVariDetails;
                }
                if ($attributeCount == count($variationDetails)) {
                    break;
                }
            }


            $getSelectedVariationVideoImages = ProductVariations::where('id', $variationDetails[0][0]['variation_id'])
                ->select(DB::raw('(regular_price) as regular_price_without_vat'), DB::raw('(sale_price) as sale_price_without_vat'), 'vari_image', 'multi_vari_img', 'multi_vari_video', 'vari_video', 'regular_price', 'sale_price')
                ->first();

            return $getSelectedVariationVideoImages->toArray();
        } else {
            return null;
        }
    }

    function getCategoriesTree($exsitingCategories = [], $parentId = 0)
    {


        //return Category::with(['childCategories'])->get()->toArray();

        // if(!count($exsitingCategories)){
        //     $parent_categories = Category::where('parent_id',0)->where(['status'=>1])->get();
        //     if($parent_categories->count()){

        //         /** Check if child category exists */
        //         $isChildExists = false;
        //         foreach ($parent_categories as $key => $value) {
        //             $childCount = Category::where('parent_id',$value->id)->where(['status'=>1])->count();
        //             if($childCount){
        //                 $isChildExists = true;
        //                 break;
        //             }
        //         }
        //         if($isChildExists){
        //             return getCategoriesTree($parent_categories->toArray());
        //         }else{
        //             return $parent_categories->toArray();
        //         }
        //     }
        // }else{


        //     foreach ($exsitingCategories as $key => $value) {
        //         # code...
        //     }


        // }

        // $parent_categories = Category::where('parent_id',$parentId)->where(['status'=>1])->get();
        // foreach ($parent_categories as $key => $value) {
        //     $childExist = Category::where('parent_id',$value->id)->where(['status'=>1])->count();
        //     if($childExist){
        //         $parent_categories->child = Category::where('parent_id',$value->id)->where(['status'=>1])->get();
        //     }
        // }
    }


    function upload_file($file, $path = "")
    {

        try {
            $originalName = $file->getClientOriginalName();
            $size = $file->getSize();
            $extension = $file->getClientOriginalExtension();
            $mimeType = $file->getMimeType();

            $fileName = time() . uniqid() . '_' . $originalName;

            $destinationPath = 'uploads/' . $path . '/';
            $toReturn = $file->move($destinationPath, $fileName);
            return [
                'name' => $path . '/' . $fileName,
                'size' => $size,
                'extension' => $extension,
                'mimeType' => $mimeType,
                'original_name' => $originalName,
            ];
        } catch (\Throwable $th) {
            return null;
        }
    }

    function show_dots($in, $length = 30)
    {
        return strlen($in) > $length ? substr($in, 0, $length) . "..." : $in;
    }

    /**
     * details about currency
     */
    function currency($query = [])
    {
        return [
            'symbol' => '£'
        ];
    } // endof currency

    /** format of price how it shows */
    function formatPrice($amount = '')
    {
        $currency = currency();

        $symbol = "£";
        if (!empty($currency['symbol'])) {
            $symbol = $currency['symbol'];
        }

        return $currency['symbol'] . " " . number_format($amount, 2);
    } // endof formatPrice

    /**
     * Function is use to return number of items that will need to show on products list page
     */
    function defaultProductPagination()
    {
        return 20;
    } // endof defaultProductPagination

    /**
     * getPercentage
     * function is use to get amount after percentage
     */
    function getPercentage($total, $percentage = 0, $decimal = 0)
    {
        $percentageAmount = ($percentage / 100) * $total;
        return  round($total - $percentageAmount, $decimal);
    } // endof getPercentage

    /**
     * getPercentageValue
     * function is use to get amount after percentage
     */
    function getPercentageValue($total, $percentage = 0, $decimal = 0)
    {
        $percentageAmount = ($percentage / 100) * $total;
        return  round($percentageAmount);
    } // endof getPercentageValue


    function duplicateProductRemoveIds()
    {
        $productIdsToRemoveImages = Masters::where(['is_deleted' => 0, 'is_active' => 1, 'type' => 'product_duplicate_image_remove'])->pluck('value');
        if (!empty($productIdsToRemoveImages) && $productIdsToRemoveImages->count()) {
            return $productIdsToRemoveImages->toArray();
        } else {
            return [];
        }
    }


    function show_percentage($amount = 0, $pricing_data = [], $type = "show")
    {

        if (empty($pricing_data)) {
            return $amount;
        }
        $percentageValue = getPercentageValue($amount, $pricing_data->percentage);
        switch ($type) {
            case 'show': {
                    $toReturn = $amount;
                    if (!empty($pricing_data)) {
                        if ($pricing_data->type == 'increase') {
                            $toReturn .= " + $percentageValue ($pricing_data->percentage%)";
                        } else {
                            $toReturn .= " - $percentageValue ($pricing_data->percentage%)";
                        }
                    }
                    return $toReturn;
                    break;
                }
            case 'action': {
                    if ($pricing_data->type == 'increase') {
                        return $amount + $percentageValue;
                    } else {
                        return $amount - $percentageValue;
                    }
                    break;
                }

            default: {
                    return 'N/A';
                    break;
                }
        }
    }

    /**
     * check extension of file type
     */
    function extensionChecker($extension = 'jpeg')
    {

        $validImageExtensions = ['jpeg', 'jpg', 'JPEG', 'JPG', 'png', 'PNG', 'webp', 'WEBP', 'gif', 'GIF'];
        $validVideoExtensions = ['mp4', 'MP4'];
        $validAudioExtensions = ['mp3', 'MP3'];

        if (in_array($extension, $validImageExtensions)) {
            return 'image';
        } else if (in_array($extension, $validVideoExtensions)) {
            return 'video';
        } else if (in_array($extension, $validAudioExtensions)) {
            return 'audio';
        } else {
            return null;
        }
    } //endof extensionChecker

    /**
     * convert bytes to human readable file size
     */
    function humanFileSize($bytes, $dec = 2)
    {
        $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    } //endof humanFileSize

    /**
     *
     */
    function show_image($file_url = "")
    {

        if (file_exists(public_path('/uploads/')  . $file_url)) {
            return true;
        } else {
            return false;
        }
    } // endof file_get_url


    function pageRedirects($path = "")
    {
        $path = $path[0] == '/' ? $path : '/' . $path;
        $path = urlencode($path);

        $dataToRedirect = UrlRedirects::where(['old_url' => $path, 'is_deleted' => 0])->first();
        if (!empty($dataToRedirect) && !empty($dataToRedirect->new_url)) {
            return urldecode($dataToRedirect->new_url);
        }
        return null;
    }


    function isValidJson($string = "")
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }


    // function getProductListing($queryString = null, $requestData = [])
    // {
    //     /** generate custom query for categories */
    //     $category_custom_query = "";
    //     $is404 = false;
    //     $categoryData = null;
    //     $getAjaxResponses = true;
    //     $page = 30;

    //     if (isset($requestData['category']) && count($requestData['category']) == 1 && in_array('diamonds-rings', $requestData['category'])) {
    //         $requestData['category'] = [
    //             'engagement-rings',
    //             'eternity-rings',
    //             'wedding-rings'
    //         ];
    //     }

    //     if (isset($requestData['category']) && !empty($requestData['category'])) {
    //         foreach ($requestData['category'] as $queryString_key => $queryString_value_new) {
    //             $slugCategory = Category::where('slug', $queryString_value_new)->first();
    //             if (!empty($slugCategory)) {
    //                 if (!$queryString_key) {
    //                     $category_custom_query .= '( ';
    //                 }
    //                 // $category_custom_query .= '( ';
    //                 $category_custom_query .= " find_in_set('" . $slugCategory->id . "',categories) ";
    //                 if ($queryString_key + 1 != count($requestData['category'])) {
    //                     $category_custom_query .= " OR ";
    //                 } else {
    //                     $category_custom_query .= ' ) ';
    //                 }
    //             }
    //         }
    //         $getAjaxResponses = false;
    //         $page = '';
    //     } elseif (!empty($queryString)) {
    //         $conditions = 'AND';
    //         if (isset($queryString[1]) && !empty($queryString[1])) {
    //             if (isset($queryString[2]) && $queryString[1] == 'womens') {
    //                 $queryString[2] = $queryString[2] . '-' . $queryString[1];
    //                 $queryString = Category::whereIn('slug', $queryString)->orderBy('id', 'asc')->pluck('slug')->toArray();

    //                 if (isset($queryString) && count($queryString) != 3) {
    //                     $is404 = true;
    //                 }
    //                 $conditions = 'AND';
    //             } else {

    //                 $getQueryStringCount = count($queryString);
    //                 $queryString = Category::whereIn('slug', $queryString)->orderBy('id', 'asc')->pluck('slug')->toArray();

    //                 $conditions = 'AND';
    //                 if ($getQueryStringCount != count($queryString)) {
    //                     $is404 = true;
    //                 }
    //             }
    //         }

    //         if (isset($queryString[0]) && $queryString[0] == 'diamond-engagement-rings') {
    //             $queryString = [
    //                 'diamond-engagement-rings',
    //                 'engagement-rings',
    //             ];
    //             $conditions = 'OR';
    //         }
    //         if (isset($queryString[0]) && $queryString[0] == 'diamonds-rings') {
    //             $queryString = [
    //                 'engagement-rings',
    //                 'eternity-rings',
    //                 'wedding-rings',
    //                 'diamonds-rings'
    //             ];
    //             $conditions = 'OR';
    //         }

    //         foreach ($queryString as $queryString_key => $queryString_value) {
    //             $slugCategory = Category::where('slug', $queryString_value)->first();

    //             if (!empty($slugCategory)) {
    //                 if (!$queryString_key) {
    //                     $category_custom_query .= '( ';
    //                 }
    //                 $category_custom_query .= " find_in_set('" . $slugCategory->id . "',categories) ";
    //                 if ($queryString_key + 1 != count($queryString)) {
    //                     $category_custom_query .= " $conditions ";
    //                 } else {
    //                     $category_custom_query .= ' ) ';
    //                 }
    //             } else {
    //                 $is404 = true;
    //             }
    //             if (current($queryString) == $queryString_value) {
    //                 $categoryData = $slugCategory;
    //             } elseif (last($queryString) == $queryString_value) {
    //                 $categoryData = $slugCategory;
    //             }
    //         }

    //         $shapeArrayData = [
    //             'cushion',
    //             'emerald',
    //             'heart',
    //             'marquise',
    //             'oval',
    //             'pear',
    //             'princess',
    //             'round'
    //         ];
    //         if (isset($queryString[1]) && in_array($queryString[1], $shapeArrayData)) {
    //             $slugCategory = Category::where('slug', 'like', '%' . $queryString[1] . '%')->get();
    //             foreach ($slugCategory as $keyItems => $cateValue) {
    //                 $category_custom_query .= ' OR ' . 'find_in_set(' . $cateValue->id . ',categories)';
    //             }
    //         }
    //     } else {
    //         $category_custom_query = "(find_in_set('8',categories)) OR (find_in_set('45',categories)) OR (find_in_set('47',categories))";
    //     }

    //     if (isset($requestData['style-categories']) && !empty($requestData['style-categories'])) {
    //         foreach ($requestData['style-categories'] as $queryString_key => $queryString_value_new) {
    //             $slugCategory = Category::where('slug', $queryString_value_new)->first();
    //             if (!empty($slugCategory)) {
    //                 if (!$queryString_key) {
    //                     $category_custom_query .= 'AND ( ';
    //                 }
    //                 // $category_custom_query .= '( ';
    //                 $category_custom_query .= " find_in_set('" . $slugCategory->id . "',categories) ";
    //                 if ($queryString_key + 1 != count($requestData['style-categories'])) {
    //                     $category_custom_query .= "  ";
    //                 } else {
    //                     $category_custom_query .= ' ) ';
    //                 }
    //             }
    //         }
    //     }

    //     if (isset($requestData['ring-categories']) && !empty($requestData['ring-categories'])) {

    //         foreach ($requestData['ring-categories'] as $queryString_key => $queryString_value_new) {

    //             if ($requestData['style-categories'][0] == 'womens') {
    //                 $queryString_value_new = $queryString_value_new . '-' . $requestData['style-categories'][0];
    //             }
    //             $slugCategory = Category::where('slug', $queryString_value_new)->first();
    //             if (!empty($slugCategory)) {
    //                 if (!$queryString_key) {
    //                     $category_custom_query .= 'AND ( ';
    //                 }
    //                 // $category_custom_query .= '( ';
    //                 $category_custom_query .= " find_in_set('" . $slugCategory->id . "',categories) ";
    //                 if ($queryString_key + 1 != count($requestData['ring-categories'])) {
    //                     $category_custom_query .= "  ";
    //                 } else {
    //                     $category_custom_query .= ' ) ';
    //                 }
    //             }
    //         }
    //     }
    //     if (isset($requestData['jewellery-categories']) && !empty($requestData['jewellery-categories'])) {
    //         foreach ($requestData['jewellery-categories'] as $queryString_key => $queryString_value_new) {
    //             $slugCategory = Category::where('slug', $queryString_value_new)->first();
    //             if (!empty($slugCategory)) {
    //                 if (!$queryString_key) {
    //                     $category_custom_query .= 'AND ( ';
    //                 }
    //                 // $category_custom_query .= '( ';
    //                 $category_custom_query .= " find_in_set('" . $slugCategory->id . "',categories) ";
    //                 if ($queryString_key + 1 != count($requestData['jewellery-categories'])) {
    //                     $category_custom_query .= "  ";
    //                 } else {
    //                     $category_custom_query .= ' ) ';
    //                 }
    //             }
    //         }
    //     }

    //     if ($is404) {
    //         return [
    //             'status' => 404,
    //             'page_status' => 1,
    //             'redirect_url' => '/'
    //         ];
    //     }
    //     if (empty($category_custom_query)) {
    //         return [
    //             'status' => 404,
    //             'page_status' => 1,
    //             'redirect_url' => '/'
    //         ];
    //     }

    //     $pageNo = !empty($requestData['page']) ? $requestData['page'] : 1;

    //     if (isset($requestData['per_page_product']) && !empty($requestData['per_page_product'])) {
    //         $page = $requestData['per_page_product'];
    //     }
    //     $query = Products::with('getProductVariation:id,product_id,mined_diamond_rrp,mined_diamond,lab_grown_rrp,lab_grown')->with('getProductImages')->select('id', 'title', 'slug', 'categories')->where('status', 1)->whereRaw(DB::raw($category_custom_query));

    //     /** Search filter */
    //     if (!empty($requestData['keyword'])) {
    //         $keyword = $requestData['keyword'];
    //         $query = $query->where('title', 'LIKE', "%$keyword%");
    //     }

    //     if (!empty($requestData['metal_type']) && $requestData['metal_type'] != 'undefined') {
    //         $metal_type = $requestData['metal_type'];

    //         $query->whereHas('getProductVariation.variDetails', function ($query) use ($metal_type) {
    //             $query->whereIn('value', $metal_type);
    //         });
    //     }

    //     if (!empty($requestData['price-min']) && !empty($requestData['price-max'])) {
    //         $query->whereHas('getProductVariation', function ($query) use ($requestData) {
    //             $query->whereBetween('regular_price', array($requestData['price-min'][0], $requestData['price-max'][0]));
    //         });
    //     }

    //     /** Search filter */
    //     if (!empty($requestData['filter-by-shape'])) {
    //         $shape = $requestData['filter-by-shape'];
    //         $query = $query->whereIn('diamond_shape', $shape);
    //     }

    //     if (isset($requestData['sorting']) && ($requestData['sorting'] == "asc" || $requestData['sorting'] == "desc")) {
    //         $sort = $requestData['sorting'];
    //         $query = $query->orderBy('title', $sort);
    //     } else {
    //         $query = $query->orderBy('title', 'asc');
    //     }

    //     $dynamicPath = request()->query('path');
    //     $getProductListFinal = $query->paginate($page, ['*'], 'page', $pageNo)->withPath($dynamicPath);
    //     $getActualProductArray = $getProductListFinal->toArray();
    //     $productSingleArray = [];
    //     $getMinedLabStatus = '';
    //     foreach ($getActualProductArray['data'] as $keyi => $product) {
    //         $productSingleArray[$keyi]['id'] =  $product['id'];
    //         $productSingleArray[$keyi]['title'] =  $product['title'];
    //         $productSingleArray[$keyi]['slug'] =  $product['slug'];
    //         $productSingleArray[$keyi]['categories'] =  $product['categories'];
    //         $productSingleArray[$keyi]['parent_cat'] =  $product['product_parent_category'];
    //         $productSingleArray[$keyi]['getProductImages'] =  $product['get_product_images'];

    //         usort($product['get_product_variation'], function ($a, $b) {
    //             return $a['lab_grown_rrp'] <=> $b['lab_grown_rrp'];
    //         });

    //         $filtered = array_filter($product['get_product_variation'], function ($item)  use ($product) {
    //             foreach ($item['get_vari_details_id'] as $detail) {
    //                 if ($detail['value'] === '9ct White Gold' || in_array(54, explode(',', $product['categories']))) {
    //                     return true;
    //                 }
    //             }
    //             return false;
    //         });
    //         $record = array_shift($filtered); // Get the first matching record
    //         $getCategoryArray = explode(',', $product['categories']);
    //         if (in_array(50, $getCategoryArray) || in_array(53, $getCategoryArray) || in_array(54, $getCategoryArray)) {
    //             $getMinedLabStatus = 'mined_diamond'; // Can be 'mined_diamond' or 'lab_grown'
    //         } else {
    //             $getMinedLabStatus = 'lab_grown'; // Can be 'mined_diamond' or 'lab_grown'
    //         }
    //         // Sorting logic
    //         $productSingleArray[$keyi]['diamond_type'] =  $getMinedLabStatus;
    //         $productSingleArray[$keyi]['get_product_variation'] =  $record;
    //     }

    //     // Convert the array to a Laravel Collection
    //     $collection = collect($productSingleArray);

    //     $modifiedCollection = $collection->map(function ($item) {
    //         $explodeCategory = explode(',', $item['categories']);
    //         if (in_array('8', $explodeCategory) && !in_array('18', $explodeCategory)) {
    //             return [
    //                 'id' => $item['id'],
    //                 'title' => $item['title'],
    //                 'slug' => $item['slug'],
    //                 'categories' => $item['categories'],
    //                 'parent_cat' => $item['parent_cat'],
    //                 'getProductImages' => [
    //                     'id' => $item['getProductImages']['id'],
    //                     'product_id' => $item['getProductImages']['product_id'],
    //                     'image_url' => $item['getProductImages']['image_url'],
    //                     'is_featured' => $item['getProductImages']['is_featured'],
    //                     'status' => $item['getProductImages']['status'],
    //                     'created_at' => $item['getProductImages']['created_at'],
    //                     'updated_at' => $item['getProductImages']['updated_at'],
    //                 ],
    //                 'mined_diamond_rrp' => $item['get_product_variation']['mined_diamond_rrp'],
    //                 'mined_diamond' => $item['get_product_variation']['mined_diamond'],
    //                 'lab_grown_rrp' => $item['get_product_variation']['lab_grown_rrp'] + getLabPriceDefaultVariations(),
    //                 'lab_grown' => $item['get_product_variation']['lab_grown'] + getLabPriceDefaultVariations(),
    //                 'discounted_lab_grown' => getFlatDiscountRanges(array('shop_price' => $item['get_product_variation']['lab_grown'] + getLabPriceDefaultVariations()), $item['categories'], 'lab_grown')['discounted_price'],
    //             ];
    //         } else {
    //             return [
    //                 'id' => $item['id'],
    //                 'title' => $item['title'],
    //                 'slug' => $item['slug'],
    //                 'categories' => $item['categories'],
    //                 'parent_cat' => $item['parent_cat'],
    //                 'getProductImages' => [
    //                     'id' => $item['getProductImages']['id'],
    //                     'product_id' => $item['getProductImages']['product_id'],
    //                     'image_url' => $item['getProductImages']['image_url'],
    //                     'is_featured' => $item['getProductImages']['is_featured'],
    //                     'status' => $item['getProductImages']['status'],
    //                     'created_at' => $item['getProductImages']['created_at'],
    //                     'updated_at' => $item['getProductImages']['updated_at'],
    //                 ],
    //                 'mined_diamond_rrp' => $item['get_product_variation']['mined_diamond_rrp'],
    //                 'mined_diamond' => $item['get_product_variation']['mined_diamond'],
    //                 'lab_grown_rrp' => $item['get_product_variation']['lab_grown_rrp'],
    //                 'lab_grown' => $item['get_product_variation']['lab_grown'],
    //                 'discounted_lab_grown' => getFlatDiscountRanges(array('shop_price' => $item['get_product_variation']['lab_grown']), $item['categories'], 'lab_grown')['discounted_price'],
    //             ];
    //         }
    //     });
    //     // Function to apply sorting based on category and order
    //     function sortProducts($collection, $order = 'asc')
    //     {
    //         return $collection->sort(function ($a, $b) use ($order) {
    //             // Check if categories contain '54'
    //             $categoriesA = explode(',', $a['categories']);
    //             $categoriesB = explode(',', $b['categories']);

    //             $sortFieldA = (in_array(54, $categoriesA) || in_array(53, $categoriesA) || in_array(50, $categoriesA)) ? $a['mined_diamond'] : $a['lab_grown'];
    //             $sortFieldB = (in_array(54, $categoriesB) || in_array(53, $categoriesB) || in_array(50, $categoriesB)) ? $b['mined_diamond'] : $b['lab_grown'];

    //             // Sorting logic: Ascending or Descending
    //             if ($order === 'asc') {
    //                 return $sortFieldA <=> $sortFieldB;
    //             } else {
    //                 return $sortFieldB <=> $sortFieldA;
    //             }
    //         })->values(); // Reindex the collection after sorting
    //     }

    //     if (isset($requestData['sorting']) && $requestData['sorting'] == 'price-min') {
    //         $sortedCollection = sortProducts($modifiedCollection, 'asc'); // Ascending
    //     } elseif (isset($requestData['sorting']) && $requestData['sorting'] == 'price-max') {
    //         $sortedCollection = sortProducts($modifiedCollection, 'desc'); // Descending
    //     } else {
    //         $sortedCollection = $modifiedCollection;
    //     }
    //     // Usage: Pass the collection and specify 'asc' or 'desc' for sorting
    //     $sortedArray = $sortedCollection->map(function ($item) {
    //         return (object) $item;
    //     });

    //     if ($getProductListFinal->currentPage() > $getProductListFinal->lastPage()) {
    //         return [
    //             'status' => 404,
    //             'page_status' => 1,
    //             'redirect_url' => $getProductListFinal->path()
    //         ];
    //     }

    //     $productItems = "";
    //     if ($getProductListFinal->count()) {
    //         $productItems = $getAjaxResponses ? null : view('front.ajax.productlistajax', compact('getProductListFinal', 'getAjaxResponses', 'sortedArray'))->render();
    //     } else {
    //         return [
    //             'status' => 404,
    //             'page_status' => 1,
    //             'redirect_url' => $getProductListFinal->path()
    //         ];
    //     }
    //     $isNextPage = $getProductListFinal->hasMorePages();
    //     $nextPage = $getProductListFinal->currentPage() + 1;

    //     return [
    //         'status' => 200,
    //         'productItems' => $productItems,
    //         'getProductListFinal' => $getProductListFinal,
    //         'sortedArray' => $sortedArray,
    //         'isNextPage' => $isNextPage,
    //         'nextPage' => $nextPage,
    //         'product_count' => $getProductListFinal->count(),
    //         'previous_url' => $getProductListFinal->previousPageUrl(),
    //         'next_url' => $getProductListFinal->nextPageUrl(),
    //         'categoryData' => $categoryData,
    //         'totalProductCount' => $getProductListFinal->total(),
    //     ];
    // }
    /*
    * ChatGPT enhance optimization
    */
    function getProductListing($queryString = null, $requestData = [])
    {
        $is404 = false;
        $categoryData = null;
        $getAjaxResponses = true;
        $page = 30;
        $category_custom_query = "";

        /** Helper: build category condition */
        $buildCategoryQuery = function ($categories, $operator = "OR") {
            $queryParts = [];
            foreach ($categories as $slug) {
                $category = Category::where('slug', $slug)->first();
                if ($category) {
                    $queryParts[] = "FIND_IN_SET('{$category->id}', categories)";
                }
            }
            return $queryParts ? "( " . implode(" {$operator} ", $queryParts) . " )" : "";
        };

        /** Diamonds rings special case */
        if (isset($requestData['category']) && count($requestData['category']) == 1 && in_array('diamonds-rings', $requestData['category'])) {
            $requestData['category'] = ['engagement-rings', 'eternity-rings', 'wedding-rings'];
        }

        /** Category filter */
        if (!empty($requestData['category'])) {
            $category_custom_query = $buildCategoryQuery($requestData['category'], "OR");
            $getAjaxResponses = false;
            $page = '';
        } elseif (!empty($queryString)) {
            $conditions = "AND";

            if (isset($queryString[1])) {
                if (isset($queryString[2]) && $queryString[1] == 'womens') {
                    $queryString[2] = $queryString[2] . '-womens';
                }
                $originalCount = count($queryString);
                $queryString = Category::whereIn('slug', $queryString)->orderBy('id')->pluck('slug')->toArray();
                if ($originalCount != count($queryString)) $is404 = true;
            }

            if (($queryString[0] ?? null) == 'diamond-engagement-rings') {
                $queryString = ['diamond-engagement-rings', 'engagement-rings'];
                $conditions = 'OR';
            }
            if (($queryString[0] ?? null) == 'diamonds-rings') {
                $queryString = ['engagement-rings', 'eternity-rings', 'wedding-rings', 'diamonds-rings'];
                $conditions = 'OR';
            }

            $category_custom_query = $buildCategoryQuery($queryString, $conditions);

            // Shape based categories
            $shapeArrayData = ['cushion', 'emerald', 'heart', 'marquise', 'oval', 'pear', 'princess', 'round'];
            if (isset($queryString[1]) && in_array($queryString[1], $shapeArrayData)) {
                $shapeCategories = Category::where('slug', 'like', '%' . $queryString[1] . '%')->pluck('id');
                foreach ($shapeCategories as $id) {
                    $category_custom_query .= " OR FIND_IN_SET($id, categories)";
                }
            }

            $categoryData = Category::where('slug', end($queryString))->first();
        } else {
            // Default categories
            $category_custom_query = "(FIND_IN_SET('8',categories)) OR (FIND_IN_SET('45',categories)) OR (FIND_IN_SET('47',categories))";
        }

        /** Additional category filters */
        foreach (['style-categories', 'ring-categories', 'jewellery-categories'] as $filterType) {
            if (!empty($requestData[$filterType])) {
                $extraQuery = $buildCategoryQuery($requestData[$filterType], "OR");
                if ($extraQuery) {
                    $category_custom_query .= " AND " . $extraQuery;
                }
            }
        }

        if ($is404 || empty($category_custom_query)) {
            return ['status' => 404, 'page_status' => 1, 'redirect_url' => '/'];
        }

        /** Pagination setup */
        $pageNo = $requestData['page'] ?? 1;
        if (!empty($requestData['per_page_product'])) {
            $page = $requestData['per_page_product'];
        }

        /** Base Query */
        $query = Products::with([
            'getProductVariation:id,product_id,mined_diamond_rrp,mined_diamond,lab_grown_rrp,lab_grown',
            'getProductImages'
        ])
            ->select('id', 'title', 'slug', 'categories')
            ->where('status', 1)
            ->whereRaw(DB::raw($category_custom_query));

        /** Keyword filter */
        if (!empty($requestData['keyword'])) {
            $query->where('title', 'LIKE', "%" . $requestData['keyword'] . "%");
        }

        /** Metal type filter */
        if (!empty($requestData['metal_type']) && $requestData['metal_type'] != 'undefined') {
            $query->whereHas('getProductVariation.variDetails', function ($q) use ($requestData) {
                $q->whereIn('value', $requestData['metal_type']);
            });
        }

        /** Price filter */
        if (!empty($requestData['price-min']) && !empty($requestData['price-max'])) {
            $query->whereHas('getProductVariation', function ($q) use ($requestData) {
                $q->whereBetween('regular_price', [$requestData['price-min'][0], $requestData['price-max'][0]]);
            });
        }

        /** Shape filter */
        if (!empty($requestData['filter-by-shape'])) {
            $query->whereIn('diamond_shape', $requestData['filter-by-shape']);
        }

        /** Sorting */
        if (isset($requestData['sorting']) && in_array($requestData['sorting'], ['asc', 'desc'])) {
            $query->orderBy('title', $requestData['sorting']);
        } else {
            $query->orderBy('title', 'asc');
        }

        /** Paginate */
        $dynamicPath = request()->query('path');
        $getProductListFinal = $query->paginate($page, ['*'], 'page', $pageNo)->withPath($dynamicPath);

        if ($getProductListFinal->currentPage() > $getProductListFinal->lastPage()) {
            return ['status' => 404, 'page_status' => 1, 'redirect_url' => $getProductListFinal->path()];
        }

        if (!$getProductListFinal->count()) {
            return ['status' => 404, 'page_status' => 1, 'redirect_url' => $getProductListFinal->path()];
        }

        /** Transform product data */
        $productSingleArray = [];
        foreach ($getProductListFinal as $key => $product) {
            $variations = collect($product->getProductVariation)->sortBy('lab_grown_rrp')->toArray();
            $record = reset($variations);

            $categories = explode(',', $product->categories);
            $diamondType = (array_intersect([50, 53, 54], $categories)) ? 'mined_diamond' : 'lab_grown';

            $productSingleArray[$key] = [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'categories' => $product->categories,
                'parent_cat' => $product->product_parent_category,
                'getProductImages' => $product->getProductImages,
                'diamond_type' => $diamondType,
                'get_product_variation' => $record,
            ];
        }

        /** Collection mapping */
        $modifiedCollection = collect($productSingleArray)->map(function ($item) {
            $explodeCategory = explode(',', $item['categories']);
            $variation = $item['get_product_variation'];
            $extraPrice = in_array('8', $explodeCategory) && !in_array('18', $explodeCategory) ? getLabPriceDefaultVariations() : 0;

            return [
                'id' => $item['id'],
                'title' => $item['title'],
                'slug' => $item['slug'],
                'categories' => $item['categories'],
                'parent_cat' => $item['parent_cat'],
                'getProductImages' => $item['getProductImages'],
                'mined_diamond_rrp' => $variation['mined_diamond_rrp'],
                'mined_diamond' => $variation['mined_diamond'],
                'lab_grown_rrp' => $variation['lab_grown_rrp'] + $extraPrice,
                'lab_grown' => $variation['lab_grown'] + $extraPrice,
                'discounted_lab_grown' => getFlatDiscountRanges(
                    ['shop_price' => $variation['lab_grown'] + $extraPrice],
                    $item['categories'],
                    'lab_grown'
                )['discounted_price'],
            ];
        });

        /** Price sorting */
        $sortProducts = function ($collection, $order = 'asc') {
            return $collection->sort(function ($a, $b) use ($order) {
                $catA = explode(',', $a['categories']);
                $catB = explode(',', $b['categories']);

                $fieldA = (array_intersect([50, 53, 54], $catA)) ? $a['mined_diamond'] : $a['lab_grown'];
                $fieldB = (array_intersect([50, 53, 54], $catB)) ? $b['mined_diamond'] : $b['lab_grown'];

                return $order === 'asc' ? $fieldA <=> $fieldB : $fieldB <=> $fieldA;
            })->values();
        };

        if (($requestData['sorting'] ?? null) == 'price-min') {
            $sortedCollection = $sortProducts($modifiedCollection, 'asc');
        } elseif (($requestData['sorting'] ?? null) == 'price-max') {
            $sortedCollection = $sortProducts($modifiedCollection, 'desc');
        } else {
            $sortedCollection = $modifiedCollection;
        }

        $sortedArray = $sortedCollection->map(fn($item) => (object) $item);

        $productItems = $getAjaxResponses ? null : view('front.ajax.productlistajax', compact('getProductListFinal', 'getAjaxResponses', 'sortedArray'))->render();

        return [
            'status' => 200,
            'productItems' => $productItems,
            'getProductListFinal' => $getProductListFinal,
            'sortedArray' => $sortedArray,
            'isNextPage' => $getProductListFinal->hasMorePages(),
            'nextPage' => $getProductListFinal->currentPage() + 1,
            'product_count' => $getProductListFinal->count(),
            'previous_url' => $getProductListFinal->previousPageUrl(),
            'next_url' => $getProductListFinal->nextPageUrl(),
            'categoryData' => $categoryData,
            'totalProductCount' => $getProductListFinal->total(),
        ];
    }
}


function getIpInfo($ip = NULL, $purpose = "location", $deep_detect = TRUE)
{
    $output = NULL;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }

    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );

    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            $output = array(
                "city"           => @$ipdat->geoplugin_city,
                "state"          => @$ipdat->geoplugin_regionName,
                "country"        => @$ipdat->geoplugin_countryName,
                "country_code"   => @$ipdat->geoplugin_countryCode,
                "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                "continent_code" => @$ipdat->geoplugin_continentCode,
                "ip" => $ip
            );
        }
    }
    return $output;
}

function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/OPR/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    } elseif (preg_match('/Edge/i', $u_agent)) {
        $bname = 'Edge';
        $ub = "Edge";
    } elseif (preg_match('/Trident/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function getLabDiamondPrices($requestData)
{
    if (isset($requestData['type']) && $requestData['type']) {
        $diamondCaratWeight = explode("-", trim($requestData['carat']));
        $diamondColour = $requestData['color'];
        $diamondClarity = $requestData['clarity'];
        $diamondCertificate = $requestData['certificate'];
        // $diamondShape = $requestData['diamondShape'];
        $diamondGrade = isset($requestData['grade']) ? $requestData['grade'] : '';
        $diamondType = $requestData['diamond_type'];

        if (isset($diamondType) && $diamondType == 'lab_grown') {
            return LabPricesList::whereBetween('carat', [$diamondCaratWeight[0], $diamondCaratWeight[1]])->where(['color' => $diamondColour, 'clarity' => $diamondClarity, 'is_active' => 1, 'is_deleted' => 0])->select('clarity', 'color', 'carat', 'price')->first();
        } else {
            return 0.00;
        }
    } else {
        return 0.00;
    }
}

function getVariationDiamondPrices($requestData)
{
    $caratFrom = '0.30';
    $caratTo = '0.39';
    if ($requestData['diamondCaratWeight'] != '') {
        $carat = explode('-', $requestData['diamondCaratWeight']);
        $caratFrom = $carat[0];
        $caratTo = $carat[1];
    }

    $colorFrom = $colorTo = 'D';
    $colour = array();
    if ($requestData['diamondColour'] != '') {
        $colour = explode(',', $requestData['diamondColour']);
        $colorFrom = $colorTo = $requestData['diamondColour'];
    }

    $clarityFrom = $clarityTo = 'SI2';
    $clarity = array();
    if ($requestData['diamondClarity'] != '') {
        $clarity = explode(',', $requestData['diamondClarity']);
        $clarityFrom = $clarityTo = $requestData['diamondClarity'];
    }

    $gradeFrom = $gradeTo = 'EX';
    $grade = array();
    if (isset($requestData['diamondGrade']) && $requestData['diamondGrade'] != '') {
        $grade = explode(',', $requestData['diamondGrade']);
        $gradeFrom = $gradeTo = $requestData['diamondGrade'];
    }

    $polishFrom = 'EX';
    $polishTo = 'GD';
    $polish = array();
    $symmetryFrom = 'EX';
    $symmetryTo = 'GD';
    $symmetry = array();
    $fluorescence = array();

    $certificate = array();
    if ($requestData['diamondCertificate'] != '') {
        $certificate = explode(',', $requestData['diamondCertificate']);
    }

    $data = array('shape' => $requestData['diamondShape'], 'colorFrom' => $colorFrom, 'colorTo' => $colorTo, 'colour' => $colour, 'clarityFrom' => $clarityFrom, 'clarityTo' => $clarityTo, 'clarity' => $clarity, 'caratFrom' => $caratFrom, 'caratTo' => $caratTo, 'gradeFrom' => $gradeFrom, 'gradeTo' => $gradeTo, 'grade' => $grade, 'polishFrom' => $polishFrom, 'polishTo' => $polishTo, 'polish' => $polish, 'symmetryFrom' => $symmetryFrom, 'symmetryTo' => $symmetryTo, 'symmetry' => $symmetry, 'fluorescence' => $fluorescence, 'certificate' => $certificate, 'num_of_row' => 2, 'PageSize' => 1);

    $hkData = getHKApiRecords($data);

    $diamondPrice = 0.00;
    if (isset($hkData) && !empty($hkData)) {
        $diamondPrice = $hkData[0]['Amount'];
    } else {
        $rapnetData = getRapnetApiRecordsDiamondSearch($data, 1);
        if (isset($rapnetData) && !empty($rapnetData)) {
            $diamondPrice = $rapnetData[0]->total_sales_price_in_currency;
        }
    }
    return [
        'price' => $diamondPrice,
    ];
}

// function getRagularFilterPrices($getRequestData, $diamondType, $slug)
// {

//     if (isset($diamondType) && !empty($diamondType)) {
//         // no action needed
//     } else {
//         $diamondType = 'mined_diamond';
//     }
//     $rrpPrice = $diamondType . '_rrp';
//     $getProductDetails = Products::where('slug', $slug)->first();

//     // $getVariationsArray = ProductVariations::where('product_id',$getProductDetails->id)->pluck('id')->toArray();
//     $getProductVariationId = ProductVariations::where('product_id', $getProductDetails->id)->pluck('id')->toArray();
//     if (!empty($getProductVariationId)) {
//         $attributeCount = count($getRequestData['variations']);
//         foreach ($getProductVariationId as $productVariationId) {
//             $variationDetails = array();
//             foreach ($getRequestData['variations'] as $variations) {
//                 $getVariDetails = ProductVariationDetails::where('variation_id', $productVariationId)
//                     ->where('value', $variations)
//                     ->get()
//                     ->toArray();

//                 if (!empty($getVariDetails)) {
//                     $variationDetails[] = $getVariDetails;
//                 }
//             }
//             if ($attributeCount == count($variationDetails)) {
//                 break;
//             }
//         }
//     }

//     $categoryId = $getProductDetails->product_parent_category;
//     if (in_array('54', explode(',', $getProductDetails->categories))) {
//         $categoryId = 54;
//     }
//     try {
//         $getRegularPrices = ProductVariations::where('id', $variationDetails[0][0]['variation_id'])->select('regular_price', "$diamondType as shopPrice", "$rrpPrice as rrpPrice", 'product_id', 'id')->first();
//     } catch (\Exception $e) {
//         return $e->getMessage();
//     }

//     //$getDiscountedPrice = getIncreaseDiscountedPrice($categoryId,$getRegularPrices->shopPrice,$diamondType);
//     $getDiscountedPrice = $getRegularPrices->shopPrice;
//     $getFingerSizePrice = 0;
//     // if((isset($getProductDetails->product_parent_category) && $getProductDetails->product_parent_category == 47 || $getProductDetails->product_parent_category == 45) && (strpos($getRequestData['fingersize'], '-1/2') !== false)){
//     //     $getFingerSizePrice = getFingerSizeHalfPrice($getRequestData['metal_type']);
//     // }

//     return [
//         'rrp_price' => $getRegularPrices->rrpPrice + $getFingerSizePrice,
//         'shop_price' => $getRegularPrices->shopPrice + $getFingerSizePrice,
//         'discounted_price' => $getDiscountedPrice + $getFingerSizePrice,
//         'parent_category' => $categoryId,
//     ];
// }
function getRagularFilterPrices($requestData, $diamondType, $slug)
{
    $diamondType = !empty($diamondType) ? $diamondType : 'mined_diamond';
    $rrpPriceColumn = $diamondType . '_rrp';

    // Fetch product once
    $product = Products::select('id', 'categories')->where('slug', $slug)->first();
    if (!$product) return ['error' => 'Product not found'];

    $productVariationIds = ProductVariations::where('product_id', $product->id)->pluck('id')->toArray();
    if (empty($productVariationIds)) {
        return ['error' => 'No product variations found'];
    }

    $requestedVariations = $requestData['variations'] ?? [];
    $matchedVariationId = null;

    // Fetch all variation details in one query to reduce DB calls
    $variationDetails = ProductVariationDetails::whereIn('variation_id', $productVariationIds)
        ->whereIn('value', $requestedVariations)
        ->get(['variation_id', 'value'])
        ->groupBy('variation_id');

    foreach ($variationDetails as $variationId => $details) {
        if (count($details) === count($requestedVariations)) {
            $matchedVariationId = $variationId;
            break;
        }
    }

    if (!$matchedVariationId) {
        return ['error' => 'No matching variation found'];
    }

    // Determine category ID
    $categoryId = $product->product_parent_category;
    if (in_array('54', explode(',', $product->categories))) {
        $categoryId = 54;
    }

    // Fetch variation prices
    $variationPrice = ProductVariations::select('regular_price', $diamondType . ' as shopPrice', $rrpPriceColumn . ' as rrpPrice', 'product_id', 'id')
        ->where('id', $matchedVariationId)
        ->first();

    if (!$variationPrice) {
        return ['error' => 'Variation price not found'];
    }

    $fingerSizePrice = 0; // Optional logic can be added here if needed
    $discountedPrice = $variationPrice->shopPrice; // Currently unchanged

    return [
        'rrp_price' => $variationPrice->rrpPrice + $fingerSizePrice,
        'shop_price' => $variationPrice->shopPrice + $fingerSizePrice,
        'discounted_price' => $discountedPrice + $fingerSizePrice,
        'parent_category' => $categoryId,
    ];
}


function getIncreaseDiscountedPrice($category, $price, $diamondType)
{

    $disPercentage = DiscountRange::whereHas('discount_data', function ($q) {
        // $q->whereDate('end_date', '>', now());
    })
        ->with(['discount_data'])->where('category_id', $category)
        ->whereRaw('"' . $price . '" between `from_price` and `to_price`')
        ->when($diamondType, function ($q) use ($diamondType) {
            return $q->whereRaw("FIND_IN_SET(?, diamond_type) > 0", [$diamondType]);
        })
        ->where('discount', '!=', 1)
        ->where('status', 1)
        ->first();

    if (isset($disPercentage) && !empty($disPercentage)) {
        $discountedPrice = $price * (1 - $disPercentage->discount / 100);
        return $discountedPrice;
    }
    return $price;
}

function getFlatDiscountRanges($arrayPrices, $catId, $diamondType)
{
    if (getDiscountFunctionalityapplied() == 'yes') {
        $disPercentage = DiscountRange::whereHas('discount_data', function ($q) {
            // $q->whereDate('end_date', '>', now());
        })
            ->with(['discount_data'])->where('category_id', $catId)
            ->whereRaw('"' . $arrayPrices['shop_price'] . '" between `from_price` and `to_price`')
            // ->where('diamond_type', $diamondType)
            ->when($diamondType, function ($q) use ($diamondType) {
                return $q->whereRaw("FIND_IN_SET(?, diamond_type) > 0", [$diamondType]);
            })
            ->where('discount', '!=', 1)
            // ->where('discount_type', 'F')
            ->where('status', 1)
            ->first();

        if (isset($disPercentage) && !empty($disPercentage)) {
            $arrayPrices['discounted_price'] = round($arrayPrices['shop_price'] * (1 - $disPercentage->discount / 100));
            return $arrayPrices;
        } else {
            $arrayPrices['discounted_price'] = $arrayPrices['shop_price'];
        }
    } else {
        $arrayPrices['discounted_price'] = $arrayPrices['shop_price'];
    }
    return $arrayPrices;
}

function amountHariKrishnaRapnetChange($numPrice)
{
    $marginAPIPercentage = MarginApiRange::where('api_type', 'harikrishna')->whereRaw('"' . $numPrice . '" between `from_price` and `to_price`')
        ->where('status', 1)
        ->first();
    if (isset($marginAPIPercentage) && !empty($marginAPIPercentage)) {
        return $numPrice * $marginAPIPercentage->percentage;
    }
    return $numPrice;
}

if (!function_exists('chnageColumnAccordingToLanguage')) {
    function chnageColumnAccordingToLanguage($data, $relation, $colum_arr = [], $defult_language = null)
    {
        if ($defult_language == null)
            $defult_language = "EN";
        if ($defult_language != env('DEFULT_LANG_CODE')) {

            if (isset($data[0])) {
                foreach ($data as $key => $value) {
                    if (isset($value->$relation[0])) {
                        foreach ($value->$relation as $value1) {
                            if ($value1->lang == $defult_language) {
                                foreach ($colum_arr as $colum_key => $colum_value) {
                                    $data[$key]->$colum_value = $value1->$colum_value;
                                }
                            }
                        }
                    }
                }
            } else {
                if (isset($data->$relation)) {
                    foreach ($data->$relation as $value1) {
                        if ($value1->lang == $defult_language) {
                            foreach ($colum_arr as $colum_key => $colum_value) {
                                $data->$colum_value = $value1->$colum_value;
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }
}

if (!function_exists('chnageMenuLanguage')) {
    // function chnageMenuLanguage($data, $relation, $colum_arr = [], $defult_language = null)
    // {
    //     if ($defult_language == null)
    //         $defult_language = getDefultAdminLanguage();
    //     // if ($defult_language != env('DEFULT_LANG_CODE')) {

    //         if (isset($data[0])) {
    //             foreach ($data as $key => $value) {
    //                 if (isset($value->$relation[0])) {
    //                     foreach ($value->$relation as $value1) {
    //                         if ($value1->lang == $defult_language) {
    //                             foreach ($colum_arr as $colum_key => $colum_value) {
    //                                 $data[$key]->$colum_value = $value1->$colum_value;
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         } else {
    //             if (isset($data->$relation)) {
    //                 foreach ($data->$relation as $value1) {
    //                     if ($value1->lang == $defult_language) {
    //                         foreach ($colum_arr as $colum_key => $colum_value) {
    //                             $data->$colum_value = $value1->$colum_value;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     // }
    //     return $data;
    // }
    function chnageMenuLanguageOld($data, $relation, $colum_arr = [], $defult_language = null)
    {
        // Early return if no data
        if (empty($data) || empty($colum_arr)) {
            return $data;
        }

        // Cache the default language to avoid multiple function calls
        if ($defult_language === null) {
            $defult_language = getDefultAdminLanguage();
        }

        // Handle collection/array of items
        if (isset($data[0])) {
            foreach ($data as $key => $item) {
                $data[$key] = processItemLanguage($item, $relation, $colum_arr, $defult_language);
            }
        } else {
            // Handle single item
            $data = processItemLanguage($data, $relation, $colum_arr, $defult_language);
        }

        return $data;
    }

    /**
     * Process language for a single item
     * Extracted to avoid code duplication
     */
    function processItemLanguage($item, $relation, $colum_arr, $defult_language)
    {
        // Early return if no relation exists
        if (!isset($item->$relation)) {
            return $item;
        }

        // Find the matching language record efficiently
        $languageRecord = findLanguageRecord($item->$relation, $defult_language);

        if ($languageRecord) {
            // Apply all column values in one loop
            foreach ($colum_arr as $column) {
                if (property_exists($languageRecord, $column)) {
                    $item->$column = $languageRecord->$column;
                }
            }
        }

        return $item;
    }

    /**
     * Find the language record more efficiently
     * Uses first() instead of looping through all records
     */
    function findLanguageRecord($relations, $target_language)
    {
        // If it's a Laravel Collection, use Collection methods
        if (method_exists($relations, 'first')) {
            return $relations->first(function ($record) use ($target_language) {
                return $record->lang === $target_language;
            });
        }

        // Fallback for arrays or other iterables
        foreach ($relations as $record) {
            if ($record->lang === $target_language) {
                return $record;
            }
        }

        return null;
    }

    // Alternative optimized version if you prefer to keep it as a single function:
    function chnageMenuLanguage($data, $relation, $colum_arr = [], $defult_language = null)
    {
        // Early returns for better performance
        if (empty($data) || empty($colum_arr)) {
            return $data;
        }

        // Cache the default language
        $defult_language = $defult_language ?? getDefultAdminLanguage();

        // Helper function to process single item
        $processItem = function ($item) use ($relation, $colum_arr, $defult_language) {
            if (!isset($item->$relation)) {
                return $item;
            }

            // Find matching language record efficiently
            $relations = $item->$relation;
            $languageRecord = null;

            // Use Collection methods if available, otherwise loop
            if (method_exists($relations, 'first')) {
                $languageRecord = $relations->first(fn($record) => $record->lang === $defult_language);
            } else {
                foreach ($relations as $record) {
                    if ($record->lang === $defult_language) {
                        $languageRecord = $record;
                        break; // Exit early when found
                    }
                }
            }

            // Apply column values if language record found
            if ($languageRecord) {
                foreach ($colum_arr as $column) {
                    if (property_exists($languageRecord, $column)) {
                        $item->$column = $languageRecord->$column;
                    }
                }
            }

            return $item;
        };

        // Handle collection vs single item
        if (isset($data[0])) {
            // Process array/collection
            foreach ($data as $key => $item) {
                $data[$key] = $processItem($item);
            }
        } else {
            // Process single item
            $data = $processItem($data);
        }

        return $data;
    }
}


if (!function_exists("getBreadcrumbCategoryName")) {
    function getBreadcrumbCategoryName($breadCrumbURL)
    {
        $breadcrumbArray = array_filter(explode('/', $breadCrumbURL));
        $newDesignBreadcrumb = [];
        $breadcrumbDesign = '';
        foreach ($breadcrumbArray as $key => $value) {
            $getCategoryName = Category::where('slug', $value)->value('name');
            if (count($breadcrumbArray) >= $key) {
                $breadcrumbDesign .= "/" . $value;
            }
            if (!next($breadcrumbArray)) {
                $newDesignBreadcrumb[$key] = '' . $getCategoryName . '';
            } else {
                $newDesignBreadcrumb[$key] = '<a href="' . $breadcrumbDesign . '">' . $getCategoryName . '</a>';
            }
        }
        return implode(' / ', $newDesignBreadcrumb);
    }
}

if (!function_exists("checkFingerSizeAvailable")) {
    function checkFingerSizeAvailable($getFingerSize)
    {
        $getAttributeValues = Attributes::where('slug', 'finger-size')->select('name', 'slug', 'values')->first();
        $getFingerSizeArray = explode("|", $getAttributeValues->values);
        $getFingerSizeArray = array_map('trim', $getFingerSizeArray);
        if (in_array(trim($getFingerSize), $getFingerSizeArray)) {
            return true;
        }
        return false;
    }
}

if (!function_exists("checkCaratDiamondValue")) {
    function checkCaratDiamondValue($getCaratValue)
    {
        $minCarat = 0.3;
        $maxCarat = 5.0;
        if ($minCarat <= $getCaratValue && $maxCarat >= $getCaratValue) {
            return true;
        }
        return false;
    }
}

if (!function_exists("checkDiamondTypeValue")) {
    function checkDiamondTypeValue($getDiamondType)
    {
        $diamondTypeArray = [
            'ROUND',
            'PEAR',
            'MARQUISE',
            'HEART',
            'ASSCHER',
            'PRINCESS',
            'RADIANT',
            'EMERALD',
            'OVAL',
            'CUSHION',
            'CUSHION MODIFIED'
        ];
        if (in_array(strtoupper($getDiamondType), $diamondTypeArray)) {
            return true;
        }
        return false;
    }
}

if (!function_exists("checkDiamondColourValue")) {
    function checkDiamondColourValue($getDiamondColour)
    {
        $diamondColourArray = [
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K'
        ];
        if (in_array($getDiamondColour, $diamondColourArray)) {
            return true;
        }
        return false;
    }
}

if (!function_exists("checkDiamondClarityValue")) {
    function checkDiamondClarityValue($getDiamondClarity)
    {
        $diamondClarityArray = [
            'I1',
            'IF',
            'SI1',
            'SI2',
            'VS1',
            'VS2',
            'VVS1',
            'VVS2'
        ];
        if (in_array($getDiamondClarity, $diamondClarityArray)) {
            return true;
        }
        return false;
    }
}
if (!function_exists("checkDiamondCutGradeValue")) {
    function checkDiamondCutGradeValue($getDiamondCutGrade)
    {
        $diamondCutGradeArray = [
            'VG',
            'EX',
            'GD',
            'Excellent',
            'Very Good',
            'Good'
        ];
        if (in_array($getDiamondCutGrade, $diamondCutGradeArray)) {
            return true;
        }
        return false;
    }
}
if (!function_exists("checkDiamondLabValue")) {
    function checkDiamondLabValue($getDiamondLab)
    {
        $diamondLabArray = [
            'GIA',
            'IGI'
        ];
        if (in_array($getDiamondLab, $diamondLabArray)) {
            return true;
        }
        return false;
    }
}
if (!function_exists("getImageOptimizeDetails")) {
    function getImageOptimizeDetails($imageUrl, $width, $height)
    {
        try {

            $path_parts = pathinfo($imageUrl);

            $filename = 'tempfolderpath/' . $path_parts['basename'];

            if (file_exists($filename)) {
                $imageUrl = asset('tempfolderpath/' . $path_parts['basename']);
            } else {
                // Image manipulation
                $img = Image::make(config('constants.APPIMAGEURL') . $imageUrl)->resize($width, $height);
                $tempPath = public_path('tempfolderpath');
                $tempFile = $tempPath . '/' . $path_parts['basename'];
                $img->save($tempFile);
                // Pass the image URL to the view
                $imageUrl = asset('tempfolderpath/' . $path_parts['basename']);
            }
            return $imageUrl;
        } catch (\Throwable $th) {
            Log::alert(config('constants.APPIMAGEURL') . $imageUrl);
            return '#';
        }
    }
    // function getImageOptimizeDetails($imageUrl, $width, $height)
    // {
    //     try {
    //         $path_parts = pathinfo($imageUrl);

    //         $tempPath = public_path('tempfolderpath');

    //         if (!file_exists($tempPath)) {
    //             mkdir($tempPath, 0777, true);
    //         }

    //         $filename = $tempPath . '/' . $path_parts['basename'];

    //         if (file_exists($filename)) {
    //             $imageUrl = asset('tempfolderpath/' . $path_parts['basename']);
    //         } else {
    //             // Image manipulation
    //             $img = Image::make(config('constants.APPIMAGEURL') . $imageUrl)->resize($width, $height);
    //             $img->save($filename);

    //             $imageUrl = asset('tempfolderpath/' . $path_parts['basename']);
    //         }

    //         return $imageUrl;
    //     } catch (\Throwable $th) {
    //         Log::alert('Image error: ' . config('constants.APPIMAGEURL') . $imageUrl);
    //         // Log::alert($th->getMessage());
    //         return '#';
    //     }
    // }
}

if (!function_exists("getProductCategorySlug")) {
    function getProductCategorySlug($productSlug)
    {
        $getProduct = Products::with(['getProductImages', 'getProductVariation'])->where('slug', $productSlug)->first();

        if (isset($getProduct) && !empty($getProduct)) {
            $prod_categories = explode(',', $getProduct->categories);
            $getCatId = Category::whereIn('id', $prod_categories)->where('parent_id', 0)->select('name', 'title', 'slug')->first();
            return $getCatId->slug;
        } else {
            return '';
        }
    }
}

if (!function_exists("getCategoryWiseCount")) {
    // function getCategoryWiseCount($categorySlug, $typeCategory = null)
    // {
    //     $getCatIdConditions = '';
    //     if ($categorySlug == 'diamond-engagement-rings') {
    //         $categorySlug = 'engagement-rings';
    //         // $getCatId = Category::where('slug', $categorySlug)->select('id', 'name', 'title', 'slug')->first();
    //         // $getCatIdConditions = 'FIND_IN_SET(' . $getCatId->id . ', categories)';
    //         $getCatId = Category::where('slug', $categorySlug)->value('id');
    //         $getCatIdConditions = "FIND_IN_SET($getCatId, categories)";
    //     } elseif ($categorySlug == 'diamonds-rings') {
    //         $finalCount = 0;
    //         $categorySlug = [
    //             'engagement-rings',
    //             //'eternity-rings',
    //             'wedding-rings'
    //         ];
    //         // foreach ($categorySlug as $key => $catevlues) {
    //         //     $getCatId = Category::where('slug', $catevlues)->select('id', 'name', 'title', 'slug')->first();
    //         //     $getCatIdConditions = 'FIND_IN_SET(' . $getCatId->id . ', categories)';

    //         //     $getCategoryWiseCount =  Products::with(['getProductImages', 'getProductVariation'])->whereRaw($getCatIdConditions)->where('status', 1)->count();
    //         //     $finalCount += $getCategoryWiseCount;
    //         // }

    //         $categoryIds = Category::whereIn('slug', $categorySlug)
    //             ->pluck('id')
    //             ->toArray();
    //         if (empty($categoryIds)) {
    //             return 0;
    //         }
    //         // Build FIND_IN_SET conditions
    //         $conditions = collect($categoryIds)->map(function ($id) {
    //             return "FIND_IN_SET($id, categories)";
    //         })->implode(' OR ');

    //         // Run one query for products
    //         $finalCount = Products::whereRaw("($conditions)")
    //             ->where('status', 1)
    //             ->count();

    //         return $finalCount;
    //     } else {
    //         if ($typeCategory == 'filter-by-shape') {
    //             $finalCount = 0;
    //             $getCatId = Category::where('slug', 'like', '%' . $categorySlug . '%')->select('id', 'name', 'title', 'slug')->get();
    //             foreach ($getCatId as $catevlues) {
    //                 $getCatIdConditions = 'FIND_IN_SET(' . $catevlues->id . ', categories)';
    //                 $getCategoryWiseCount =  Products::with(['getProductImages', 'getProductVariation'])->whereRaw($getCatIdConditions)->where('status', 1)->count();
    //                 $finalCount += $getCategoryWiseCount;
    //             }
    //             return $finalCount;
    //         }

    //         if ($typeCategory == 'ring-categories') {
    //             $finalCount = 0;
    //             $getCatId = Category::where('slug', 'like', '%' . $categorySlug . '%')->select('id', 'name', 'title', 'slug')->get();
    //             foreach ($getCatId as $catevlues) {
    //                 $getCatIdConditions = 'FIND_IN_SET(' . $catevlues->id . ', categories)';
    //                 $getCategoryWiseCount =  Products::with(['getProductImages', 'getProductVariation'])->whereRaw($getCatIdConditions)->where('status', 1)->count();
    //                 $finalCount += $getCategoryWiseCount;
    //             }
    //             return $finalCount;
    //         }

    //         $getCatId = Category::where('slug', $categorySlug)->select('id', 'name', 'title', 'slug')->first();
    //         if (isset($getCatId->id) && !empty($getCatId->id)) {
    //             $getCatIdConditions = 'FIND_IN_SET(' . $getCatId->id . ', categories)';
    //         } else {
    //             return 0;
    //         }
    //     }
    //     return Products::with(['getProductImages', 'getProductVariation'])->whereRaw($getCatIdConditions)->where('status', 1)->count();
    // }
    function getCategoryWiseCount($categorySlug, $typeCategory = null)
    {
        $categoryIds = [];

        // Case 1: diamond-engagement-rings → engagement-rings
        if ($categorySlug === 'diamond-engagement-rings') {
            $categoryIds[] = Category::where('slug', 'engagement-rings')->value('id');
        }

        // Case 2: diamonds-rings → engagement + wedding
        elseif ($categorySlug === 'diamonds-rings') {
            $categoryIds = Category::whereIn('slug', ['engagement-rings', 'wedding-rings'])
                ->pluck('id')
                ->toArray();
        }

        // Case 3: filter-by-shape / ring-categories
        elseif ($typeCategory === 'filter-by-shape' || $typeCategory === 'ring-categories') {
            $categoryIds = Category::where('slug', 'like', "%{$categorySlug}%")
                ->pluck('id')
                ->toArray();
        }

        // Default case: single category
        else {
            $categoryIds[] = Category::where('slug', $categorySlug)->value('id');
        }

        // Remove null/empty ids
        $categoryIds = array_filter($categoryIds);

        if (empty($categoryIds)) {
            return 0;
        }

        // Build OR conditions for all IDs
        $conditions = collect($categoryIds)
            ->map(fn($id) => "FIND_IN_SET($id, categories)")
            ->implode(' OR ');

        // Run final single query
        return Products::whereRaw("($conditions)")
            ->where('status', 1)
            ->count();
    }
}


// function getFaqByCategorySlug($slugPath)
// {
//     $pageData = Pages::where('slug', $slugPath)->where(['status' => 1, 'is_deleted' => 0])->select('id', 'faq_category')->first();

//     $slugSplitsValues = explode('/', $slugPath);
//     if (count($slugSplitsValues) == 2) {
//         $postCategory = Posts::where('slug', $slugSplitsValues[1])->where(['status' => 1])->select('id', 'faq_category')->first();
//     }
//     $productCategories = Category::where('slug', $slugPath)->where(['status' => 1, 'is_deleted' => 0])->select('id', 'faq_category')->first();

//     if (isset($pageData) && !empty($pageData)) {
//         return Faqs::where('categories', $pageData->faq_category)->get();
//     } else if (isset($postCategory) && !empty($postCategory)) {
//         return Faqs::where('categories', $postCategory->faq_category)->get();
//     } else if (isset($productCategories) && !empty($productCategories)) {
//         return Faqs::where('categories', $productCategories->faq_category)->get();
//     } else {
//         return [];
//     }
// }
function getFaqByCategorySlug($slugPath)
{
    // Try: Page
    $pageData = Pages::where('slug', $slugPath)
        ->where(['status' => 1, 'is_deleted' => 0])
        ->select('faq_category')
        ->first();

    if ($pageData) {
        return Faqs::where('categories', $pageData->faq_category)->get();
    }

    // Try: Post (only if slugPath has 2 parts)
    $slugParts = explode('/', $slugPath);
    if (count($slugParts) === 2) {
        $postCategory = Posts::where('slug', $slugParts[1])
            ->where('status', 1)
            ->select('faq_category')
            ->first();

        if ($postCategory) {
            return Faqs::where('categories', $postCategory->faq_category)->get();
        }
    }

    // Try: Category
    $category = Category::where('slug', $slugPath)
        ->where(['status' => 1, 'is_deleted' => 0])
        ->select('faq_category')
        ->first();

    if ($category) {
        return Faqs::where('categories', $category->faq_category)->get();
    }

    // Default: no match
    return collect(); // better than [] for consistency with Eloquent
}


if (!function_exists("getMinimumPriceFunction")) {
    function getMinimumPriceFunction($productDetails)
    {
        $productCategory = explode(',', $productDetails->categories);

        $diamondTypeStatus = 'lab_grown';
        if (in_array('50', $productCategory) || in_array('53', $productCategory) || in_array('54', $productCategory)) {
            $diamondTypeStatus = 'mined_diamond';
        }

        // $getVariationIdPrice = ProductVariations::where('product_id',$productDetails->id)->select('mined_diamond','lab_grown','mined_diamond_rrp','lab_grown_rrp','product_id','id')->orderBy($diamondTypeStatus,'asc')->first();
        // $getVariationIdPrice = ProductVariations::where('product_id', $productDetails->id)
        //     ->select('mined_diamond1', 'lab_grown', 'mined_diamond_rrp', 'lab_grown_rrp', 'product_id', 'id')
        //     ->orderBy($diamondTypeStatus, 'desc') // Assuming you want the second highest price
        //     ->offset(1) // Skip the first (highest) result
        //     ->limit(1) // Get the second result
        //     ->first();

        if ($productDetails->id == 37) {
            $offset = 2;
        } else {
            $offset = 1;
        }

        $getVariationIdPrice = ProductVariations::select($diamondTypeStatus . '_rrp', $diamondTypeStatus, 'product_id', 'id')
            ->where('product_id', $productDetails->id)
            ->groupBy($diamondTypeStatus)
            ->orderBy($diamondTypeStatus, 'asc')
            ->offset($offset)
            ->limit(1)
            ->first();

        if (isset($getVariationIdPrice) && !empty($getVariationIdPrice)) {

            if (in_array('8', $productCategory)) {
                if (in_array('18', $productCategory)) {
                    $newLabPrice = 0;
                } else {
                    $newPrice = LabPricesList::whereBetween('carat', [1.00, 1.19])->where(['color' => 'D', 'clarity' => 'VS2', 'is_active' => 1, 'is_deleted' => 0])->first();
                    $newLabPrice = $newPrice->price;
                }
                $final_rrp_price = $getVariationIdPrice->lab_grown_rrp + $newLabPrice;
                $final_shop_price = $getVariationIdPrice->lab_grown + $newLabPrice;
            } elseif (in_array('50', $productCategory) || in_array('53', $productCategory) || in_array('54', $productCategory)) {
                $final_rrp_price = $getVariationIdPrice->mined_diamond_rrp;
                $final_shop_price = $getVariationIdPrice->mined_diamond;
            } else {
                $final_rrp_price = $getVariationIdPrice->lab_grown_rrp;
                $final_shop_price = $getVariationIdPrice->lab_grown;
            }
        } else {
            $getVariationIdPrice = ProductVariations::select($diamondTypeStatus . '_rrp', $diamondTypeStatus)
                ->where('product_id', $productDetails->id)
                ->groupBy($diamondTypeStatus)
                ->orderBy($diamondTypeStatus, 'asc')
                ->first();

            $final_rrp_price = $getVariationIdPrice->mined_diamond_rrp;
            $final_shop_price = $getVariationIdPrice->mined_diamond;
        }

        $final_discounted_price = getFlatDiscountRanges(array('shop_price' => $final_shop_price), $productCategory, $diamondTypeStatus);

        return [
            'final_rrp_price' => $final_rrp_price,
            'final_shop_price' => $final_shop_price,
            'final_discounted_price' => isset($final_discounted_price['discounted_price']) ? $final_discounted_price['discounted_price'] : $final_shop_price,
        ];
    }
}

if (!function_exists("getMonthwiseDiscountText")) {
    function getMonthwiseDiscountText()
    {
        return [
            '1' => 'Winter Sale upto 40% off',
            '2' => 'Seasonal Sale upto 40% off',
            '3' => 'Spring Sale upto 40% off',
            '4' => 'Spring Sale upto 40% off',
            '5' => 'Mid Season Sale upto 40% off',
            '6' => 'Summer Sale upto 40% off',
            '7' => 'Summer Sale upto 40% off',
            '8' => 'Summer Sale upto 40% off',
            '9' => 'Autumn Sale upto 40% off',
            '10' => 'Mid Season Sale upto 40% off',
            '11' => 'Winter Sale upto 40% off',
            '12' => 'Christmas Sale upto 40% off',
        ];
    }
}

//start from here
if (!function_exists("getAllCategoryProducts")) {
    function getAllCategoryProducts()
    {
        $getParentCategory = Category::where('parent_id', 0)->pluck('id');
        $getAllCategoryProducts = [];
        foreach ($getParentCategory as $value) {
            $product =
                Products::with(['getProductImages'])->select(['slug', 'id', 'title', 'description', 'lab_description', 'categories'])->where('status', 1)
                ->whereRaw('FIND_IN_SET(' . $value . ', categories)')->inRandomOrder()->limit(3)
                ->get();
            if ($product) {
                $productsArray = $product;
                foreach ($productsArray as $products) {
                    $getCategoryArray = explode(',', $products->categories);
                    if (!in_array('54', $getCategoryArray) && !in_array('8', $getCategoryArray) && ($products->id != 1)) {
                        // compute getMinimumPriceFunction for each product
                        $products->getMinimumPriceFunction = getMinimumPriceFunction($products);
                        $getAllCategoryProducts[] = $products;
                    }
                }
            }
        }
        return collect($getAllCategoryProducts);
    }
}
//ends here

if (!function_exists("getEngagmentRingsLabPriceAdded")) {
    function getEngagmentRingsLabPriceAdded($productDetails)
    {
        $getCategory = explode(",", $productDetails->categories);
        if (in_array(8, $getCategory) && !in_array(18, $getCategory)) {
            $newPrice = LabPricesList::whereBetween('carat', [1.00, 1.19])->where(['color' => 'D', 'clarity' => 'VS2', 'is_active' => 1, 'is_deleted' => 0])->value('price');
            // $newLabPrice = $newPrice->price;
            $productDetails->lab_grown_rrp = $productDetails->lab_grown_rrp + $newPrice;
            $productDetails->lab_grown = $productDetails->lab_grown + $newPrice;
            $final_discounted_price = getFlatDiscountRanges(array('shop_price' => $productDetails->lab_grown), $getCategory, 'lab_grown')['discounted_price'];
            $productDetails->discounted_lab_grown = $final_discounted_price;
        } else {
            $final_discounted_price = getFlatDiscountRanges(array('shop_price' => $productDetails->lab_grown), $getCategory, 'lab_grown')['discounted_price'];
            $productDetails->discounted_lab_grown = $final_discounted_price;
        }
        return $productDetails;
    }
}
if (!function_exists("getFingerSizeHalfPrice")) {
    function getFingerSizeHalfPrice($metalTypeVariation)
    {
        return 0;
        // if (Str::contains($metalTypeVariation, '9ct') || Str::contains($metalTypeVariation, 'Silver')) {
        //     return 0; // return 30;
        // } else {
        //     return 0; // return 50;
        // }
    }
}

if (!function_exists("getFingerSizewithPrices")) {
    function getFingerSizewithPrices($metalTypeVariation, $getFingerSize)
    {
        $metalTypePrices = 0;
        if (Str::contains($metalTypeVariation, '18ct') || Str::contains($metalTypeVariation, 'Platinum')) {
            $metalTypePrices = 20;
        }

        $getFingerSize = str_replace('-1/2', '', $getFingerSize);
        $fingerSize = [
            'G' => 0,
            'H' => 0,
            'I' => 0,
            'J' => 0,
            'K' => 0,
            'L' => 0,
            'M' => 15,
            'N' => 25,
            'O' => 35,
            'P' => 45,
            'Q' => 55,
            'R' => 65,
            'S' => 75,
            'T' => 85,
            'U' => 95,
            'V' => 105,
            'W' => 115,
            'X' => 125,
            'Y' => 135,
            'Z' => 145,
        ];
        // Check if the provided finger size exists in the array keys
        if (array_key_exists($getFingerSize, $fingerSize)) {
            // Return the value (price) associated with the finger size
            if ($fingerSize[$getFingerSize] > 0) {
                return $fingerSize[$getFingerSize] + $metalTypePrices;
            }
            return 0;
        }

        // Return null or an appropriate message if the size is not found
        return 0; // or return 'Size not found' or any default value you want
    }
}

if (!function_exists("getDiscountFunctionalityapplied")) {
    function getDiscountFunctionalityapplied()
    {
        return 'yes';  // yes for discount applied and no for discount not applied
    }
}

if (!function_exists("getLabPriceDefaultVariations")) {
    function getLabPriceDefaultVariations()
    {
        return LabPricesList::whereBetween('carat', [1.00, 1.19])->where(['color' => 'D', 'clarity' => 'VS2', 'is_active' => 1, 'is_deleted' => 0])->value('price');
    }
}
if (!function_exists("generateClientToken")) {
    function generateClientToken()
    {
        $base = config('paypal.base_new_url') ?: config('paypal.base_url');

        if (empty($base)) {
            Log::error('generateClientToken: PAYPAL base URL not configured');
            return null;
        }

        $accessToken = generateAccessToken();
        if (empty($accessToken)) {
            Log::error('generateClientToken: unable to obtain access token');
            return null;
        }

        $url = rtrim($base, '/') . '/v1/identity/generate-token';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Accept-Language: en_US",
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $err = curl_error($ch);
            curl_close($ch);
            Log::error('generateClientToken: curl error', ['error' => $err, 'url' => $url]);
            return null;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 300) {
            Log::error('generateClientToken: unexpected HTTP status', ['http_code' => $httpCode, 'url' => $url, 'response_snippet' => substr($response, 0, 1000)]);
            return null;
        }

        $json = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('generateClientToken: invalid JSON response', ['body' => substr($response, 0, 1000)]);
            return null;
        }

        return $json['client_token'] ?? null;
    }
}




//klarna start
if (!function_exists("generateKlarnaClientToken")) {
    function generateKlarnaClientToken($orderId)
    {
        $klarnaUsername = env('KLARNA_USERNAME');
        $klarnaPassword = env('KLARNA_PASSWORD');
        if (env('APP_ENV') == 'production') {
            $klarnaBaseUrl = 'https://api.klarna.com';
        } else {
            $klarnaBaseUrl = 'https://api.playground.klarna.com';
        }

        //  dd($klarnaUsername);

        $getOrderDetails = Order::with('getOrderDetailsFunction')->where('id', $orderId)->first();




        if (!$getOrderDetails || !$getOrderDetails->getOrderDetailsFunction) {
            \Log::error('Order not found or missing product details', ['order_id' => $orderId]);
            return null;
        }

        $payload = [
            'purchase_country' => 'GB',
            'purchase_currency' => 'GBP',
            'locale' => 'en-GB',
            'order_amount' => (int) round($getOrderDetails->deposited_price * 100),  // Convert to pence (cents)
            'order_tax_amount' => 0,
            'order_lines' => $getOrderDetails->getOrderDetailsFunction->map(function ($item) {
                return [
                    'name' => $item->product_name ?? 'Product',
                    'type' => 'physical',
                    'quantity' => $item->quantity ?? 1,
                    'unit_price' => (int) round($item->deposited_price * 100), // Ensure rounding and integer
                    'total_amount' => (int) round($item->deposited_price * 100 * ($item->quantity ?? 1)), // Convert to pence (cents)
                ];
            }),
        ];



        \Log::info('Klarna session payload:', ['payload' => $payload]);

        $response = Http::withBasicAuth($klarnaUsername, $klarnaPassword)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post("{$klarnaBaseUrl}/payments/v1/sessions", $payload);


        if ($response->successful()) {
            \Log::info('Klarna response:', $response->json());
            return $response->json('client_token');
        }

        \Log::error('Failed to generate Klarna client token', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return null;
    }
}

//klarna ends





if (!function_exists("generateAccessToken")) {
    function generateAccessToken()
    {
        $clientId = config('paypal.client_id');
        $appSecret = config('paypal.secret');
        $base = config('paypal.base_new_url') ?: config('paypal.base_url');

        if (empty($clientId) || empty($appSecret) || empty($base)) {
            Log::error('generateAccessToken: missing PayPal configuration', [
                'client_id_set' => !empty($clientId),
                'secret_set' => !empty($appSecret),
                'base_set' => !empty($base),
            ]);
            return null;
        }

        $url = rtrim($base, '/') . '/v1/oauth2/token';
        $ch = curl_init($url);
        // Use HTTP Basic Auth via CURLOPT_USERPWD
        curl_setopt($ch, CURLOPT_USERPWD, $clientId . ':' . $appSecret);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $err = curl_error($ch);
            curl_close($ch);
            Log::error('generateAccessToken: curl error', ['error' => $err, 'url' => $url]);
            return null;
        }

        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 300) {
            Log::error('generateAccessToken: unexpected HTTP status', ['http_code' => $httpCode, 'url' => $url, 'response_snippet' => substr($response, 0, 1000)]);
            return null;
        }

        $json = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('generateAccessToken: invalid JSON response', ['body' => substr($response, 0, 1000)]);
            return null;
        }

        return $json['access_token'] ?? null;
    }
}
