<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userHomePageStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {

            $loginUserInfo = Auth::user();
            $data = userHomePageStatus::where('user_id', $loginUserInfo->id)->get(); 
            // dd($data);
            if($data->isNotEmpty()){

                if($data[0]->homePageStatus == 1){

                    return redirect()->route('user.homepage');
    
                }else{
    
                    return redirect()->route('user.dashboard');
    
                }

            }else{

                return redirect()->route('user.dashboard');



            }
            
            
        }

        // return back()->withErrors(['error' => 'Invalid credentials']);
        return redirect()->route('user.login')->with('error','Invalid credentials');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('user.login');
    }
}
