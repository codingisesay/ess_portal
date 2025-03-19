<?php

namespace App\Http\Controllers;
use App\Models\leaveCycle;
use App\Models\leaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
// use Carbon\Carbon;
use App\Services\EmailService;
use App\Models\User;
use App\Mail\UserRegistrationMail;
use Carbon\Carbon;
use DateTime;



class leavePolicyController extends Controller
{

    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    //superadmin end
    public function loadPolicyTimeSlot(){
        $id = Auth::guard('superadmin')->user()->id;
        $leaveCycleDatas = leaveCycle::where('organisation_id', $id)->get();
        return view('superadmin_view.create_leave_slot',compact('leaveCycleDatas'));
    }

    public function insertPolicyTimeSlot(Request $request){
        $data = $request->validate([
            'cycle_name' => 'required',
            'start_date_time' => 'required',
            'end_date_time' => 'required',
            'year_slot' => 'required',
        ]);

        $id = Auth::guard('superadmin')->user()->id;

        // dd($data);

        $status = DB::table('leave_cycles')->insert([
            'name' => $data['cycle_name'],
            'start_date' => $data['start_date_time'],
            'end_date'=> $data['end_date_time'],
            'organisation_id'=> $id,
            'year'=> $data['year_slot'],
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);

        if($status){

            return redirect()->route('create_policy_time_slot')->with('success', 'Record Inserted successfully!');

        }else{

            return redirect()->route('create_policy_time_slot')->with('error', 'Record Not Inserted successfully!');

        }



    }

    public function loadPolicyType(){
        $id = Auth::guard('superadmin')->user()->id;

       
        // $results = DB::table('emp_details')
        // ->join('employee_types', 'emp_details.employee_type', '=', 'employee_types.id')
        // ->select('emp_details.employee_type as employee_type','employee_types.name as employee_type_name','emp_details.employee_no as employee_no','emp_details.employee_name as employee_name');
 
        $results = DB::table('leave_types')
                   ->join('leave_cycles', 'leave_types.leave_cycle_id', '=', 'leave_cycles.id')
                   ->select('leave_types.name as leave_type','leave_types.half_day as leave_half_status','leave_types.status as leave_status','leave_types.id as leave_type_id', 'leave_cycles.name as leave_cycle_name','leave_cycles.id as leave_cycle_id','leave_cycles.organisation_id as leave_cycle_organisation_id') // Select all columns from both tables
                   ->where('leave_cycles.organisation_id', '=', $id)
                   ->get();

    // dd($results);



        $leaveCycleDatas = leaveCycle::where('organisation_id', $id)->get();
        return view('superadmin_view.create_leave_type',compact('leaveCycleDatas','results'));
    }

    public function insertPolicyType(Request $request){

        $data = $request->validate([
            'cycle_slot_id' => 'required',
            'leave_category' => 'required',
            'half_day_status' => 'required',
            'status' => 'required',
        ]);

        $id = Auth::guard('superadmin')->user()->id;

        // dd($data);

        $status = DB::table('leave_types')->insert([
            'name' => $data['leave_category'],
            'half_day' => $data['half_day_status'],
            'status'=> $data['status'],
            'leave_cycle_id'=> $data['cycle_slot_id'],
            'created_at'=> NOW(),
            'updated_at'=> NOW(),
        ]);

        if($status){

            return redirect()->route('create_policy_type')->with('success', 'Record Inserted successfully!');

        }else{

            return redirect()->route('create_policy_type')->with('error', 'Record Not Inserted successfully!');

        }



    }

    public function loadPolicy(){
        $id = Auth::guard('superadmin')->user()->id;
        $results = DB::table('leave_types')
                   ->join('leave_cycles', 'leave_types.leave_cycle_id', '=', 'leave_cycles.id')
                   ->select('leave_types.name as leave_type','leave_types.half_day as leave_half_status','leave_types.status as leave_status','leave_types.id as leave_type_id', 'leave_cycles.name as leave_cycle_name','leave_cycles.id as leave_cycle_id','leave_cycles.organisation_id as leave_cycle_organisation_id') // Select all columns from both tables
                   ->where('leave_cycles.organisation_id', '=', $id)
                   ->where('leave_types.status', '=', 'Active')
                   ->get();

                   $dataFromLeaveRestctions = DB::table('leave_type_restrictions')
                   ->join('leave_types', 'leave_type_restrictions.leave_type_id', '=', 'leave_types.id')
                   ->join('leave_cycles', 'leave_types.leave_cycle_id','=', 'leave_cycles.id')
                   ->select('leave_types.name as leave_type','leave_type_restrictions.*') // Select all columns from both tables
                   ->where('leave_cycles.organisation_id', '=', $id)
                   ->get();

                //    dd($dataFromLeaveRestctions);

        return view('superadmin_view.create_leave_policy',compact('results','dataFromLeaveRestctions'));
    }


    public function insertPolicyConf(Request $request){

        $data = $request->validate([
            'leave_type_id' => 'required',
            'max_leave_count' => 'required',
            'max_leave_at_time' => 'required',
            'min_leave_at_time' => 'required',

            'is_carry_forward' => 'required',
            'no_of_carry_forward' => 'required',
            'leave_encash' => 'required',
            'leave_encash_count' => 'required',
        ]);

        $id = Auth::guard('superadmin')->user()->id;

        $insertStatus = DB::table('leave_type_restrictions')->where('leave_type_id',$data['leave_type_id'])->get();

        if($insertStatus->count() == 1){

            return redirect()->route('create_policy')->with('error', 'This Policy is alreay created, Please edit same instance!');

        }else{

            $status = DB::table('leave_type_restrictions')->insert([
                'leave_type_id' => $data['leave_type_id'],
                'max_leave' => $data['max_leave_count'],
                'max_leave_at_time'=> $data['max_leave_at_time'],
                'min_leave_at_time'=> $data['min_leave_at_time'],
                'carry_forward'=> $data['is_carry_forward'],
                'no_carry_forward' => $data['no_of_carry_forward'],
                'leave_encash' => $data['leave_encash'],
                'no_leave_encash' => $data['leave_encash_count'],
                'created_at'=> NOW(),
                'updated_at'=> NOW(),
            ]);
    
            if($status){
    
                return redirect()->route('create_policy')->with('success', 'Record Inserted successfully!');
    
            }else{
    
                return redirect()->route('create_policy')->with('error', 'Record Not Inserted successfully!');
    
            }
    

        }

        // dd($insertStatus);

     


    }

    public function loadEmpPolicy(){
        $id = Auth::guard('superadmin')->user()->id;

        
        $dataFroms = DB::table('leave_type_emp_categories')
        ->join('leave_type_restrictions', 'leave_type_emp_categories.leave_restriction_id', '=', 'leave_type_restrictions.id')
        ->join('leave_types', 'leave_type_restrictions.leave_type_id','=', 'leave_types.id')
        ->join('leave_cycles', 'leave_types.leave_cycle_id','=', 'leave_cycles.id')
        ->join('employee_types', 'leave_type_emp_categories.employee_category_id','=', 'employee_types.id')
        ->select('employee_types.name as employee_type','leave_types.name as leave_type','leave_type_restrictions.id as leave_restriction_id','leave_type_emp_categories.*') // Select all columns from both tables
        ->where('leave_cycles.organisation_id', '=', $id)
        ->get();

        // dd($dataFrom);

        $dataFromLeaveRestctions = DB::table('leave_type_restrictions')
        ->join('leave_types', 'leave_type_restrictions.leave_type_id', '=', 'leave_types.id')
        ->join('leave_cycles', 'leave_types.leave_cycle_id','=', 'leave_cycles.id')
        ->select('leave_types.name as leave_type','leave_type_restrictions.id as leave_restriction_id') // Select all columns from both tables
        ->where('leave_cycles.organisation_id', '=', $id)
        ->where('leave_types.status', '=', 'Active')
        ->get();

        $empTypes = DB::table('employee_types')->get();
        // dd($empTypes);
        return view('superadmin_view.employee_policy',compact('dataFromLeaveRestctions','empTypes','dataFroms'));
    }

    public function insertEmpRestriction(Request $request){

        $data = $request->validate([
            'restriction_id' => 'required',
            'emp_id' => 'required',
            'leave_count' => 'required',
            'month_start' => 'required',
        ]);

        $insertStatus = DB::table('leave_type_emp_categories')->where('leave_restriction_id',$data['restriction_id'])->get();

        if($insertStatus->count() == 1){

            return redirect()->route('employee_policy')->with('error', 'This Policy is alreay created, Please edit same instance!');

        }else{

            $status = DB::table('leave_type_emp_categories')->insert([
                'leave_restriction_id' => $data['restriction_id'],
                'employee_category_id' => $data['emp_id'],
                'leave_count'=> $data['leave_count'],
                'month_start'=> $data['month_start'],
                'created_at'=> NOW(),
                'updated_at'=> NOW(),
            ]);
    
            if($status){
    
                return redirect()->route('employee_policy')->with('success', 'Record Inserted successfully!');
    
            }else{
    
                return redirect()->route('employee_policy')->with('error', 'Record Not Inserted successfully!');
    
            }

        }



    }

    //userend

    public function showLeaveDashboard()
    {

        $title = "Leave & Attendance";
        $user = Auth::user();

        // Fetch all leave types from the 'leave_types' table
        $leaveTypes = DB::table('leave_types')
                  // ->join('leave_types', 'leave_type_restrictions.leave_type_id', '=', 'leave_types.id')
                  ->join('leave_cycles', 'leave_types.leave_cycle_id','=', 'leave_cycles.id')
                  ->select('leave_types.name as leave_type','leave_types.id as leave_type_id') // Select all columns from both tables
                  ->where('leave_cycles.organisation_id', '=', $user->organisation_id)
                  ->where('leave_cycles.status', '=', 'Active')
                  ->where('leave_types.status', '=', 'Active')
                  ->get();

                //   dd($leaveTypes);
    
        // Calculate total working hours for the current user
        $workingHoursData = $this->calculateWorkingHours($user->id); // Get working hours data
    
        // Fetch applied leaves for the logged-in user (including approved, pending, and rejected)
        $appliedLeaves = DB::table('leave_applies')
            ->where('user_id', $user->id)
            ->get(); 

    // dd($appliedLeaves);

    $emp_details = DB::table('emp_details')->where('user_id',$user->id)->first();

    $leaveSummary = [];
        foreach ($leaveTypes as $leaveType) {

            $leave_single_data['leave_type'] = $leaveType->leave_type;

            $restriction = DB::table('leave_type_restrictions')
                ->where('leave_type_id', $leaveType->leave_type_id)
                ->first();
            
            if($emp_details->employee_type == 1){

                $maxLeave = $restriction->max_leave;

                $leave_single_data['leave_type'] = $maxLeave;

            }elseif($emp_details->employee_type == 2){

                $leave_res = DB::table('leave_type_restrictions')
                ->select('id')
                ->where('leave_type_id','=',$leaveType->leave_type_id)->first();
        
                $leave_restrictionforemp = DB::table('leave_type_emp_categories')
                ->select('leave_count')
                ->where('leave_restriction_id',$leave_res->id)->first();

                $maxLeave = $leave_restrictionforemp->leave_count;

                $leave_single_data['leave_type'] = $maxLeave;


            }
            //carry Forward
            $no_carry_forward = $restriction->no_carry_forward;
            $leave_single_data['no_carry_forward'] = $no_carry_forward;

            //Leave Encash
            $no_leave_encash = $restriction->no_leave_encash;
            $leave_single_data['no_leave_encash'] = $no_leave_encash;


            $leaveCountArray = DB::table('leave_applies')
            ->where('leave_type_id',$leaveType->leave_type_id)
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

        $leave_single_data['consumed_leaves'] = $takenLeave;

        $remainingLeaves = $maxLeave - $takenLeave;
          
            $leave_single_data = [
                'leave_type' => $leaveType->leave_type,
                'total_leaves' => $maxLeave,
                'no_carry_forward' => $no_carry_forward,
                'no_leave_encash' => $no_leave_encash,
                'consumed_leaves' => $takenLeave,
                'remaining_leaves' => $remainingLeaves,
            ];

          
    
          array_push($leaveSummary,$leave_single_data); 
        }

        // dd($leaveSummary);

        //Load upcoming holidays

         // Fetch upcoming and today's birthdays
         $currentDate = Carbon::now();
         $currentMonth = $currentDate->month;
         $currentDay = $currentDate->day;
         
         $holidays_upcoming = DB::table('calendra_masters')
             ->select('date', 'holiday_name', 'day')
             ->where('holiday', '=', 'Yes')
             ->whereMonth('date', '=', $currentMonth) // Filter by the current month
             ->whereDay('date', '>=', $currentDay)   // Filter by day of the month in 'date'
             ->get();

             $holidays_upcoming = $holidays_upcoming->map(function ($holiday) {
                // Format the date to '19-March'
                $holiday->formatted_date = Carbon::parse($holiday->date)->format('d F'); 
                return $holiday;
            });
         
        //  dd($holidays_upcoming);

        // attendence  rate query start
        // ---------------------------- Attendance rate ----------------------------
        
        
        $userId = auth()->id();  // Get the current authenticated user's ID

        // Get the start and end date for the current month
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();
        
        // Query to get the distinct login dates for the user within the current month
        $presentDaysQuery = DB::table('login_logs')
            ->where('user_id', $userId)
            ->whereBetween('login_date', [$startOfMonth, $endOfMonth])
            ->select('login_date')
            ->groupBy('login_date');
        
        // Join with calendar_masters table to get the holiday and week_off information
        $calendarData = DB::table('calendra_masters')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->select('date', 'week_off', 'holiday')
            ->get()
            ->keyBy('date'); // Convert the result into an associative array with date as the key
        
        // Count the number of present days considering holidays and week-offs
        $presentDays = $presentDaysQuery->get()->filter(function ($login) use ($calendarData) {
            $loginDate = $login->login_date;
            
            // Check if the user logged in on a holiday or week-off
            if (isset($calendarData[$loginDate])) {
                $calendar = $calendarData[$loginDate];
        
                // If it's a holiday or week-off, the user isn't absent even if they didn't log in
                if ($calendar->holiday == 'YES' || $calendar->week_off == 'YES') {
                    return true;
                }
            }
            
            // If not a holiday or week-off, the user is present if they logged in
            return true;
        })->count();
        
        // Total days in the current month
        $totalDaysInMonth = now()->daysInMonth;
        
        // Calculate absent days (total days in month - present days)
        $absentDays = $totalDaysInMonth - $presentDays;
        
        // Calculate the attendance rate
        $attendanceRate = ($totalDaysInMonth > 0) ? round(($presentDays / $totalDaysInMonth) * 100, 2) : 0;

       // ---------------------------- Attendance Overview ----------------------------

$userId = auth()->id();  // Get the current authenticated user's ID

// Get the start and end date for the current year
$startOfYear = now()->startOfYear()->toDateString();
$endOfYear = now()->endOfYear()->toDateString();

// Step 1: Collect all login/logout entries of the user within the year
$userLogins = DB::table('login_logs')
    ->where('user_id', $userId)
    ->whereBetween('login_date', [$startOfYear, $endOfYear])
    ->select('login_date', 'login_time')
    ->get();

// Step 2: Collect the working start and end times, holidays, and week offs
$workSchedule = DB::table('calendra_masters')
    ->whereBetween('date', [$startOfYear, $endOfYear])
    ->select('date', 'working_start_time', 'working_end_time', 'week_off', 'holiday')
    ->get();

// Convert workSchedule into an associative array for easy lookup
$workScheduleArray = [];
foreach ($workSchedule as $workDay) {
    $workScheduleArray[$workDay->date] = [
        'working_start_time' => $workDay->working_start_time,
        'working_end_time' => $workDay->working_end_time,
        'week_off' => $workDay->week_off,
        'holiday' => $workDay->holiday,
    ];
}

// Initialize attendance counters for each month
$attendanceOverview = [];
foreach (range(1, 12) as $month) {
    $attendanceOverview[$month] = [
        'on_time' => 0,
        'late' => 0,
        'absent' => 0,
    ];
}

// Convert userLogins into an associative array for quick lookup
$userLoginArray = [];
foreach ($userLogins as $login) {
    $userLoginArray[$login->login_date] = $login->login_time;
}

// Process each day in the work schedule
foreach ($workScheduleArray as $date => $details) {
    $month = \Carbon\Carbon::parse($date)->month;
    
    // Skip if it's a holiday or week off
    if ($details['holiday'] == 'YES' || $details['week_off'] == 'YES') {
        continue;
    }
    
    // Check if user has a login entry for this date
    if (isset($userLoginArray[$date])) {
        $loginTime = \Carbon\Carbon::parse($userLoginArray[$date]);
        $startOfDay = \Carbon\Carbon::parse($date . ' ' . $details['working_start_time']);
        
        // Determine if the user was on time or late
        if ($loginTime <= $startOfDay) {
            $attendanceOverview[$month]['on_time']++;
        } else {
            $attendanceOverview[$month]['late']++;
        }
    } else {
        // User did not log in and it's not a holiday or week off, mark as absent
        $attendanceOverview[$month]['absent']++;
    }
}
    
        // Pass the leave summary data, applied leaves, and total working hours to the view
        return view('user_view.leave_dashboard', compact('leaveSummary', 'workingHoursData', 'appliedLeaves','title','holidays_upcoming', 'attendanceRate', 'presentDays', 'absentDays', 'totalDaysInMonth', 'attendanceOverview'));
    }


private function calculateWorkingHours($userId)
{
    $loginLogs = DB::table('login_logs')
        ->where('user_id', $userId)
        ->whereNotNull('logout_time')  // Only consider logs with valid logout times
        ->orderBy('login_date', 'desc')  // Sort by login_date in descending order (latest first)
        ->take(7)  // Get only the last 7 records
        ->get()
        ->reverse();

    // Arrays to store dates and calculated hours
    $workingHours = [];
    $totalHours = 0;

    foreach ($loginLogs as $log) {
        // Calculate the difference between login and logout times
        $loginTime = new \Carbon\Carbon($log->login_time);
        $logoutTime = new \Carbon\Carbon($log->logout_time);

        // Calculate the total working hours
        $workedHours = $logoutTime->diffInHours($loginTime) + ($logoutTime->minute / 60 - $loginTime->minute / 60);

        // Add to the total hours worked
        $totalHours += $workedHours;

        // Store individual working hours data with the formatted date (dd:mm:yy)
        $workingHours[] = [
            'date' => $loginTime->format('d/m/y'), // Format the date as dd:mm:yy
            'worked_hours' => number_format($workedHours, 2) // Format worked hours to 2 decimal places
        ];
    }

    // Calculate average working hours
    $averageWorkingHours = count($workingHours) > 0 ? $totalHours / count($workingHours) : 0;

    return [
        'working_hours' => $workingHours,
        'average_working_hours' => number_format($averageWorkingHours, 2) // Format average to 2 decimal places
    ];
}


    
    
    public function showLeaveRequest(){
        $loginUserInfo = Auth::user();

        $datas = DB::table('leave_types')
        // ->join('leave_types', 'leave_type_restrictions.leave_type_id', '=', 'leave_types.id')
        ->join('leave_cycles', 'leave_types.leave_cycle_id','=', 'leave_cycles.id')
        ->select('leave_types.name as leave_type','leave_types.id as leave_type_id') // Select all columns from both tables
        ->where('leave_cycles.organisation_id', '=', $loginUserInfo->organisation_id)
        ->where('leave_cycles.status', '=', 'Active')
        ->where('leave_types.status', '=', 'Active')
        ->get();
        
        // dd($data);
        return view('user_view.leave_request',compact('loginUserInfo','datas'));
    }

    public function fetchRemainingLeave($leave_id){
        $loginUserInfo = Auth::user();
        $emp_details = DB::table('emp_details')->where('user_id',$loginUserInfo->id)->get();

        $leave_restriction = DB::table('leave_type_restrictions')->where('leave_type_id',$leave_id)->get();
        $leave_restrictionforemp = DB::table('leave_type_emp_categories')->where('leave_restriction_id',$leave_restriction[0]->id)->get();

        $leaveCountArray = DB::table('leave_applies')
        ->where('leave_type_id',$leave_id)
        ->where('user_id',$loginUserInfo->id)
        ->where('leave_approve_status','Approved')
        ->get();



$takenLeave = 0;

for ($i = 0; $i < $leaveCountArray->count(); $i++) {
    // Convert the start_date and end_date to DateTime objects
    

    // Check if the leave is a full day or half day
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
            $leaveCount = $dateDiff->days + 1;

    }

    // Add the leave count to the total taken leave
    $takenLeave += $leaveCount;
}

// dd($takenLeave);

        if($emp_details[0]->employee_type == 1){

            $remaning_leave = $leave_restriction[0]->max_leave - $takenLeave;

        }elseif($emp_details[0]->employee_type == 2){

            $remaning_leave = $leave_restrictionforemp[0]->leave_count - $takenLeave;

        }

        // dd($emp_details[0]->employee_type);
  

    return response()->json([
        'remaining_leave' => $remaning_leave,  // This is the data you will send back to the front-end
    ]);
    }

    public function fetchStatusHalfDay($leave_id,$start_date,$end_date){
      if($start_date == $end_date){

        return response()->json([
            'half_day_status' => 'block',  // This is the data you will send back to the front-end
        ]);

      }

        
    

    }

    public function insertLeave(Request $request){

        $data = $request->validate([
            'employee_no' => 'required',
            'employee_name' => 'required',
            'leave_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
            'leave_slot' => '',
        ]);

        // dd($data);
        $loginUserInfo = Auth::user();

        try {

            $leave_type = DB::table('leave_types')
            ->select('name')
            ->where('id','=',$data['leave_type'])
            ->first();
            // Try to insert or update the record
            $status = DB::table('leave_applies')->insert([
                'leave_type_id' => $data['leave_type'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'user_id' => $loginUserInfo->id,
                'description' => $data['reason'],
                'apply_date' => date('Y-m-d'),
                'half_day' => $data['leave_slot'],
                'created_at' => NOW(),
                'updated_at' => NOW(),
    
            ]);

            if($status){

                $fetchManager = DB::table('emp_details')
                ->join('users','emp_details.reporting_manager','=','users.id')
                ->select('users.email as manager_mail_id','users.name as manager_name')
                ->where('emp_details.user_id','=',$loginUserInfo->id)
                ->first();
                // dd($fetchManager);
                $mail_to = [];
                $mail_cc = [];

                        // Convert start and end dates to DateTime objects
$startDate = new DateTime($data['start_date']);
$endDate = new DateTime($data['end_date']);

// Calculate the difference between the two dates
$interval = $startDate->diff($endDate);

// Get the number of days from the difference
$daysBetween = $interval->days+1;

if($data['leave_slot'] == 'First Half' || $data['leave_slot'] == 'Second Half'){

    $halfDay = 0.5;
    
    $subject = $data['leave_slot'].' Leave Application Submitted - '.$leave_type->name.' - '.$halfDay.' day';

}elseif($data['leave_slot'] == 'Full Day'){

    $fullday = 1;

    $subject = $data['leave_slot'].' Leave Application Submitted - '.$leave_type->name.' - '.$fullday.' day';

}else{

    $subject = 'Leave Application Submitted - '.$leave_type->name.' - '.$daysBetween.' days';

}

                // $subject = 'Leave Application Submitted '.$leave_type->name.' - '.$daysBetween.' days';

                $org_id = $loginUserInfo->organisation_id;
                $mail_flag = "applied_leave";

                array_push($mail_to,$fetchManager->manager_mail_id);
                array_push($mail_cc,$loginUserInfo->email);



                $data = [
                    'username' => $mail_to, //mail to
                    'cc' => $mail_cc, 
                    'managername' => $fetchManager->manager_name,
                    'employeename' => $loginUserInfo->name,
                    'leave_type' => $leave_type->name,
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'org_id' => $loginUserInfo->organisation_id,
                ];

                // dd($data);
          
            //    Mail::to($user_create->email)->send(new UserRegistrationMail($user_create->email, $request->userpassword));
               $this->emailService->sendEmailWithOrgConfig($org_id,$subject,$mail_flag,$data);

                return redirect()->route('leave_dashboard')->with('success', 'You have applied leave successfully!');
    
            }

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                // Handle duplicate key error
                return redirect()->route('leave_dashboard')->with('error', 'Error while applying leave,It may Possible that you have applied same day leave alreay!');
            }
            throw $e; // re-throw the error if it's not a unique constraint violation
        }

       

        // dd($data);

    }
}