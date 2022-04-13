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

if (!function_exists("helper_test")) {
    function helper_test()
    {
        echo "it is working";
    }
}

if (!function_exists("single_image_upload")) {
    function single_image_upload($imageUrl,$folderName)
    {
        if (!file_exists('images/'.$folderName)) {
            mkdir('images/'.$folderName, 0777);
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
		// $height = 200;
		// $width = 200;
		$image = $imageUrl;
		$imageName = $imageUrl->getClientOriginalName();
		$fileName =  'posts/' . time() . '-'.$height.'x'.$width. $imageName;
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
}
