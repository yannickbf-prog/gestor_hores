<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class UserAuthenticated {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {

        $lang = getLang();
        
        if (Auth::check()) {
            if (Auth::user()->isUser()) {
                return $next($request);
            }
            elseif (Auth::user()->isAdmin()) {
                return redirect()->route($lang.'_home.index');
            }
        }
        else{
            return redirect()->route($lang.'_login');
        }

        abort(404);
    }

}
