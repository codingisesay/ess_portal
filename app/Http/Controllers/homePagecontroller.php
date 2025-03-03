<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class homePagecontroller extends Controller
{
    public function showHomepage()
    {
        $user = Auth::user(); // Get the logged-in user

        // Fetch the login logs for today
        $logs = LoginLog::whereDate('login_time', today())
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
}
