<?php

namespace App\Http\Controllers;
use DateTime;
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
    // $thoughtOfTheDay = DB::table('thought_of_the_days')
    //                      ->where('organisation_id', $user->organisation_id)
    //                      ->where('creationDate',today())
    //                      ->get();

    $thoughtOfTheDay = DB::table('thought_of_the_days')
    ->where('organisation_id', $user->organisation_id)
    ->whereDate('creationDate', today())
    ->first(); // Fetch today's record

if (!$thoughtOfTheDay) {
    // If no record for today, get the latest before today
    $thoughtOfTheDay = DB::table('thought_of_the_days')
        ->where('organisation_id', $user->organisation_id)
        ->whereDate('creationDate', '<', today())
        ->orderBy('creationDate', 'desc')
        ->first();
}

// dd($thoughtOfTheDay);

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

    foreach ($total_leaves_of_org as $leaveType) {

    $leave_single_data = [];
    // $leave_single_data['leave_type'] = $leaveType->leave_type;
    array_push($leave_single_data,$leaveType->leave_type);

    $leaveCycyle = DB::table('leave_cycles')
    ->where('organisation_id' ,'=', $user->organisation_id)
    ->where('status', '=', 'Active')
    ->first();
    
    $leave_restriction = DB::table('leave_type_restrictions')->where('leave_type_id',$leaveType->leave_type_id)->first();

    if (!$leave_restriction) {
        // Skip the current leave type or set defaults
        continue; // This will skip the current iteration in the loop
    }

    $leaceCycleStartDate = $leaveCycyle->start_date;
    $leaceCycleEndtDate = $leaveCycyle->end_date;
    $provision_period = $emp_details->provision_period;
    $Joining_date = $emp_details->Joining_date;
    $JDC = Carbon::create($Joining_date); 
    // $calendra_start = $leave_restriction->calendra_start_for_PP;
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

    // $leave_restriction->max_leave - $takenLeave;

    array_push($leave_single_data,$leave_restriction->max_leave);

    $percentage = $takenLeave*100/$leave_restriction->max_leave;
                            
    $roundPer = round($percentage, 2);

    //pushing taken leave of this leave type
    array_push($leave_single_data,$takenLeave);
//pushing percentage
    array_push($leave_single_data,$roundPer);
//pushing sub array to main array
    array_push($leaveUsage,$leave_single_data);

}else{

if($emp_details->provision_period_year == 1){

//code for year cycle date of joining [joining year]

// Calculate the difference in months
$months = $JDC->diffInMonths($leaceCycleEndtDate);

// Check if there's any partial month remaining after full months
if ($JDC->copy()->addMonths($months)->isBefore($leaceCycleEndtDate)) {
 $months++;  // If there is a partial month, add it
}

$calendra_start = $leave_restriction->calendra_start_for_PP;

$total_leave = 0;

$leavemonthwithoutPP = $months - $provision_period;

$total_leave = $leavemonthwithoutPP*$leave_restriction->leave_count_per_month;

$total_leave = $total_leave + ($provision_period*$leave_restriction->provision_period_per_month);

if ($JDC->day > $calendra_start) {

    $total_leave = $total_leave - $leave_restriction->provision_period_per_month;
 
 }

 array_push($leave_single_data,$total_leave);

 $percentage = $takenLeave*100/$total_leave;

    $roundPer = round($percentage, 2);


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

array_push($leave_single_data,$total_leave);

$percentage = $takenLeave*100/$total_leave;

$roundPer = round($percentage, 2);

   
   
}else{

    $total_leave = $total_leave + $user_leave_encash_carries->carry_forward;

array_push($leave_single_data,$total_leave);

$percentage = $takenLeave*100/$total_leave;

$roundPer = round($percentage, 2);


}

}else{

//without provision period
$total_leave = $leave_restriction->max_leave;

$user_leave_encash_carries = DB::table('user_leave_encash_carries')
                             ->where('user_id',$user->id)
                             ->where('leave_type_map_with',$leaveType->leave_type_id)
                             ->first();

                             if (!$user_leave_encash_carries) {

                                $total_leave = $leave_restriction->max_leave + 0;
                            
                            array_push($leave_single_data,$total_leave);
                            
                            $percentage = $takenLeave*100/$total_leave;
                            
                            $roundPer = round($percentage, 2);
                            
                               
                               
                            }else{
                            
                                $total_leave = $total_leave + $user_leave_encash_carries->carry_forward;
                            
                            array_push($leave_single_data,$total_leave);
                            
                            $percentage = $takenLeave*100/$total_leave;
                            
                            $roundPer = round($percentage, 2);
                            
                            
                            }

}

// $remaning_leave = $total_leave - $takenLeave;

//pushing taken leave of this leave type
    array_push($leave_single_data,$takenLeave);
//pushing percentage
    array_push($leave_single_data,$roundPer);
//pushing sub array to main array
    array_push($leaveUsage,$leave_single_data);

}
}

// dd($leaveUsage);

    // Fetch upcoming and today's birthdays
    // $currentDate = Carbon::now();
    // $currentMonth = $currentDate->month;
    // $currentDay = $currentDate->day;

    // $upcomingBirthdays = DB::table('emp_details')
    //     ->join('organisation_designations','emp_details.designation','=','organisation_designations.id')
    //     ->leftjoin('user_status_imgs','emp_details.user_id','=','user_status_imgs.user_id')
    //     ->select('emp_details.employee_name as employee_nme', 'date_of_birth', 'organisation_designations.name as designation_name','user_status_imgs.*')
    //     ->whereMonth('date_of_birth', '=', $currentMonth)
    //     ->whereDay('date_of_birth', '>=', $currentDay)
    //     ->orderByRaw("DATE_FORMAT(date_of_birth, '%m-%d') >= ? DESC, DATE_FORMAT(date_of_birth, '%m-%d') ASC", [$currentDate->format('m-d')]) 
    //     ->get()
    //     ->map(function ($employee) use ($currentDay, $currentDate) {
    //         $birthDate = new Carbon($employee->date_of_birth);
    //         $birthDay = $birthDate->day;
    //         $employee->age = $birthDate->age;
    //         $employee->badgeText = $birthDay === $currentDay ? "Today" : "Upcoming in " . ($birthDay - $currentDay) . " days";
    //         return $employee;
    //     });

    // use Carbon\Carbon;

    $currentDate = Carbon::now();
    // Fetch upcoming and today's birthdays
    $currentDate = Carbon::now();
    $currentMonth = $currentDate->month;
    $currentDay = $currentDate->day;
    
    $upcomingBirthdays = DB::table('emp_details')
    ->join('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id')
    ->leftJoin('user_status_imgs', 'emp_details.user_id', '=', 'user_status_imgs.user_id')
    ->select(
        'emp_details.employee_name as employee_nme',
        'date_of_birth',
        'organisation_designations.name as designation_name',
        'user_status_imgs.*'
    )
    ->get()
    ->filter(function ($employee) use ($currentDate) {
        $birthDate = Carbon::parse($employee->date_of_birth)->year($currentDate->year);
        return $birthDate->isToday() || $birthDate->isFuture(); // Only upcoming birthdays this year
    })
    ->sortBy(function ($employee) use ($currentDate) {
        $birthDate = Carbon::parse($employee->date_of_birth)->year($currentDate->year);
        return $currentDate->diffInDays($birthDate, false); // Sort by soonest
    })
    ->take(10) // ✅ Limit to Top 10
    ->map(function ($employee) use ($currentDate) {
        $birthDate = new Carbon($employee->date_of_birth);
        $nextBirthday = $birthDate->copy()->year($currentDate->year);

        if ($nextBirthday->isPast() && !$nextBirthday->isToday()) {
            $nextBirthday->addYear(); // Push to next year if already passed
        }

        $employee->age = $birthDate->age;

        $employee->badgeText = $nextBirthday->isToday()
            ? "Today"
            : "Upcoming in " . $currentDate->diffInDays($nextBirthday) . " days";

        return $employee;
    })
    ->values(); // Reset collection keys
    

        // dd($upcomingBirthdays);

        //Fetch Today Birthday

        $todayBirthdays = DB::table('emp_details')
        ->join('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id')
        ->leftJoin('user_status_imgs', 'emp_details.user_id', '=', 'user_status_imgs.user_id')
        ->select('emp_details.employee_name as employee_nme', 'date_of_birth', 'organisation_designations.name as designation_name', 'user_status_imgs.*')
        ->whereMonth('date_of_birth', '=', now()->month)  // Match the current month
        ->whereDay('date_of_birth', '=', now()->day)    // Match the current day
        ->whereDate('date_of_birth', now()->format('Y-m-d'))
        ->get()
        ->map(function ($employee) {
            $birthDate = new Carbon($employee->date_of_birth);
            $employee->age = $birthDate->age;
            
            // Check if today's the employee's birthday or upcoming
            $currentDay = now()->day;
            $currentMonth = now()->month;
            $birthDay = $birthDate->day;
            $birthMonth = $birthDate->month;
    
            // If the birthday is today
            if ($birthDay === $currentDay && $birthMonth === $currentMonth) {
                $employee->badgeText = "Today";
            } else {
                // If it's not today, calculate how many days are left for the birthday
                $nextBirthday = $birthDate->copy()->year(now()->year); // Set the birthday to this year
                if ($nextBirthday->isPast()) {
                    $nextBirthday->addYear(); // If the birthday already passed this year, set it to the next year
                }
                $daysRemaining = $nextBirthday->diffInDays(now());
                $employee->badgeText = "Upcoming in " . $daysRemaining . " days";
            }
    
            return $employee;
        });
    

        // dd($todayBirthdays);

    // Fetch upcoming anniversaries
    $anniversaries = DB::table('emp_details')
        ->select('Employee_Name', 'Joining_Date')
        ->whereMonth('Joining_Date', '=', $currentMonth)
        ->whereDay('Joining_Date', '>=', $currentDay)
        ->orderByRaw("DATE_FORMAT(Joining_Date, '%m-%d') >= ? DESC, DATE_FORMAT(Joining_Date, '%m-%d') ASC", [$currentDate->format('m-d')]) 
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
// $leaveLists = array();

// for ($teamMamber = 0; $teamMamber < $dataOfteamMambers->count(); $teamMamber++) {
//     $leaveApply = DB::table('leave_applies')
//         ->join('leave_types', 'leave_applies.leave_type_id', '=', 'leave_types.id')
//         ->join('emp_details', 'leave_applies.user_id', '=', 'emp_details.user_id')
//         ->select(
//             'leave_applies.start_date as leave_start_date', 'leave_applies.end_date as leave_end_date', 
//             'leave_applies.description as leave_resion', 'leave_applies.id as leave_appliy_id',
//             'leave_types.name as leave_name', 'emp_details.employee_no as employee_no', 
//             'emp_details.employee_name as employee_name','leave_applies.half_day as status_half_day'
//         )
//         ->where('leave_applies.user_id', '=', $dataOfteamMambers[$teamMamber]->user_id)
//         ->whereIn('leave_applies.leave_approve_status', ['Pending', 'Rejected'])
//         ->get();

//     // Add the retrieved leave apply data to the leaveLists array
//     array_push($leaveLists, $leaveApply);
// }

//     dd($leaveLists); 

$leaveLists = array();

for ($teamMamber = 0; $teamMamber < $dataOfteamMambers->count(); $teamMamber++) {
    // Fetch leave apply data for each team member
    $leaveApply = DB::table('leave_applies')
        ->join('leave_types', 'leave_applies.leave_type_id', '=', 'leave_types.id')
        ->join('emp_details', 'leave_applies.user_id', '=', 'emp_details.user_id')
        ->select(
            'leave_applies.start_date as leave_start_date', 
            'leave_applies.end_date as leave_end_date', 
            'leave_applies.description as leave_resion', 
            'leave_applies.id as leave_appliy_id',
            'leave_types.name as leave_name', 
            'emp_details.employee_no as employee_no', 
            'emp_details.employee_name as employee_name',
            'leave_applies.half_day as status_half_day'
        )
        ->where('leave_applies.user_id', '=', $dataOfteamMambers[$teamMamber]->user_id)
        ->whereIn('leave_applies.leave_approve_status', ['Pending', 'Rejected'])
        ->get()
        ->map(function ($leave) {
            // Calculate number of days
            $startDate = \Carbon\Carbon::parse($leave->leave_start_date);
            $endDate = \Carbon\Carbon::parse($leave->leave_end_date);

            // Calculate the base number of days between start and end date
            $daysCount = $startDate->diffInDays($endDate) + 1; // Including both start and end dates

            // Adjust based on status_half_day
            if ($leave->status_half_day == 'First Half' || $leave->status_half_day == 'Second Half') {
                $daysCount = 0.5; // Half day
            } elseif ($leave->status_half_day == 'Full day') {
                $daysCount = 1; // Full day
            }

            // Add the calculated number of days to the leave object
            $leave->days_count = $daysCount;

            return $leave;
        });

    // Add the retrieved and modified leave apply data to the leaveLists array
    array_push($leaveLists, $leaveApply);
}

$currentDate = Carbon::now();
$currentMonth = $currentDate->month;
$currentYear = $currentDate->year;  // Get the current year

// Fetch upcoming holidays for the full year
$holidays_upcoming = DB::table('calendra_masters')
    ->select('date', 'holiday_name', 'day')
    ->where('holiday', '=', 'Yes')
    ->whereYear('date', '=', $currentYear)  // Filter by the current year
    ->get();

// Format holiday dates
$holidays_upcoming = $holidays_upcoming->map(function ($holiday) {
    $holiday->formatted_date = Carbon::parse($holiday->date)->format('d F');
    return $holiday;
});
       
// Fetch week-offs for the full year
$week_offs = DB::table('calendra_masters')
    ->select('date', 'day')
    ->where('week_off', '=', 'YES')
    ->whereYear('date', '=', $currentYear)  // Filter by the current year
    ->get();

// Format week-off dates
$week_offs = $week_offs->map(function ($week_off) {
    $week_off->formatted_date = Carbon::parse($week_off->date)->format('d F');
    return $week_off;
});
// Fetch upcoming holidays for the full year (excluding expired holidays)
$upcomingHolidays = DB::table('calendra_masters')
    ->select('date', 'holiday_name', 'day')
    ->where('holiday', '=', 'Yes')
    ->whereYear('date', '=', $currentYear)  // Filter by the current year
    ->where('date', '>=', now())  // Exclude expired holidays
    ->get();

// Format holiday dates
$upcomingHolidays = $upcomingHolidays->map(function ($holiday) {
    $holiday->formatted_date = Carbon::parse($holiday->date)->format('d F');
    return $holiday;
});


// $reimbursementList = DB::table('reimbursement_trackings')
//     ->join('emp_details', 'reimbursement_trackings.user_id', '=', 'emp_details.user_id')
//     ->join('reimbursement_form_entries', 'reimbursement_trackings.id', '=', 'reimbursement_form_entries.reimbursement_trackings_id')
//     ->join('assign_reimbursement_tokens', 'reimbursement_trackings.id', '=', 'assign_reimbursement_tokens.reimbursement_tracking_id')
//     ->select(
//         'emp_details.employee_no',
//         'emp_details.employee_name',
//         'emp_details.user_id',
//         'reimbursement_trackings.token_number',
//         'reimbursement_trackings.status',
//         DB::raw('SUM(reimbursement_form_entries.amount) as total_amount'),
//     )
//     ->where('assign_reimbursement_tokens.user_id', '=', $user->id)
//     ->where('reimbursement_trackings.status', '=', 'Pending')
//     ->groupBy('emp_details.user_id')
//     ->get();

$reimbursementList = DB::table('reimbursement_trackings')
    ->join('emp_details', 'reimbursement_trackings.user_id', '=', 'emp_details.user_id')
    ->join('reimbursement_form_entries', 'reimbursement_trackings.id', '=', 'reimbursement_form_entries.reimbursement_trackings_id')
    ->join('assign_reimbursement_tokens', 'reimbursement_trackings.id', '=', 'assign_reimbursement_tokens.reimbursement_tracking_id')
    ->select(
        'emp_details.employee_no',
        'emp_details.employee_name',
        'emp_details.user_id',
        'reimbursement_trackings.token_number',
        'reimbursement_trackings.status',
        'reimbursement_trackings.id',
        DB::raw('SUM(reimbursement_form_entries.amount) as total_amount'),
        DB::raw('COUNT(reimbursement_form_entries.id) as no_of_entries') 
    )
    ->where('assign_reimbursement_tokens.user_id', '=', $user->id)
    ->where('reimbursement_trackings.status', '=', 'Pending')
    ->groupBy(
        'reimbursement_trackings.id',
        'reimbursement_trackings.token_number',
        'reimbursement_trackings.status',
        'emp_details.employee_no',
        'emp_details.employee_name',
        'emp_details.user_id'
    )
    ->get();

    // $approvedClaimsByManager = DB::table('reimbursement_trackings')
    // ->join('emp_details as employees', 'reimbursement_trackings.user_id', '=', 'employees.user_id')
    // ->join('emp_details as managers', 'employees.reporting_manager', '=', 'managers.user_id')
    // ->join('reimbursement_form_entries', 'reimbursement_trackings.id', '=', 'reimbursement_form_entries.reimbursement_trackings_id')
    // ->select(
    //     'managers.user_id as manager_id',
    //     'managers.employee_name as manager_name',
    //     DB::raw('COUNT(DISTINCT reimbursement_trackings.id) as approved_claims') // Count distinct claims
    // )
    // ->where('reimbursement_trackings.status', '=', 'Approved') // Filter only approved claims
    // ->groupBy('managers.user_id', 'managers.employee_name') // Group by manager ID and name
    // ->get();

    $approvedClaimsByManager = DB::table('reimbursement_trackings')
    ->join('emp_details as employees', 'reimbursement_trackings.user_id', '=', 'employees.user_id')
    ->join('emp_details as managers', 'employees.reporting_manager', '=', 'managers.user_id')
    ->join('reimbursement_form_entries', 'reimbursement_trackings.id', '=', 'reimbursement_form_entries.reimbursement_trackings_id')
    ->select(
        'managers.user_id as manager_id',
        'managers.employee_name as manager_name',
        'managers.employee_no as manager_employee_no', // Include manager's employee number
        'employees.employee_no', // Include employee_no
        'employees.employee_name as employee_name', // Include employee name
       'reimbursement_trackings.id as reimbursement_traking_id', // Include reimbursement tracking ID
        'reimbursement_form_entries.date as entry_date',
        'reimbursement_form_entries.amount as entry_amount',
        'reimbursement_form_entries.upload_bill',
        'reimbursement_form_entries.description_by_applicant',
        'reimbursement_form_entries.description_by_manager'
    )
    ->where('reimbursement_trackings.status', '=', 'APPROVED BY MANAGER') // Filter only approved claims
    ->get();

    // Return a view with the logs and additional data
    return view('user_view.homepage', compact('title','logs', 'thoughtOfTheDay', 'newsAndEvents', 'upcomingBirthdays','todayBirthdays', 'anniversaries', 'toDoList', 'currentMonth', 'currentDay', 'leaveUsage','leaveLists', 'holidays_upcoming', 'week_offs', 'upcomingHolidays', 'reimbursementList', 'approvedClaimsByManager'));
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

    $mail_to = [];
    $mail_cc = [];

    $leave_apply = DB::table('leave_applies')
    ->where('id','=',$id)
    ->first();

    $apply_leaveuser_data = DB::table('users')->where('id','=',$leave_apply->user_id)->first();

    $leave_type = DB::table('leave_types')
    ->select('name')
    ->where('id','=',$leave_apply->leave_type_id)
    ->first();

    array_push($mail_to,$apply_leaveuser_data->email);
    array_push($mail_cc,$user->email);

    $additional_email = DB::table('org_global_prams')
    ->where('organisation_id','=',$user->organisation_id)
    ->where('pram_id','=',1)
    ->first();
    if($additional_email){
      //converting string to aaray with seprate from comma
        $strToArray = explode(",",$additional_email->values);
        foreach($strToArray as $ccAdditionalEmails){

            array_push($mail_cc,$ccAdditionalEmails);

        }

    }

        // Convert start and end dates to DateTime objects
$startDate = new DateTime($leave_apply->start_date);
$endDate = new DateTime($leave_apply->end_date);

// Calculate the difference between the two dates
$interval = $startDate->diff($endDate);

// Get the number of days from the difference
$daysBetween = $interval->days+1;

// $leave_apply->half_day;
if($leave_apply->half_day == 'First Half' || $leave_apply->half_day == 'Second Half'){

    $halfDay = 0.5;
    
    // $subject = $data['leave_slot'].' Leave Application Submitted - '.$leave_type->name.' - '.$halfDay.' day';

    if($status == 'Approved'){

        $subject = $leave_apply->half_day.' Leave Approved - '.$leave_type->name.' - '.$halfDay.' Day';

    }elseif($status == 'Reject'){

        $subject = $leave_apply->half_day.' Leave Rejected - '.$leave_type->name.' - '.$halfDay.' Day';;

    }

}elseif($leave_apply->half_day == 'Full Day'){

    $fullday = 1;

    // $subject = $data['leave_slot'].' Leave Application Submitted - '.$leave_type->name.' - '.$fullday.' day';

    if($status == 'Approved'){

        $subject = $leave_apply->half_day.' Leave Approved - '.$leave_type->name.' - '.$fullday.' Day';

    }elseif($status == 'Reject'){

        $subject = $leave_apply->half_day.' Leave Rejected - '.$leave_type->name.' - '.$fullday.' Day';;

    }

}else{

    if($status == 'Approved'){

        $subject = 'Leave Approved - '.$leave_type->name.' - '.$daysBetween.' Days';

    }elseif($status == 'Reject'){

        $subject = 'Leave Rejected - '.$leave_type->name.' - '.$daysBetween.' Days';;

    }

}

    $org_id = $user->organisation_id;
    $mail_flag = "leave_approve_status";


    $data = [
        'username' => $mail_to,
        'cc' => $mail_cc,
        'name' => $apply_leaveuser_data->name,
        'leave_type' => $leave_type->name,
        'start_date' => $leave_apply->start_date,
        'end_date' => $leave_apply->end_date,
        'leave_status' => $status,
        'approved_by' => $user->name,
        'days_count' => $daysBetween,
        'org_id' => $user->organisation_id,
    ];

   

//    Mail::to($user_create->email)->send(new UserRegistrationMail($user_create->email, $request->userpassword));
   $this->emailService->sendEmailWithOrgConfig($org_id,$subject,$mail_flag,$data);

    return redirect()->route('user.homepage')->with('success', 'Leave status updated successfully.');

}else{

    return redirect()->route('user.homepage')->with('error', 'Leave status not updated successfully.');

}


    }

}
