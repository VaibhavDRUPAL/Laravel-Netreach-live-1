<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $locale = $request->route('locale');

        if (in_array($locale, ['en','hi','mr','te','ta'])) { 
            Session::put('locale', $locale);
            App::setLocale($locale);
        } else {
            Session::put('locale','en');
            App::setLocale('en'); // Default to English
        }
        return $next($request);

    }
}
