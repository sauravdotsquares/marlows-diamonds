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

    public function getInstagramPostAPIData() {
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.instagram.com/me/media?fields=id%2Ccaption%2Cmedia_type%2Cmedia_url%2Cpermalink%2Cthumbnail_url%2Ctimestamp%2Cusername&access_token=IGQWRQNDg3UHdIYjAydWlmZAkpQZAE1xSzZAiYWtHSnZAfV2hPczNaMUltZAVJKdUh1T3dyVGdDNTdKd0dDY011eWJVNUFWbjVwSlZASQUx3Ymx2VmRXaE9WdVFxMjBxSWRmbjNuaEZAkeVBMRlJWZAwZDZD&limit=50',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: csrftoken=TgMHsSlwsMommjyd1sNkOOYGyKyt5tVK; ig_did=19AA6934-4FE2-4C32-8891-B2AE9DA4D8D5; ig_nrcb=1; mid=ZXnA0wAEAAHVeVJBbE51qrUnrJ-9'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        if (!file_exists(public_path('/images/Instagram'))) {
            mkdir(public_path('/images/Instagram'), 0777);
        }

        $accountMedias = json_decode($response);

        InstagramData::truncate();
        foreach ($accountMedias->data as $key  => $accountMedia) {

            $path = $accountMedia->media_url;

            $filename_from_url = parse_url($accountMedia->media_url);
            $ext = pathinfo($filename_from_url['path'], PATHINFO_EXTENSION);

            if($accountMedia->media_type == 'IMAGE'){
                $imageName = $key.'.'.$ext;
            }elseif($accountMedia->media_type == 'VIDEO'){
                $imageName = $key.'.'.$ext;
            }
            
            $img = public_path('/images/Instagram/') . $imageName;

            

            $fileNameToStore = 'Instagram'.'/'.$imageName;

            file_put_contents($img, file_get_contents($path));

            InstagramData::create([
                'insta_id'=> $accountMedia->id,
                'link'=>$accountMedia->permalink,
                'image_url'=>$fileNameToStore,
                'alt'=>isset($accountMedia->caption)?$accountMedia->caption:'',
                'title'=>isset($accountMedia->caption)?$accountMedia->caption:'',
                'media_type'=>$accountMedia->media_type,
                'insta_timestamp'=>$accountMedia->timestamp,
                'username'=>$accountMedia->username,
            ]);
        }
        echo "file all data uploaded db updated done gajendra <pre>";
        die;
    }
}
