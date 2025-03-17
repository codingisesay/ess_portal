<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use App\Models\ToDoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\EmailService;
use Carbon\Carbon;

class homePagecontroller extends Controller
{

    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

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
                  
//fetch for leave representation

                  $total_leaves_of_org = DB::table('leave_types')
                  // ->join('leave_types', 'leave_type_restrictions.leave_type_id', '=', 'leave_types.id')
                  ->join('leave_cycles', 'leave_types.leave_cycle_id','=', 'leave_cycles.id')
                  ->select('leave_types.name as leave_type','leave_types.id as leave_type_id') // Select all columns from both tables
                  ->where('leave_cycles.organisation_id', '=', $user->organisation_id)
                  ->where('leave_cycles.status', '=', 'Active')
                  ->where('leave_types.status', '=', 'Active')
                  ->get();

                // dd($total_leaves_of_org);

// Fetch the applied leaves for the logged-in user (only approved leaves)
$approvedleave = DB::table('leave_applies')
                   ->where('leave_applies.user_id', $user->id)
                   ->where('leave_applies.leave_approve_status', 'Approved')
                   ->get();

                   $emp_details = DB::table('emp_details')->where('user_id',$user->id)->first();


                //    dd($appliedLeaves);


// Calculate total taken leaves for each leave type
$leaveUsage = [];

for($leave_type = 0; $leave_type < $total_leaves_of_org->count(); $leave_type++){

    $leave_single_data = [];

    array_push($leave_single_data,$total_leaves_of_org[$leave_type]->leave_type);

    if($emp_details->employee_type == 1){

        $leave_restriction = DB::table('leave_type_restrictions')
        ->select('max_leave')
        ->where('leave_type_id','=',$total_leaves_of_org[$leave_type]->leave_type_id)->first();
        array_push($leave_single_data,$leave_restriction->max_leave);
        // $percentage = $takenLeave*100/$leave_restriction->max_leave;

    }elseif($emp_details->employee_type == 2){

        $leave_res = DB::table('leave_type_restrictions')
        ->select('id')
        ->where('leave_type_id','=',$total_leaves_of_org[$leave_type]->leave_type_id)->first();

        $leave_restrictionforemp = DB::table('leave_type_emp_categories')
        ->select('leave_count')
        ->where('leave_restriction_id',$leave_res->id)->first();
        array_push($leave_single_data,$leave_restrictionforemp->leave_count);
        // $percentage = $takenLeave*100/$leave_restrictionforemp->leave_count;

    }

    $leaveCountArray = DB::table('leave_applies')
    ->where('leave_type_id',$total_leaves_of_org[$leave_type]->leave_type_id)
    ->where('user_id',$user->id)
    ->where('leave_approve_status','Approved')
    ->get();

    $takenLeave = 0;

for ($i = 0; $i < $leaveCountArray->count(); $i++) {

    if ($leaveCountArray[$i]->half_day == 'First Half' || $leaveCountArray[$i]->half_day == 'Second Half') {

        $leaveCount = 0.5; // Half-day leave

    } elseif($leaveCountArray[$i]->half_day == 'Full Day') {

        $leaveCount = 1;
    
    }else{

            // Calculate the difference in days
            $startDate = new \DateTime($leaveCountArray[$i]->start_date);
            $endDate = new \DateTime($leaveCountArray[$i]->end_date);
    
            $dateDiff = $startDate->diff($endDate);
    
    
            // Extract the total days from the DateInterval object and add 1 (if end_date is the same day)
            $leaveCount = $dateDiff->days;

    }

    // Add the leave count to the total taken leave
    $takenLeave += $leaveCount;
}

//calculate percentage

// $leave_restriction->max_leave*x/100=$takenLeave;

if($emp_details->employee_type == 1){

    $percentage = $takenLeave*100/$leave_restriction->max_leave;

    $roundPer = round($percentage, 2);

}elseif($emp_details->employee_type == 2){


    $percentage = $takenLeave*100/$leave_restrictionforemp->leave_count;

    $roundPer = round($percentage, 2);

}

//pushing taken leave of this leave type
    array_push($leave_single_data,$takenLeave);
//pushing percentage
    array_push($leave_single_data,$roundPer);
//pushing sub array to main array
    array_push($leaveUsage,$leave_single_data);

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
    return view('user_view.homepage', compact('title','logs', 'thoughtOfTheDay', 'newsAndEvents', 'upcomingBirthdays','todayBirthdays', 'anniversaries', 'toDoList', 'currentMonth', 'currentDay', 'leaveUsage','leaveLists'));
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

    $leave_apply = DB::table('leave_applies')
    ->where('id','=',$id)
    ->first();

    $apply_leaveuser_data = DB::table('users')->where('id','=',$leave_apply->user_id)->first();

    $leave_type = DB::table('leave_types')
    ->select('name')
    ->where('id','=',$leave_apply->leave_type_id)
    ->first();

    if($status == 'Approved'){

        $subject = 'Leave Approved- '.$leave_type->name;

    }elseif($status == 'Reject'){

        $subject = 'Leave Rejected- '.$leave_type->name;

    }
    // $subject = 'Leave Application Submitted '.$leave_type->name;
    $org_id = $user->organisation_id;
    $mail_flag = "leave_approve_status";

    $data = [
        'username' => $apply_leaveuser_data->email,
        'name' => $apply_leaveuser_data->name,
        'leave_type' => $leave_type->name,
        'start_date' => $leave_apply->start_date,
        'end_date' => $leave_apply->end_date,
        'leave_status' => $status,
        'approved_by' => $user->name,
    ];

    // dd($subject);

//    Mail::to($user_create->email)->send(new UserRegistrationMail($user_create->email, $request->userpassword));
   $this->emailService->sendEmailWithOrgConfig($org_id,$subject,$mail_flag,$data);

    return redirect()->route('user.homepage')->with('success', 'Leave status updated successfully.');

}else{

    return redirect()->route('user.homepage')->with('error', 'Leave status not updated successfully.');

}


    }

}
