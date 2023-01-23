<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\SitemapUrls;
use Redirect;

class SiteMapSaver{

    public function handle($request, Closure $next){

        $url = $request->path();
        if($request->isMethod('get') && (!str_contains($url, 'storage'))  ){
            $exist = SitemapUrls::where(['is_deleted'=>0, 'url'=> $url ])->first();
            if(empty($exist)){
                $newUrl = new SitemapUrls();
                $newUrl->url = $url;
                $newUrl->save();
            }
        }

        
        return $next($request);
    }
}
