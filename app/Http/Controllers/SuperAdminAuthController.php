<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.superadmin-login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // $credentials = $request->only('email', 'password');

        // dd($credentials);


        if (Auth::guard('superadmin')->attempt($credentials)) {
            return redirect()->route('superadmin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
     }

    public function logout()
    {
        Auth::guard('superadmin')->logout();
        return redirect()->route('superadmin.login');
    }
}
