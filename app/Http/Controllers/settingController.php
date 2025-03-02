<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class settingController extends Controller
{
    public function showsetting()
    {
        return view('user_view.setting');
    }

    public function saveThought(Request $request)
    {
        $loginUserInfo = Auth::user();

        DB::table('thought_of_the_days')->insert([
            'organisation_id' => $loginUserInfo->organisation_id,
            'creationDate' => $request->date,
            'thought' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('user.setting')->with('success', 'Thought of the Day saved successfully.');
    }

    public function saveNewsEvents(Request $request)
    {
        $loginUserInfo = Auth::user();

        DB::table('news_and_events')->insert([
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

        return redirect()->route('user.setting')->with('success', 'News & Events saved successfully.');
    }
}
