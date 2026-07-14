<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLanguage($locale)
    {
        $supportedLocales = ['en', 'es', 'fr', 'hi'];
        
        if (!in_array($locale, $supportedLocales)) {
            return response()->json(['success' => false, 'message' => 'Unsupported locale'], 400);
        }
        
        // Set application locale
        App::setLocale($locale);
        
        // Store in session
        Session::put('locale', $locale);
        
        // Update config
        config(['app.locale' => $locale]);
        
        return response()->json(['success' => true, 'locale' => $locale]);
    }
}
