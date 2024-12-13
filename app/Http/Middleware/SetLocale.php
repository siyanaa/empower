<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

use Closure;
use Illuminate\Http\Request;

class SetLocale
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

        $language = $request->input('locale');

        if ($language) {
            Session::put('locale', $language);
            App::setLocale($language);
        } elseif (Session::has('locale')) {
            $language = Session::get('locale');
            App::setLocale($language);
        }
    
        return $next($request);
        // if(! $request->user()) {
        //     return $next($request);
        // }
 
        // $language = $request->input('locale');;
 
        // if ($language) {
        //     Session::put('locale', $language);
        //     App::setLocale($language);
        // } elseif (Session::has('locale')) {
       
        //     $language = Session::get('locale');
        //     App::setLocale($language);
        // }
        // return $next($request);


        // if(! $request->user()) {
        //     return $next($request);
        // }
 
        // $language = $request->segment(2);
        
        // if (isset($language)) {
        //     dd($language);
        //     if (in_array($language, config('app.available_locales'))) {
        //         Session::put('locale', $language);
        //         App::setLocale($language);
        //     }
        // }
 
        // return $next($request);
    }
}
