<?php
/**
 * Created by PhpStorm.
 * User: shehbaz
 * Date: 1/21/19
 * Time: 12:19 PM
 */


use Illuminate\Support\Facades\Validator;

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
                // $original_name = $file->getClientOriginalName();
                $filename = $folderName.'/'.rand().time() . '_' . $file->getClientOriginalName();
                $file->move($uploadpath, $filename);
                $data[] = $filename;
            }
        }else{
            // $original_name = $imageUrl->getClientOriginalName();
            $filename = $folderName.'/'.rand().time() . '_' . $imageUrl->getClientOriginalName();
            $imageUrl->move($uploadpath, $filename);
            $data['f2'] = $filename;
        }
        return $data;
    }
}
if (!function_exists("product_image_upload")) {
    function product_image_upload($imageUrl,$folderName)
    {
        // echo "it is working single";
        if (!file_exists('images/'.$folderName)) {
            mkdir('images/'.$folderName, 0777);
        }
        // mkdir('images/'.$folderName, 0777);
        $uploadpath = public_path().'\images\\'.$folderName;
        // $original_name = $imageUrl->getClientOriginalName();
        $filename = $folderName.'/'.rand().time() . '_' . $imageUrl->getClientOriginalName();
        // $filename = $original_name;
        $imageUrl->move($uploadpath, $filename);
        return  $filename;

        // return $data;
    }
}
if (!function_exists("product_video_upload")) {
    function product_video_upload($imageUrl,$folderName)
    {
        // echo "it is working single";
        if (!file_exists('images/'.$folderName)) {
            mkdir('images/'.$folderName, 0777);
        }
        // mkdir('images/'.$folderName, 0777);
        $uploadpath = public_path().'\images\\'.$folderName;
        // $original_name = $imageUrl->getClientOriginalName();
        $filename = $folderName.'/'.rand().time() . '_' . $imageUrl->getClientOriginalName();
        // $filename = $original_name;
        $imageUrl->move($uploadpath, $filename);
        return  $filename;

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
}
