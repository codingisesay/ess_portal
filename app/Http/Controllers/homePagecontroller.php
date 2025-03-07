<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\ToDoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class homePagecontroller extends Controller
{
    public function showHomepage(Request $request)
    {
        $user = Auth::user(); // Get the logged-in user

        // Fetch the login logs for today
        $logs = DB::table('login_logs')
                  ->whereDate('login_time', today())
                  ->where('user_id', $user->id)
                  ->get();

        // Fetch additional data
        $thoughtOfTheDay = DB::table('thought_of_the_days')
                             ->where('organisation_id', $user->organisation_id)
                             ->latest()
                             ->first();

        $newsAndEvents = DB::table('news_and_events')
                           ->where('organisation_id', $user->organisation_id)
                           ->orderBy('startdate', 'desc')
                           ->get();

        // Fetch upcoming and today's birthdays
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
        $currentDay = $currentDate->day;

        $upcomingBirthdays = DB::table('emp_details')
            ->select('Employee_Name', 'date_of_birth', 'Designation')
            ->whereMonth('date_of_birth', '=', $currentMonth)
            ->whereDay('date_of_birth', '>=', $currentDay)
            ->get()
            ->map(function ($employee) use ($currentDay, $currentDate) {
                $birthDate = new Carbon($employee->date_of_birth);
                $birthDay = $birthDate->day;
                $employee->age = $birthDate->age;
                $employee->badgeText = $birthDay === $currentDay ? "Today" : "Upcoming in " . ($birthDay - $currentDay) . " days";
                return $employee;
            });

        // Fetch upcoming anniversaries
        $anniversaries = DB::table('emp_details')
            ->select('Employee_Name', 'Joining_Date')
            ->whereMonth('Joining_Date', '=', $currentMonth)
            ->whereDay('Joining_Date', '>=', $currentDay)
            ->get()
            ->map(function ($employee) use ($currentDay, $currentDate) {
                $joiningDate = new Carbon($employee->Joining_Date);
                $joiningDay = $joiningDate->day;
                $employee->yearsCompleted = $joiningDate->diffInYears($currentDate);
                $employee->badgeText = $joiningDay === $currentDay ? "Today" : "Upcoming in " . ($joiningDay - $currentDay) . " days";
                return $employee;
            });

        // Return a view with the logs and additional data
        return view('user_view.homepage', compact('logs', 'thoughtOfTheDay', 'newsAndEvents', 'upcomingBirthdays', 'anniversaries', 'currentMonth', 'currentDay'));
    }

    public function saveToDoList(Request $request)
    {
        $user = Auth::user(); // Get the logged-in user

        $request->validate([
            'task_date' => 'required|date',
            'project_name' => 'required|string|max:255',
            'task_name' => 'required|string|max:255',
            'hours' => 'required|string|max:255',
        ]);

        $insert_status = DB::table('to_do_lists')->insert([
            'user_id' => $user->id,
            'date' => $request->input('task_date'),
            'project_name' => $request->input('project_name'),
            'task' => $request->input('task_name'),
            'hours' => $request->input('hours'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($insert_status) {
            return redirect()->route('user.homepage')->with('success', 'Task saved successfully!');
        } else {
            return redirect()->route('user.homepage')->with('error', 'Task not saved successfully!');
        }
    }
}
