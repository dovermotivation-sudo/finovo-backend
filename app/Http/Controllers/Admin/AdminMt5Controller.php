<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminMt5Controller extends Controller
{
    public function index()
    {
        $users = \App\Models\User::where('role', '!=', 'super_admin')
            ->with('mt5Account')
            ->paginate(20);
            
        return view('admin.mt5.index', compact('users'));
    }

    public function show($id)
    {
        $user = \App\Models\User::with(['kycDocuments', 'mt5Account'])->findOrFail($id);
        
        return view('admin.mt5.show', compact('user'));
    }

    public function attach(Request $request, $id)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
            'server' => 'required|string',
        ]);

        $user = \App\Models\User::findOrFail($id);

        $mt5Account = $user->mt5Account()->firstOrNew(['user_id' => $user->id]);
        $mt5Account->login = $request->login;
        $mt5Account->password = $request->password;
        $mt5Account->server = $request->server;
        $mt5Account->status = 'connected';
        $mt5Account->save();

        return redirect()->route('admin.mt5.index')->with('success', 'MT5 Account successfully attached to user.');
    }
}
