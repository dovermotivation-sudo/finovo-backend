<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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
        $supportedLocales = ['en', 'es', 'fr', 'hi'];
        $locale = Session::get('locale', config('app.locale', 'en'));
        
        // Validate locale exists and is supported
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'en';
            Session::put('locale', $locale);
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Ensure the locale is properly set in config
        config(['app.locale' => $locale]);
        
        return $next($request);
    }
}
