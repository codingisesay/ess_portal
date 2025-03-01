<?php

namespace App\Http\Controllers;
use App\Models\LoginLog;
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
// Validate the login credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // $credentials = $request->only('email', 'password');
// Attempt to log the user in
        if (Auth::guard('web')->attempt($credentials)) {

            $loginUserInfo = Auth::user();
            $data = userHomePageStatus::where('user_id', $loginUserInfo->id)->get(); 
            // dd($data);

             // Check if the user has logged in today
             $todayLog = LoginLog::whereDate('login_time', today())
             ->where('user_id', $loginUserInfo->id)
             ->first();

              // If there's no log for today, create a new login log entry
            if (!$todayLog) {
                LoginLog::create([
                    'user_id' => $loginUserInfo->id,
                    'login_time' => now(), // Full timestamp
                    'login_date' => today(), // Only the date
                ]);
            }

             // Redirect based on home page status
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
 // If login fails, redirect back with an error
        // return back()->withErrors(['error' => 'Invalid credentials']);
        return redirect()->route('user.login')->with('error','Invalid credentials');
    }

    public function logout()
    {
        // Auth::guard('web')->logout();
        // return redirect()->route('user.login');
        $user = Auth::guard('web')->user(); // Get the currently logged-in user

       

        // Find the log for the current day and update the logout time
        $todayLog = LoginLog::whereDate('login_time', today())
                            ->where('user_id', $user->id)
                            // ->whereNull('logout_time')
                            ->first();
// dd($todayLog);
        if ($todayLog) {
            // Update the logout time
            $todayLog->logout_time = now();
            $todayLog->save();
        }

        // Log out the user
        Auth::guard('web')->logout();

        // Redirect to the login page
        return redirect()->route('user.login');
    }
}
