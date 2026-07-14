<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $user->load('plan');
        
        return view('user.dashboard', compact('user'));
    }
}
