<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ActivityLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()) return redirect()->route('login');
        
        if($request->ajax()) return $next($request);
        
        $path = Str::squish(Str::replace([F_SLASH, '-'], NORMAL_SPACE, $request->getRequestUri()));

        activity(collect(explode(NORMAL_SPACE, $path))->first())->causedBy(Auth::user())->log($path);
        
        return $next($request);
    }
}
