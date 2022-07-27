<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Phpfastcache\Helper\Psr16Adapter;
use App\Models\InstagramData;
use App\Http\Controllers\Admin\InstaLibraryController;

class InstagramController extends Controller
{

    public function index()
    {
        $params = array(
            'get_code' => isset( $_GET['code'] ) ? $_GET['code'] : '',
            'access_token' => config('instagram.access_token'),
            'user_id' => '',
        );
        $iguser = new InstaLibraryController($params);
        $user = $iguser->getUser();

        $params = array(
            'get_code' => isset( $_GET['code'] ) ? $_GET['code'] : '',
            'access_token' => config('instagram.access_token'),
            'user_id' => $user['id']
        );

        $igMedia = new InstaLibraryController($params);

        $userMedia = $iguser->getUsersMedia($user['id']);

        InstagramData::truncate();
        foreach ($userMedia['data'] as $key  => $value) {

            $images[$key] = [
                'image_link'=> str_replace("&amp;","&", $value['media_url']),
                'insta_link'=>"",
            ];

            $path = $images[$key]['image_link'];
            $imageName = $key.'.webp';
            $img = public_path('images/Instagram/') . $imageName;

            $fileNameToStore = 'Instagram'.'/'.$imageName;


            InstagramData::create([
                'insta_id'=> $value['id'],
                'link'=>$value['permalink'],
                'image_url'=>$fileNameToStore,
                'alt'=>$value['caption'],
                'title'=>$value['caption'],
                'media_type'=>$value['media_type'],
                'insta_timestamp'=>$value['timestamp'],
                'username'=>$value['username'],
            ]);

            file_put_contents($img, file_get_contents($path));
        }
        echo "Done";
    }

    /**
     * This function show the image from instagram.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateInstaData()
    {
        $getInstaData = InstagramData::latest()->value('created_at');

        if(isset($getInstaData) && !empty($getInstaData)){
            $currentDate = date('d-m-Y');
            $getDBRecordDate = $getInstaData->format('d-m-Y');
            if($currentDate != $getDBRecordDate){
                return $this->finalMainInstaFunction();
            }else{
                return false;
            }
        }else{
            return $this->finalMainInstaFunction();
        }
    }

    function getProtectedValue($obj, $name) {
        $array = (array)$obj;
        $prefix = chr(0).'*'.chr(0);
        return $array[$prefix.$name];
    }

    function finalMainInstaFunction(){
        ini_set("allow_url_fopen", 1);

        $instagram = \InstagramScraper\Instagram::withCredentials(new \GuzzleHttp\Client(), 'marlows_diamonds', '1580@Marlows30', new Psr16Adapter('Files'));

        $instagram->setUserAgent('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36');

        $instagram->login(false);

        $instagram->saveSession();

        $account = $instagram->getAccount('marlows_diamonds');

        $accountMedias = $account->getMedias();

        if (!file_exists(storage_path('app/public/Instagram'))) {
            mkdir(storage_path('app/public/Instagram'), 0777);
        }

        $getInstaData = InstagramData::truncate();
        foreach ($accountMedias as $key  => $accountMedia) {
            $images[$key] = [
                'image_link'=> str_replace("&amp;","&", $accountMedia->getimageHighResolutionUrl()),
                'insta_link'=>"",
            ];

            $path = $images[$key]['image_link'];
            $imageName = $key.'.png';
            $img = storage_path('app/public/Instagram/') . $imageName;

            $fileNameToStore = 'Instagram'.'/'.$imageName;

            $getInstaData = InstagramData::create([
                'link'=>$this->getProtectedValue($accountMedia,'link'),
                'image_url'=>$fileNameToStore,
                'title'=>"No Title",
            ]);

            file_put_contents($img, file_get_contents($path));
        }

        return true;
    }
}
