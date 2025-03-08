<?php

namespace App\Http\Controllers;
use App\Services\EmailService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class settingController extends Controller
{
    public function showsetting()
    {
        $loginUserInfo = Auth::user();
       
        $users = User::where('organisation_id', $loginUserInfo->organisation_id)->paginate(1);
        return view('user_view.setting',compact('users'));
    }

    public function saveThought(Request $request)
    {
        $loginUserInfo = Auth::user();

       $status =  DB::table('thought_of_the_days')->insert([
            'organisation_id' => $loginUserInfo->organisation_id,
            'creationDate' => $request->date,
            'thought' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if($status){

            return redirect()->route('user.setting')->with('success', 'Thought of the Day saved successfully.');

        }else{

            return redirect()->route('user.setting')->with('error', 'Thought of the Day not saved successfully.');

        }

    
    }

    public function saveNewsEvents(Request $request)
    {
        $loginUserInfo = Auth::user();

       $status =  DB::table('news_and_events')->insert([
            'organisation_id' => $loginUserInfo->organisation_id,
            'creationDate' => $request->date,
            'title' => $request->title,
            'description' => $request->description,
            'startdate' => $request->startdate,
            'enddate' => $request->enddate,
            'location' => $request->location,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if($status){

            return redirect()->route('user.setting')->with('success', 'News & Events saved successfully.');

        }else{

            return redirect()->route('user.setting')->with('error', 'News & Events not saved successfully.');

        }

    
    }
}
