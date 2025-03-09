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

    // Fetch to-do list
    $toDoList = DB::table('to_do_lists')
                  ->where('user_id', $user->id)
                  ->get();
// Fetch the leave types with restrictions
$leaveTypes = DB::table('leave_types')
                ->join('leave_type_restrictions', 'leave_types.id', '=', 'leave_type_restrictions.leave_type_id')
                ->where('leave_types.status', 'ACTIVE')
                ->get();

// Fetch the applied leaves for the logged-in user (only approved leaves)
$appliedLeaves = DB::table('leave_applies')
                   ->join('leave_apply_statuses', 'leave_applies.id', '=', 'leave_apply_statuses.leave_apply_id')
                   ->where('leave_applies.user_id', $user->id)
                   ->where('leave_apply_statuses.leave_approve_status', 'APPROVED')
                   ->get();

// Calculate total taken leaves for each leave type
$leaveUsage = [];
foreach ($leaveTypes as $leaveType) {
    $totalLeave = $leaveType->max_leave; // Available leave
    $takenLeave = 0;

    // Full-day leave calculation
    foreach ($appliedLeaves as $leave) {
        if ($leave->leave_type_id == $leaveType->id) {
            $leaveDuration = Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;
            $takenLeave += $leaveDuration;
        }
    }

    // Half-day leave calculation
    $halfDayLeaves = DB::table('leave_applies')
        ->where('user_id', $user->id)
        ->where('leave_type_id', $leaveType->id)
        ->whereIn('half_day', ['first half', 'second half'])  // Checking for first or second half
        ->where('leave_approve_status', 'APPROVED')  // Only approved half-day leaves
        ->count();  // Count the number of half-day leaves

    // Subtract 0.5 for each half-day leave from the total taken leave
    $takenLeave -= $halfDayLeaves * 0.5;

    // Apply restrictions for carry forward and leave encashment (optional, depending on your requirements)
    $noCarryForward = $leaveType->no_carry_forward; // No carry forward flag
    $noLeaveEncash = $leaveType->no_leave_encash;  // No leave encashment flag

    // Calculate the remaining leaves
    $remainingLeave = max(0, $totalLeave - $takenLeave); // Ensure no negative remaining leaves

    // Calculate the percentage of leave used
    $percentage = min(100, ($takenLeave / $totalLeave) * 100); 

    // Directly determine the progress bar color in the controller
    if ($percentage >= 80) {
        $progressColor = 'red'; // 80% or more
    } elseif ($percentage >= 50) {
        $progressColor = 'orange'; // Between 50% and 80%
    } else {
        $progressColor = 'green'; // Less than 50%
    }

    // Store the data for display
    $leaveUsage[] = [
        'leaveType' => $leaveType->name,
        'maxLeave' => $totalLeave,
        'takenLeave' => $takenLeave,
        'remainingLeave' => $remainingLeave,
        'percentage' => $percentage,
        'progressColor' => $progressColor, // The color is directly calculated here
        'noCarryForward' => $noCarryForward,
        'noLeaveEncash' => $noLeaveEncash,
    ];
}
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
    return view('user_view.homepage', compact('logs', 'thoughtOfTheDay', 'newsAndEvents', 'upcomingBirthdays', 'anniversaries', 'toDoList', 'currentMonth', 'currentDay', 'leaveUsage', 'appliedLeaves'));
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
