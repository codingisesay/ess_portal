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
    $title = 'Dashboard';

    // Fetch the login logs for today
    $logs = DB::table('login_logs')
              ->whereDate('login_time', today())
              ->where('user_id', $user->id)
              ->get();

    // Fetch additional data
    $thoughtOfTheDay = DB::table('thought_of_the_days')
                         ->where('organisation_id', $user->organisation_id)
                         ->where('creationDate',today())
                         ->get();

$newsAndEvents = DB::table('news_and_events')
                   ->where('organisation_id', $user->organisation_id)
                   ->where('enddate', '>=', today()) // Corrected this line
                   ->orderBy('startdate', 'desc')
                   ->get();

    // Fetch to-do list
    
    $toDoList = DB::table('to_do_lists')
                  ->where('user_id', $user->id)
                  ->where('status', 'pending')
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
        ->join('organisation_designations','emp_details.designation','=','organisation_designations.id')
        ->leftjoin('user_status_imgs','emp_details.user_id','=','user_status_imgs.user_id')
        ->select('emp_details.employee_name as employee_nme', 'date_of_birth', 'organisation_designations.name as designation_name','user_status_imgs.*')
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

        // dd($upcomingBirthdays);

        //Fetch Today Birthday

        $todayBirthdays = DB::table('emp_details')
        ->join('organisation_designations','emp_details.designation','=','organisation_designations.id')
        ->leftjoin('user_status_imgs','emp_details.user_id','=','user_status_imgs.user_id')
        ->select('emp_details.employee_name as employee_nme', 'date_of_birth', 'organisation_designations.name as designation_name','user_status_imgs.*')
        ->whereDay('date_of_birth', '=', $currentDay)
        ->get()
        ->map(function ($employee) use ($currentDay, $currentDate) {
            $birthDate = new Carbon($employee->date_of_birth);
            $birthDay = $birthDate->day;
            $employee->age = $birthDate->age;
            $employee->badgeText = $birthDay === $currentDay ? "Today" : "Upcoming in " . ($birthDay - $currentDay) . " days";
            return $employee;
        });

        // dd($todayBirthdays);

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

       // Fetch data from emp_details with respect to manager
$dataOfteamMambers = DB::table('emp_details')->where('reporting_manager', '=', $user->id)->get();

// Initialize the leave lists array
$leaveLists = array();

for ($teamMamber = 0; $teamMamber < $dataOfteamMambers->count(); $teamMamber++) {
    $leaveApply = DB::table('leave_applies')
        ->join('leave_types', 'leave_applies.leave_type_id', '=', 'leave_types.id')
        ->join('emp_details', 'leave_applies.user_id', '=', 'emp_details.user_id')
        ->select(
            'leave_applies.start_date as leave_start_date', 'leave_applies.end_date as leave_end_date', 
            'leave_applies.description as leave_resion', 'leave_applies.id as leave_appliy_id',
            'leave_types.name as leave_name', 'emp_details.employee_no as employee_no', 
            'emp_details.employee_name as employee_name'
        )
        ->where('leave_applies.user_id', '=', $dataOfteamMambers[$teamMamber]->user_id)
        ->whereIn('leave_applies.leave_approve_status', ['Pending', 'Rejected'])
        ->get();

    // Add the retrieved leave apply data to the leaveLists array
    array_push($leaveLists, $leaveApply);
}

     
       

       
       


        // dd($anniversaries);

    // Return a view with the logs and additional data
    return view('user_view.homepage', compact('title','logs', 'thoughtOfTheDay', 'newsAndEvents', 'upcomingBirthdays','todayBirthdays', 'anniversaries', 'toDoList', 'currentMonth', 'currentDay', 'leaveUsage', 'appliedLeaves','leaveLists'));
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

    public function updateToDo(Request $request, $id){

        $request->validate([
            'status' => 'required',
        ]);


        $status = DB::table('to_do_lists')
        ->where('id', $id)
        ->update(['status' => $request->status]);

        if($status){

            return redirect()->route('user.homepage')->with('success', 'Status updated successfully!');

        }else{

            return redirect()->route('user.homepage')->with('error', 'Status Not updated successfully!');

        }

   

    }

    public function updateLeaveStatus($id, $status){
        $user = Auth::user();
          
    $update = DB::table('leave_applies')
    ->where('id', $id)
    ->update([
        'leave_approve_status' => $status, // Set the leave status
        'status_updated_by' => $user->id, // Set the user who updated the status
        'status_update_date_time' => NOW() // Set the current datetime (updated_at column should exist in the table)
    ]);


if ($update) {
    return redirect()->route('user.homepage')->with('success', 'Leave status updated successfully.');
}else{

    return redirect()->route('user.homepage')->with('error', 'Leave status not updated successfully.');

}


    }

}
