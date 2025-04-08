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
            'leave_count_per_month' => 'required',
            'no_of_leaves_per_month' => 'required',
            'is_carry_forward' => 'required',
            'no_of_carry_forward' => 'required',
            'leave_encash' => 'required',
            'leave_encash_count' => 'required',

            'provision_status' => 'required',
            'max_leave_pp' => 'required',
            'probation_period_per_month' => 'required',
            'calendra_start_for_PP' => 'required',
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

                'leave_count_per_month' =>$data['leave_count_per_month'],
                'no_of_time_per_month' =>$data['no_of_leaves_per_month'],

                'carry_forward'=> $data['is_carry_forward'],
                'no_carry_forward' => $data['no_of_carry_forward'],
                'leave_encash' => $data['leave_encash'],
                'no_leave_encash' => $data['leave_encash_count'],


                'provision_status'=> $data['provision_status'],
                'max_leave_PP' => $data['max_leave_pp'],
                'provision_period_per_month' => $data['probation_period_per_month'],
                'calendra_start_for_PP' => $data['calendra_start_for_PP'],

                'created_at'=> NOW(),
                'updated_at'=> NOW(),
            ]);
    
            if($status){
    
                return redirect()->route('create_policy')->with('success', 'Record Inserted successfully!');
    
            }
    
                return redirect()->route('create_policy')->with('error', 'Record Not Inserted successfully!');

    

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

            // $emp_details = DB::table('emp_details')->where('user_id',$user->id)->get();
            // dd($emp_details);
    
            $leave_restriction = DB::table('leave_type_restrictions')->where('leave_type_id',$leaveType->leave_type_id)->first();
            // dd($leave_restriction);

            if (!$leave_restriction) {
                // Skip the current leave type or set defaults
                continue; // This will skip the current iteration in the loop
            }

            $leaveCycyle = DB::table('leave_cycles')
            ->where('organisation_id' ,'=', $user->organisation_id)
            ->where('status', '=', 'Active')
            ->first();
    
            // dd($leaveCycyle);
            $leaceCycleStartDate = $leaveCycyle->start_date;
            $leaceCycleEndtDate = $leaveCycyle->end_date;
            $provision_period = $emp_details->provision_period;
            $Joining_date = $emp_details->Joining_date;
            $JDC = Carbon::create($Joining_date); 
            $calendra_start = $leave_restriction->calendra_start_for_PP;
            $date = Carbon::create($Joining_date);
            $provision_period_till = $date->addMonths($provision_period);  
            $PPdate = $provision_period_till->toDateString();  
            
            $today = Carbon::today();
    
            $leaveCountArray = DB::table('leave_applies')
            ->where('leave_type_id',$leaveType->leave_type_id)
            ->where('user_id',$user->id)
            ->where('leave_approve_status','Approved')
            ->get();
    
    
    $leaceCycleEndtDate = Carbon::create($leaceCycleEndtDate);  // Cycle End date: 2026-03-31 10:52:00
    $leaceCycleStartDate = Carbon::create($leaceCycleStartDate);
    
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
                $leaveCount = $dateDiff->days + 1;
    
        }
    
        $takenLeave += $leaveCount;
    }
    $currentYear = Carbon::now()->year; 


    if($leave_restriction->provision_status == 'Not Applicable'){
        $remaning_leave = $leave_restriction->max_leave - $takenLeave;
        $leave_single_data = [
            'leave_type' => $leaveType->leave_type,
            'total_leaves' => $leave_restriction->max_leave,
            'no_carry_forward' => $leave_restriction->no_carry_forward,
            'no_leave_encash' => $leave_restriction->no_leave_encash,
            'consumed_leaves' => $takenLeave,
            'remaining_leaves' => $remaning_leave,
        ];

      

      array_push($leaveSummary,$leave_single_data); 
    }else{
    
    if($emp_details->provision_period_year == 1){
    
        //code for year cycle date of joining [joining year]
    
        // Calculate the difference in months
     $months = $JDC->diffInMonths($leaceCycleEndtDate);
    
     // Check if there's any partial month remaining after full months
     if ($JDC->copy()->addMonths($months)->isBefore($leaceCycleEndtDate)) {
         $months++;  // If there is a partial month, add it
     }
    
        $total_leave = 0;
        
        $leavemonthwithoutPP = $months - $provision_period;
    
        $total_leave = $leavemonthwithoutPP*$leave_restriction[0]->leave_count_per_month;
    
        $total_leave = $total_leave + ($provision_period*$leave_restriction[0]->provision_period_per_month);
    
        if ($JDC->day > $calendra_start) {
    
            $total_leave = $total_leave - $leave_restriction[0]->provision_period_per_month;
         
         }

         $carry_forward = $leave_single_data['no_carry_forward'] = 0;
        $leave_encash = $leave_single_data['no_leave_encash'] = 0;
    
    }else if($emp_details->provision_period_year == 2){
    
        //if provision period extent to next cycyle
    
        $months = $leaceCycleStartDate->diffInMonths($leaceCycleEndtDate);
    
     
     if ($leaceCycleStartDate->copy()->addMonths($months)->isBefore($leaceCycleEndtDate)) {
         $months++;  
     }
    
     $remaning_pp_months = $leaceCycleStartDate->diffInMonths($provision_period_till);
    
     if ($leaceCycleStartDate->copy()->addMonths($remaning_pp_months)->isBefore($provision_period_till)) {
        $remaning_pp_months++; 
    }
    
    $leavemonthwithoutPP = $months - $remaning_pp_months;
    
    $total_leave = $leavemonthwithoutPP*$leave_restriction->leave_count_per_month;
    
    $total_leave = $total_leave + ($remaning_pp_months*$leave_restriction->provision_period_per_month);
    
    $user_leave_encash_carries = DB::table('user_leave_encash_carries')
    ->where('user_id',$user->id)
    ->where('leave_type_map_with',$leaveType->leave_type_id)
    ->first();
    
    if (!$user_leave_encash_carries) {

        $total_leave = $total_leave + 0;
    
        $carry_forward = 0;
        $leave_encash = 0;
    
       
       
    }else{
    
        $total_leave = $total_leave + $user_leave_encash_carries->carry_forward;
    
        $carry_forward = $user_leave_encash_carries->carry_forward;
        $leave_encash = $user_leave_encash_carries->leave_encash;
    
    
    }
  
    
    
    }else{
    
        //without provision period

        $total_leave = $leave_restriction->max_leave;
    
        $user_leave_encash_carries = DB::table('user_leave_encash_carries')
                                     ->where('user_id',$user->id)
                                     ->where('leave_type_map_with',$leaveType->leave_type_id)
                                     ->first();
    
                                     if (!$user_leave_encash_carries) {

                                        $total_leave = $total_leave + 0;
                                    
                                        $carry_forward = 0;
                                        $leave_encash = 0;
                                    
                                       
                                       
                                    }else{
                                    
                                        $total_leave = $total_leave + $user_leave_encash_carries->carry_forward;
                                    
                                        $carry_forward = $user_leave_encash_carries->carry_forward;
                                        $leave_encash = $user_leave_encash_carries->leave_encash;
                                    
                                    
                                    }
    
    }
    
    $remaning_leave = $total_leave - $takenLeave;
    
// dd($remaning_leave);
          
            $leave_single_data = [
                'leave_type' => $leaveType->leave_type,
                'total_leaves' => $total_leave,
                'no_carry_forward' => $carry_forward,
                'no_leave_encash' => $leave_encash,
                'consumed_leaves' => $takenLeave,
                'remaining_leaves' => $remaning_leave,
            ];

          
    
          array_push($leaveSummary,$leave_single_data); 
        }
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
        $emp_details = DB::table('emp_details')->where('user_id',$loginUserInfo->id)->first();
        // dd($emp_details);

        $leave_restriction = DB::table('leave_type_restrictions')->where('leave_type_id',$leave_id)->first();
        if(!$leave_restriction){

            return response()->json([
                'remaining_leave' => 0,  // This is the data you will send back to the front-end
            ]);

        }
        $leaveCycyle = DB::table('leave_cycles')
        ->where('organisation_id' ,'=', $loginUserInfo->organisation_id)
        ->where('status', '=', 'Active')
        ->first();

        // dd($leaveCycyle);
        $leaceCycleStartDate = $leaveCycyle->start_date;
        $leaceCycleEndtDate = $leaveCycyle->end_date;
        $provision_period = $emp_details->provision_period;
        $Joining_date = $emp_details->Joining_date;
        $JDC = Carbon::create($Joining_date); 
        $calendra_start = $leave_restriction->calendra_start_for_PP;
        $date = Carbon::create($Joining_date);
        $provision_period_till = $date->addMonths($provision_period);  
        $PPdate = $provision_period_till->toDateString();  
        
        $today = Carbon::today();

        $leaveCountArray = DB::table('leave_applies')
        ->where('leave_type_id',$leave_id)
        ->where('user_id',$loginUserInfo->id)
        ->where('leave_approve_status','Approved')
        ->get();


$leaceCycleEndtDate = Carbon::create($leaceCycleEndtDate);  // Cycle End date: 2026-03-31 10:52:00
$leaceCycleStartDate = Carbon::create($leaceCycleStartDate);

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
            $leaveCount = $dateDiff->days + 1;

    }

    $takenLeave += $leaveCount;
}
$currentYear = Carbon::now()->year; 

if($leave_restriction->provision_status == 'Not Applicable'){

    // $leave_restriction->max_leave - $takenLeave;


    $remaning_leave = $leave_restriction->max_leave - $takenLeave;

    return response()->json([
        'remaining_leave' => $remaning_leave,  // This is the data you will send back to the front-end
    ]);

}else{

if($emp_details->provision_period_year == 1){

    //code for year cycle date of joining [joining year]

    // Calculate the difference in months
 $months = $JDC->diffInMonths($leaceCycleEndtDate);

 // Check if there's any partial month remaining after full months
 if ($JDC->copy()->addMonths($months)->isBefore($leaceCycleEndtDate)) {
     $months++;  // If there is a partial month, add it
 }

    $total_leave = 0;
    
    $leavemonthwithoutPP = $months - $provision_period;

    $total_leave = $leavemonthwithoutPP*$leave_restriction->leave_count_per_month;

    $total_leave = $total_leave + ($provision_period*$leave_restriction->provision_period_per_month);

    if ($JDC->day > $calendra_start) {

        $total_leave = $total_leave - $leave_restriction->provision_period_per_month;
     
     }

}else if($emp_details->provision_period_year == 2){

    //if provision period extent to next cycyle

    $months = $leaceCycleStartDate->diffInMonths($leaceCycleEndtDate);

 
 if ($leaceCycleStartDate->copy()->addMonths($months)->isBefore($leaceCycleEndtDate)) {
     $months++;  
 }

 $remaning_pp_months = $leaceCycleStartDate->diffInMonths($provision_period_till);

 if ($leaceCycleStartDate->copy()->addMonths($remaning_pp_months)->isBefore($provision_period_till)) {
    $remaning_pp_months++; 
}

$leavemonthwithoutPP = $months - $remaning_pp_months;

$total_leave = $leavemonthwithoutPP*$leave_restriction->leave_count_per_month;

$total_leave = $total_leave + ($remaning_pp_months*$leave_restriction->provision_period_per_month);

$user_leave_encash_carries = DB::table('user_leave_encash_carries')
->where('user_id',$loginUserInfo->id)
->where('leave_type_map_with',$leave_id)
->first();

if (!$user_leave_encash_carries) {

    $total_leave = $total_leave + 0;

   
   
}else{

    $total_leave = $total_leave + $user_leave_encash_carries->carry_forward;


}




}else{

    //without provision period

    // $total_leave = $leave_restriction[0]->max_leave + $user_leave_encash_carries->carry_forward;

    $user_leave_encash_carries = DB::table('user_leave_encash_carries')
                                 ->where('user_id',$loginUserInfo->id)
                                 ->where('leave_type_map_with',$leave_id)
                                 ->first();

                                 if (!$user_leave_encash_carries) {

                                    $total_leave = $leave_restriction->max_leave + 0;
                                 
                                }else{
                                
                                    $total_leave = $leave_restriction->max_leave + $user_leave_encash_carries->carry_forward;
                                
                                
                                }

}

$remaning_leave = $total_leave - $takenLeave;

    return response()->json([
        'remaining_leave' => $remaning_leave,  // This is the data you will send back to the front-end
    ]);
    }
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

                
                $additional_email = DB::table('org_global_prams')
                ->where('organisation_id','=',$loginUserInfo->organisation_id)
                ->where('pram_id','=',1)
                ->first();
                if($additional_email){
                  //converting string to aaray with seprate from comma
                    $strToArray = explode(",",$additional_email->values);
                    foreach($strToArray as $ccAdditionalEmails){

                        array_push($mail_cc,$ccAdditionalEmails);

                    }

                }
             

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

    
    public function updateLeaveStatusByUser($id)
    {

        $loginUserInfo = Auth::user();
        
        $leave_apply = DB::table('leave_applies')->where('id', $id)->first();

     

        $leave_type = DB::table('leave_types')
        ->select('name')
        ->where('id','=',$leave_apply->leave_type_id)
        ->first();

        // dd($leave_type);
    
        
        if (!$leave_apply) {
            return redirect()->route('leave_dashboard')->with('error', 'Leave record not found.');
        }
    
       
        if ($leave_apply->leave_approve_status == 'Pending' || $leave_apply->leave_approve_status == 'Approved') {
            
            
            $status = DB::table('leave_applies')
                ->where('id', $id)
                ->update([
                    'leave_approve_status' => 'Cancelled',
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
    $startDate = new DateTime($leave_apply->start_date);
    $endDate = new DateTime($leave_apply->end_date);
    
    // Calculate the difference between the two dates
    $interval = $startDate->diff($endDate);
    
    // Get the number of days from the difference
    $daysBetween = $interval->days+1;
    
    if($leave_apply->half_day == 'First Half' || $leave_apply->half_day == 'Second Half'){
    
        $halfDay = 0.5;
        
        $subject = $leave_apply->half_day.' Leave Cancelled - '.$leave_type->name.' - '.$halfDay.' day';
    
    }elseif($leave_apply->half_day == 'Full Day'){
    
        $fullday = 1;
    
        $subject = $leave_apply->half_day.' Leave Cancelled - '.$leave_type->name.' - '.$fullday.' day';
    
    }else{
    
        $subject = 'Leave Cancelled - '.$leave_type->name.' - '.$daysBetween.' days';
    
    }

                    $org_id = $loginUserInfo->organisation_id;
                    $mail_flag = "leave_cancel_status";

                    array_push($mail_to,$loginUserInfo->email);
                    array_push($mail_cc,$fetchManager->manager_mail_id);

                    $additional_email = DB::table('org_global_prams')
                    ->where('organisation_id','=',$loginUserInfo->organisation_id)
                    ->where('pram_id','=',1)
                    ->first();
                    if($additional_email){
                      //converting string to aaray with seprate from comma
                        $strToArray = explode(",",$additional_email->values);
                        foreach($strToArray as $ccAdditionalEmails){
                
                            array_push($mail_cc,$ccAdditionalEmails);
                
                        }
                
                    }

                    $data = [
                        'username' => $mail_to, //mail to
                        'cc' => $mail_cc, 
                        'approved_by' => $fetchManager->manager_name,
                        'name' => $loginUserInfo->name,
                        'leave_type' => $leave_type->name,
                        'start_date' => $leave_apply->start_date,
                        'end_date' => $leave_apply->end_date,
                        'leave_status' => 'Cancelled',
                        'days_count' => $daysBetween,
                        'org_id' => $loginUserInfo->organisation_id,
                    ];

                  

                    // dd($data);

                //    Mail::to($user_create->email)->send(new UserRegistrationMail($user_create->email, $request->userpassword));
               $this->emailService->sendEmailWithOrgConfig($org_id,$subject,$mail_flag,$data);
    
               return redirect()->route('leave_dashboard')->with('success', 'Your leave has been cancelled successfully.');

                }

        }
    
        // If the leave status is neither "Pending" nor "Approved"
        return redirect()->route('leave_dashboard')->with('error', 'Leave cannot be cancelled because it is not in a pending or approved status.');
    }

    public function loadProcessLeavePolicy(){

        $id = Auth::guard('superadmin')->user()->id;
        $leaveCycleDatas = leaveCycle::where('organisation_id', $id)
        ->where('status', 'Active')
        ->first();
        // dd($leaveCycleDatas);
        return view('superadmin_view.leave_process',compact('leaveCycleDatas'));
        
    }

    public function loadAllLeaveActive($id){

        dd($id);

    }
}