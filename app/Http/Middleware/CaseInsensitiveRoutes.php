<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CaseInsensitiveRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the original request URI
        $originalUri = $request->getRequestUri();
        
        // Convert the request URI to lowercase
        $lowercaseUri = Str::lower($originalUri);
        
        // Check if there is a difference in case
        if ($originalUri !== $lowercaseUri) {
            // Redirect to the lowercase URI
            return redirect($lowercaseUri, 
            ); // 301 for a permanent redirect
        }

        // Proceed with the request if no case difference
        return $next($request);
    }
}
