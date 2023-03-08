<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\SitemapUrls;
use App\Models\VisitorPageTracking;
use App\Models\SeoScripts;
use Redirect;

class WebCommonHandler{

    public function handle($request, Closure $next){

        $fullUrl = $request->url();
        $seoScriptData = SeoScripts::where(['page'=> $fullUrl, 'is_deleted'=>0, 'is_active'=>1 ])->first();
        if(!empty($seoScriptData)){
            view()->share('seoScriptData', $seoScriptData);
        }
        // 
        // if($request->isMethod('get') && (!str_contains($url, 'storage'))  ){
        //     $exist = SitemapUrls::where(['is_deleted'=>0, 'url'=> $url ])->first();
        //     if(empty($exist)){
        //         $newUrl = new SitemapUrls();
        //         $newUrl->url = $url;
        //         $newUrl->save();
        //     }
        // }
        // echo 'WORKING';die;
        // $url = $request->path();
        // if($request->isMethod('get') && (!str_contains($url, 'storage'))  ){
        //     $userIpInfo = getIpInfo();
        //     $browserInfo = getBrowser();

        //     if(!empty($userIpInfo) || !empty($browserInfo)){
                
        //         $url = $request->path();

        //         $new_log = new VisitorPageTracking();
        //         $new_log->page_url = $url;
        //         $new_log->user_agent = !empty($browserInfo) ? $browserInfo['userAgent'] : '' ;
        //         $new_log->browser = !empty($browserInfo) ? $browserInfo['name'] : '' ;
        //         $new_log->browser_version = !empty($browserInfo) ? $browserInfo['version'] : '' ;
        //         $new_log->platform = !empty($browserInfo) ? $browserInfo['platform'] : '' ;
        //         $new_log->country = $userIpInfo ? $userIpInfo['country'] : null;
        //         $new_log->country_code = $userIpInfo ? $userIpInfo['country_code'] : null;
        //         $new_log->continent = $userIpInfo ? $userIpInfo['continent'] : null;
        //         $new_log->continent_code = $userIpInfo ? $userIpInfo['continent_code'] : null;
        //         $new_log->ip_address = $userIpInfo ? $userIpInfo['ip'] : null;
        //         $new_log->save();
        //     }
        // }
        
        return $next($request);
    }
}
