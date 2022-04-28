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
use App\Models\Faqs;
use App\Models\HKDiamondStock;
//use SoapClient;

if (!function_exists("helper_test")) {
    function helper_test()
    {
        echo "it is working";
    }
}
if (!function_exists("getVAT")) {
    function getVAT(){

        return 1.2;
    }
}

if (!function_exists("single_image_upload")) {
    function single_image_upload($imageUrl,$folderName)
    {
        if (!file_exists(storage_path('app/public/' . $folderName))) {
            mkdir(storage_path('app/public/' . $folderName), 0777);
        }
        $uploadpath = public_path().'\images\\'.$folderName;
        if(is_array($imageUrl)){
            foreach($imageUrl as $file) {

                $filenameWithExt = $file->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $file->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $folderName.'/'.$filename.'_'.time().'.'.$extension;
                // Upload Image
                $path = $file->storeAs('public',$fileNameToStore);
                // return $fileNameToStore;

                // $original_name = $file->getClientOriginalName();
                // $filename = $folderName.'/'.rand().time() . '_' . $file->getClientOriginalName();
                // $file->move($uploadpath, $filename);
                $data[] = $fileNameToStore;
            }
        }else{

            $filenameWithExt = $imageUrl->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $imageUrl->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $folderName.'/'.$filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $imageUrl->storeAs('public',$fileNameToStore);

            // $original_name = $imageUrl->getClientOriginalName();
            // $filename = $folderName.'/'.rand().time() . '_' . $imageUrl->getClientOriginalName();
            // $imageUrl->move($uploadpath, $filename);
            $data['f2'] = $fileNameToStore;
        }
        return $data;
    }
}

if (!function_exists("single_storage_image_upload")) {
    function single_storage_image_upload($imageUrl,$folderName,$height,$width)
    {
        if (!file_exists(storage_path('app/public/' . $folderName))) {
            mkdir(storage_path('app/public/' . $folderName), 0777);
        }
		// $height = 200;
		// $width = 200;
		$image = $imageUrl;
		$imageName = $image->getClientOriginalName();
		$fileName =  $folderName.'/' . time() . '-'.$height.'x'.$width. $imageName;
		Image::make($image)->resize($height,$width)->save(storage_path('app/public/' . $fileName));
		return $fileName;
		
        // $filenameWithExt = $imageUrl->getClientOriginalName();
        ////Get just filename
        // $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        ////Get just ext
        // $extension = $imageUrl->getClientOriginalExtension();
        ////Filename to store
        // $fileNameToStore = $folderName.'/'.$filename.'_'.time().'.'.$extension;
		
		// Image::make($imageUrl)->resize(600,300)->save(storage_path('app/' . $fileNameToStore));
        ////Upload Image
        ////$path = $imageUrl->storeAs('public',$fileNameToStore);
        // return $fileNameToStore;
    }
}



if (!function_exists("product_image_upload")) {
    function product_image_upload($imageUrl,$folderName)
    {

        $filenameWithExt = $imageUrl->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $imageUrl->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $folderName.'/'.$filename.'_'.time().'.'.$extension;
        // Upload Image
        $path = $imageUrl->storeAs('public',$fileNameToStore);

        // // echo "it is working single";
        // if (!file_exists('images/'.$folderName)) {
        //     mkdir('images/'.$folderName, 0777);
        // }
        // // mkdir('images/'.$folderName, 0777);
        // $uploadpath = public_path().'\images\\'.$folderName;
        // // $original_name = $imageUrl->getClientOriginalName();
        // $filename = $folderName.'/'.rand().time() . '_' . $imageUrl->getClientOriginalName();
        // // $filename = $original_name;
        // $imageUrl->move($uploadpath, $filename);

        return  $fileNameToStore;

        // return $data;
    }
}
if (!function_exists("product_video_upload")) {
    function product_video_upload($imageUrl,$folderName)
    {
        $filenameWithExt = $imageUrl->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $imageUrl->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $folderName.'/'.$filename.'_'.time().'.'.$extension;
        // Upload Image
        $path = $imageUrl->storeAs('public',$fileNameToStore);

        // echo "it is working single";
        // if (!file_exists('images/'.$folderName)) {
        //     mkdir('images/'.$folderName, 0777);
        // }
        // // mkdir('images/'.$folderName, 0777);
        // $uploadpath = public_path().'\images\\'.$folderName;
        // // $original_name = $imageUrl->getClientOriginalName();
        // $filename = $folderName.'/'.rand().time() . '_' . $imageUrl->getClientOriginalName();
        // // $filename = $original_name;
        // $imageUrl->move($uploadpath, $filename);
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
        function in_array_r($item , $array){
            return preg_match('/"'.preg_quote($item, '/').'"/i' , json_encode($array));
        }
    }
	
	
	if (!function_exists("getReviews")) {
    function getReviews()
		{
			$reviews = Reviews::all();
			return ($reviews);
		}	
	}
	
	if (!function_exists("getCategories")) {
    function getCategories()
		{
			$postcategories = PostCategory::all();
			return ($postcategories);
		}	
	}
	
	if (!function_exists("getRecentPosts")) {
    function getRecentPosts()
		{
			$recentposts = Posts::take(5)->orderBy('id','DESC')->where('status', 1)->get();
			return ($recentposts);
		}	
	}
	if (!function_exists("getRelatedPosts")) {
    function getRelatedPosts()
		{
			$relatedposts = Posts::take(5)->orderBy('id','DESC')->where('status', 1)->get();
			return ($relatedposts);
		}	
	}
	if (!function_exists("getFaqs")) {
    function getFaqs()
		{
			$faqs = Faqs::take(5)->orderBy('id','DESC')->where('status', 1)->get();
			return ($faqs);
		}	
	}
    /*
    ** Hari Krishna API function
    * @params : data as array
    */
    if (!function_exists("getHKApiRecords")) {

        function getHKApiRecords($data=array())
        {
            $results = HKDiamondStock::
                where('Shape','LIKE',$data['shape'])
                ->whereBetween('Carat', [$data['caratFrom'], $data['caratTo']]);

            if(!empty($data['colour'])){
                $results = $results->whereIn('Color', $data['colour']);
            }

            if(!empty($data['clarity'])){
                $results = $results->whereIn('Clarity', $data['clarity']);
            }

            if(!empty($data['grade'])){
                $results = $results->whereIn('Cut', $data['grade']);
            }

            if(!empty($data['polish'])){
                $results = $results->whereIn('Polish', $data['polish']);
            }

            if(!empty($data['symmetry'])){
                $results = $results->whereIn('Symmetry', $data['symmetry']);
            }

            if(!empty($data['fluorescence'])){
                $results = $results->whereIn('Flourescent', $data['fluorescence']);
            }

            if(!empty($data['certificate'])){
                $results = $results->whereIn('Lab', $data['certificate']);
            }

            $results = $results->orderBy('id','ASC');
            //echo $results->toSql(); die;
            if(isset($data['paging']))
                $results = $results->paginate($data['paging']);
                //$results = $results->get(); 
            else if(isset($data['num_of_row']))
                $results = $results->take($data['num_of_row'])->get();
            else
               $results = $results->get(); 
            //echo '<pre>'; print_r($results->toArray()); die;
            return $results->toArray();
        }

    }
    /*
    ** Rapnet API function
    * @params : data as array
    */
    if (!function_exists("getRapnetApiRecords")) {

        function getRapnetApiRecords($data=array(),$pageNumber){

            $client = new SoapClient("https://technet.rapaport.com/WebServices/RetailFeed/Feed.asmx?WSDL", array( "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0) );
            
            $params = array('Username'=>'95503', 'Password'=>'@diamond1');
            $client->__soapCall("Login", array($params), NULL, NULL, $output_headers);
        
            $ticket = $output_headers["AuthenticationTicketHeader"]->Ticket;
        
           // $client1 = new SoapClient("https://technet.rapaport.com/WebServices/RetailFeed/Feed.asmx?WSDL", array( "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0) );
            
            $rapnetData = $rapnetAllData = array();

            $ns = "http://technet.rapaport.com/";
            $headerBody = array("Ticket" => $ticket);
            $header = new \SoapHeader($ns, 'AuthenticationTicketHeader', $headerBody);
            $client->__setSoapHeaders($header);
            
            if(isset($data['gradeFrom'])){
                if($data['gradeFrom'] == 'EX'){ $gradeFrom = 'EXCELLENT';
                } elseif($data['gradeFrom'] == 'VG'){ $gradeFrom = 'VERY_GOOD';
                } elseif($data['gradeFrom'] == 'GD'){ $gradeFrom = 'GOOD';
                }
            }
            if(isset($data['gradeTo'])){
                if($data['gradeTo'] == 'EX'){ $gradeTo = 'EXCELLENT';
                } elseif($data['gradeTo'] == 'VG'){ $gradeTo = 'VERY_GOOD';
                } elseif($data['gradeTo'] == 'GD'){ $gradeTo = 'GOOD';
                }
            }
            if(isset($data['symmetryFrom'])){
                if($data['symmetryFrom'] == 'EX'){ $symmetryFrom = 'Excellent';
                } elseif($data['symmetryFrom'] == 'VG'){ $symmetryFrom = 'Very_Good';
                } elseif($data['symmetryFrom'] == 'GD'){ $symmetryFrom = 'Good';
                }
            }
            if(isset($data['symmetryTo'])){
                if($data['symmetryTo'] == 'EX'){ $symmetryTo = 'Excellent';
                } elseif($data['symmetryTo'] == 'VG'){ $symmetryTo = 'Very_Good';
                } elseif($data['symmetryTo'] == 'GD'){ $symmetryTo = 'Good';
                }
            }
            if(isset($data['polishFrom'])){
                if($data['polishFrom'] == 'EX'){ $polishFrom = 'Excellent';
                } elseif($data['polishFrom'] == 'VG'){ $polishFrom = 'Very_Good';
                } elseif($data['polishFrom'] == 'GD'){ $polishFrom = 'Good';
                }
            }
            if(isset($data['polishTo'])){
                if($data['polishTo'] == 'EX'){ $polishTo = 'Excellent';
                } elseif($data['polishTo'] == 'VG'){ $polishTo = 'Very_Good';
                } elseif($data['polishTo'] == 'GD'){ $polishTo = 'Good';
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
                "SymmetryFrom" =>$symmetryFrom,
                "SymmetryTo" =>$symmetryTo,
                "PolishFrom" =>$polishFrom,
                "PolishTo" =>$polishTo,
                "FluorescenceIntensityCollection" =>$data['fluorescence'],
                "PriceFrom" => "1",
                "PriceTo" => "999999",
                "PageNumber" => $pageNumber,
                "PageSize" => 5,
                "SortDirection" => "ASC",
                "SortBy" => "PRICE"
            );
        
        
            $params1 = array("SearchParams" => $searchParams, "DiamondsFound" => 0);

            $results=$client->__soapCall("GetDiamonds", array($params1), NULL, NULL, $output_headers);

            if(isset($results->GetDiamondsResult) && !empty($results->GetDiamondsResult->any)){
                $apiXmlResponse = simplexml_load_string($results->GetDiamondsResult->any);
                $object = json_decode(json_encode($apiXmlResponse->NewDataSet));
            }else{
                $object = new \stdclass;
                $object->Table1 = '';
            }
            
            if(is_object($object->Table1)){
                $allData[]=$object->Table1;
            }else{
                $allData=$object->Table1;
            }

            if(!empty($allData)){
                $rapnetAllData = array_merge($rapnetData,$allData);
            }

            return $rapnetAllData;
        }
    }
}

