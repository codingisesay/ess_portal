<?php

namespace App\Http\Controllers;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class homePagecontroller extends Controller
{
    public function showHomepage()
    {

        $user = Auth::user(); // Get the logged-in user

        // Fetch the login logs for today
        $logs = LoginLog::whereDate('login_time', today())
                        ->where('user_id', $user->id)
                        ->get();

        // Return a view with the logs
        return view('user_view.homepage', compact('logs'));
        // return view('');
    }
}
