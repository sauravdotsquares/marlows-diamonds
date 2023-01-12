<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\UrlRedirects;
use Redirect;

class SiteMapSaver{

    public function handle($request, Closure $next){

        $url = $request->path();
        $check = UrlRedirects::where(['old_url'=> $url, 'is_active'=>1, 'is_deleted'=>0])->first();
        if(!empty($check)){
            return redirect('/'. $check->new_url);
            // $request->to($check->new_url);
        }
        return $next($request);
    }
}
