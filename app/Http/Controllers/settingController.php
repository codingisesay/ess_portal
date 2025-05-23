<?php

namespace App\Http\Controllers;
use App\Services\EmailService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Carbon\CarbonPeriod;



class settingController extends Controller
{
    public function showsetting(Request $request)
    {
        $title = "Settings";
        $loginUserInfo = Auth::user();
       
        // $users = User::where('organisation_id', $loginUserInfo->organisation_id)->paginate(10);
        $users = User::where('organisation_id', $loginUserInfo->organisation_id)
             ->where('user_status', 'Active') // ✅ Only active users
             ->paginate(10);

        // $users_for_salary = User::where('organisation_id', $loginUserInfo->organisation_id)->get();
        $users_for_salary = DB::table('users')
        ->leftjoin('employee_salaries','users.id','=','employee_salaries.user_id')
        ->leftjoin('org_salary_templates','employee_salaries.salary_template_id','=','org_salary_templates.id')
        ->select('users.employeeID as emp_employeeID',
        'users.id as user_id','users.name as user_name',
        'org_salary_templates.name as org_salary_templates_name',
        'org_salary_templates.id as org_salary_templates_id',
        'employee_salaries.user_ctc as user_ctc'
        )
        ->where('users.user_status', 'Active') // ✅ Added filter
        ->get();
        // dd($sal);
        $salary_templates = DB::table('org_salary_templates')
        ->where('organisation_id',$loginUserInfo->organisation_id)
        ->where('status','Active')
        ->get();
         
        $dataofcurrentyear = DB::table('salary_cycles')
        ->where('organisation_id',$loginUserInfo->organisation_id)
        ->where('status','Active')
        ->first();

        $start = Carbon::parse($dataofcurrentyear->start_date);
        $end = Carbon::parse($dataofcurrentyear->end_date);

        $period = CarbonPeriod::create($start->startOfMonth(), '1 month', $end->startOfMonth());

        $monthsInCycle = [];
        foreach ($period as $date) {
        // $monthsInCycle[] = $date->format('F'); // Full month name like 'April'
        $monthsInCycle[] = $date->format('F Y');
        }



        
$month = $request->input('month', now()->month);
$year = $request->input('year', now()->year);
// Get filters
// Get the raw input dates
$startDate = request('start_date');
$endDate = request('end_date');
$leaveTypeId = request('leave_type_id'); 

// Normalize date formats
if ($startDate) {
    try {
        $startDate = Carbon::createFromFormat('d-m-Y', $startDate)->format('Y-m-d');
    } catch (\Exception $e) {
        $startDate = Carbon::parse($startDate)->format('Y-m-d');
    }
}

if ($endDate) {
    try {
        $endDate = Carbon::createFromFormat('d-m-Y', $endDate)->format('Y-m-d');
    } catch (\Exception $e) {
        $endDate = Carbon::parse($endDate)->format('Y-m-d');
    }
}

// Build the main query
$leaveSummary = DB::table('leave_applies as la')
    ->join('users as u', 'la.user_id', '=', 'u.id')
    ->join('leave_types as lt', 'la.leave_type_id', '=', 'lt.id')
    ->join('leave_type_restrictions as ltr', 'lt.id', '=', 'ltr.leave_type_id')
    ->leftJoin('leave_cycles as lc', function($join) use ($startDate, $endDate) {
        $join->on('lc.organisation_id', '=', 'u.organisation_id')
             ->where('lc.status', 'ACTIVE');

        // Apply leave cycle date range if provided
        if ($startDate && $endDate) {
            $join->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('lc.start_date', [$startDate, $endDate])
                      ->orWhereBetween('lc.end_date', [$startDate, $endDate])
                      ->orWhere(function($subquery) use ($startDate, $endDate) {
                          $subquery->where('lc.start_date', '<=', $startDate)
                                   ->where('lc.end_date', '>=', $endDate);
                      });
            });
        }
    })
    ->leftJoin('user_leave_encash_carries as ulec', function($join) {
        $join->on('ulec.user_id', '=', 'u.id')
             ->on('ulec.leave_type_map_with', '=', 'lt.id')
             ->on('ulec.leave_cycle_id', '=', 'lc.id'); // Map by active cycle
    })
    ->select(
        'u.name as employee_name',
        'u.employeeID',
        'lt.name as leave_type_name',
        'ltr.max_leave',
        'lc.name as leave_cycle_name',
        'lc.start_date as cycle_start_date',
        'lc.end_date as cycle_end_date',

        // Approved Days
        DB::raw("SUM(CASE 
            WHEN la.leave_approve_status = 'Approved' THEN 
                CASE 
                    WHEN la.half_day IN ('First Half', 'Second Half') THEN 0.5
                    ELSE DATEDIFF(la.end_date, la.start_date) + 1
                END
            ELSE 0
        END) as approved_days"),
        
        // Rejected Days
        DB::raw("SUM(CASE 
            WHEN la.leave_approve_status = 'Rejected' THEN 
                CASE 
                    WHEN la.half_day IN ('First Half', 'Second Half') THEN 0.5
                    ELSE DATEDIFF(la.end_date, la.start_date) + 1
                END
            ELSE 0
        END) as rejected_days"),
        
        // Cancelled Days
        DB::raw("SUM(CASE 
            WHEN la.leave_approve_status = 'Cancelled' THEN 
                CASE 
                    WHEN la.half_day IN ('First Half', 'Second Half') THEN 0.5
                    ELSE DATEDIFF(la.end_date, la.start_date) + 1
                END
            ELSE 0
        END) as cancelled_days"),
        
        // Pending for Approval Days
        DB::raw("SUM(CASE 
            WHEN la.leave_approve_status = 'Pending' THEN 
                CASE 
                    WHEN la.half_day IN ('First Half', 'Second Half') THEN 0.5
                    ELSE DATEDIFF(la.end_date, la.start_date) + 1
                END
            ELSE 0
        END) as pending_days"),

        // Total Carry Forward (Without Summing)
        DB::raw("IFNULL(ulec.carry_forward, 0) as total_carry_forward"),
        
        // Total Leave Remaining (Updated Logic)
        DB::raw("
            GREATEST(
                0,
                (LTRIM(RTRIM(CAST(ltr.max_leave AS SIGNED))) + IFNULL(ulec.carry_forward, 0)) - 
                SUM(CASE 
                    WHEN la.leave_approve_status = 'Approved' THEN 
                        CASE 
                            WHEN la.half_day IN ('First Half', 'Second Half') THEN 0.5
                            ELSE DATEDIFF(la.end_date, la.start_date) + 1
                        END
                    ELSE 0
                END)
            ) as total_leave_remaining
        ")
    )
    ->where('u.user_status', 'Active');

// Apply Leave Application Date Filters
if ($startDate && $endDate) {
    $leaveSummary->where(function($query) use ($startDate, $endDate) {
        $query->whereBetween('la.start_date', [$startDate, $endDate])
              ->orWhereBetween('la.end_date', [$startDate, $endDate])
              ->orWhere(function($subquery) use ($startDate, $endDate) {
                  $subquery->where('la.start_date', '<=', $startDate)
                           ->where('la.end_date', '>=', $endDate);
              });
    });
}

// Apply Leave Type Filter
if ($leaveTypeId) {
    $leaveSummary->where('lt.id', $leaveTypeId);
}

// Finalize the query
$leaveSummary = $leaveSummary->groupBy(
    'u.employeeID', 
    'u.name', 
    'lt.id', 
    'lt.name', 
    'ltr.max_leave', 
    'ulec.carry_forward', 
    'lc.id',
    'lc.name',
    'lc.start_date',
    'lc.end_date'
)->get();


$leaveTypes = DB::table('leave_types')->where('status', 'ACTIVE')->get();


// dd($monthsInCycle);
        return view('user_view.setting',compact('users','title','salary_templates','users_for_salary','monthsInCycle','dataofcurrentyear','leaveSummary','startDate','endDate','leaveTypeId','leaveTypes'));
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

    public function createCalendraMaster(Request $request){
        $data = $request->validate([
            'year' => 'required',
            'weekOffHolidaySelect' => '',
            'weekoff' => 'array',
            'holiday_date' => '',
            'holiday_name' => '',
            'holiday_desc' => '',
            'working_start_time' => '',
            'working_end_time' => '',
        ]);

        $year = $data['year'];
        $loginUserInfo = Auth::user();

if($data['weekOffHolidaySelect'] == 'weekoff'){

    $dataofyearcal = DB::table('calendra_masters')
    ->where('organisation_id', '=', $loginUserInfo->organisation_id)
    ->where('year', '=', $year)
    ->get();  // Correct the typo here

    if($dataofyearcal->count() == 365 || $dataofyearcal->count() == 366){

        return redirect()->route('user.setting')->with('error','Calendra IS Already Created Please Update Leaves');

    }

$weekoffs = $data['weekoff']; // this contain array
$weekdaysGlobal = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
$weekoffsDays = [];
for($i = 0; $i < count($weekoffs); $i++){
    for($j = 0; $j <count($weekdaysGlobal); $j++){
        if($weekoffs[$i] == $j){

            array_push($weekoffsDays,$weekdaysGlobal[$j]);

        }

    }

}



    if(checkdate(2, 29, $year)){

        $loopcount = 366;
    
    }else{
    
        $loopcount = 365;
    
    }
    // Start with January 1st of that year
$startDate = new \DateTime("$year-01-01");

for ($i = 0; $i < $loopcount; $i++) {

    if(in_array($startDate->format('l'),$weekoffsDays)){

        $weekOffStaus = "Yes";

    }else{

        $weekOffStaus = "No";

    }


    $status = DB::table('calendra_masters')->insert([

        'organisation_id' => $loginUserInfo->organisation_id,
        'year' => $year,
        'date' => $startDate->format('Y-m-d'),
        'day' => $startDate->format('l'),
        'week_off' => $weekOffStaus,
        'holiday' => null,
        'holiday_name' => null,
        'holiday_desc' => null,
        'working_start_time' => $data['working_start_time'],
        'working_end_time' => $data['working_end_time'],
        'created_at' => NOW(),
        'updated_at' => NOW(),

    ]);

    $startDate->modify('+1 day');
}

if($status){

    return redirect()->route('user.setting')->with('success','Calendra Created Successfully!!');

}

}elseif($data['weekOffHolidaySelect'] == 'holiday'){


$dataofyearcal = DB::table('calendra_masters')
    ->where('organisation_id', '=', $loginUserInfo->organisation_id)
    ->where('year', '=', $year)
    ->get();  // Correct the typo here


if($dataofyearcal->count() == 365 || $dataofyearcal->count() == 366){

   $status = DB::table('calendra_masters')
    ->where('organisation_id', '=', $loginUserInfo->organisation_id)
    ->where('year', '=', $year)
    ->where('date', '=', $data['holiday_date'])
    ->update([
        
        'holiday' => 'Yes',
        'holiday_name' => $data['holiday_name'],
        'holiday_desc' => $data['holiday_desc'],
]); 

if($status){

    return redirect()->route('user.setting')->with('success','Holiday Updated Successfully!!');

}

}

//route

return redirect()->route('user.setting')->with('error','Calendra Is Not Created Yet');

}



// echo $loopcount;
// exit();


    }

    public function insertSalaryTempCTC(Request $request){

        $data = $request->validate([
            'user_id' => 'required',
            'trmplate_id' => 'required',
            'ctc' => 'required',
        ]);

        $insertStatus = DB::table('employee_salaries')
        ->where('user_id',$data['user_id'])
        ->get();

        // dd($insertStatus);

        if($insertStatus->isNotEmpty()){

            $status = DB::table('employee_salaries')
            ->where('user_id',$data['user_id'])
            ->update([
                'user_id' => $data['user_id'],
                'salary_template_id' => $data['trmplate_id'],
                'user_ctc' => $data['ctc'],
                'created_at' => NOW(),
                'updated_at' => NOW(),
    
            ]);
    
            if($status){
    
                return redirect()->route('user.setting')->with('success','Salary Updated!!');
    
            }

            return redirect()->route('user.setting')->with('error','Salary Not Updated!!');



        }else{

            $status = DB::table('employee_salaries')->insert([

                'user_id' => $data['user_id'],
                'salary_template_id' => $data['trmplate_id'],
                'user_ctc' => $data['ctc'],
                'created_at' => NOW(),
                'updated_at' => NOW(),
    
            ]);
    
            if($status){
    
                return redirect()->route('user.setting')->with('success','Salary Inserted!!');
    
            }
            return redirect()->route('user.setting')->with('error','Salary Not Updated!!');



        }


    }

        public function processSalary(Request $request){
            $data = $request->validate([
                'cycle_id' => 'required',
                'selected_month' => 'required',
                
            ]);

            $loginUserInfo = Auth::user();
        
        $users = DB::table('users')
        ->where('organisation_id', '=', $loginUserInfo->organisation_id)
        ->where('user_status', '=', 'Active')
        //    ->where('id', '=', 2) //This is for testing, after function body ready remove this condition
        ->get();

        $orgsalaryComponents = DB::table('org_salary_components')->where('organisation_id',$loginUserInfo->organisation_id)->get();

        //    dd($orgsalaryComponents);

        $allemployeeSalaryDetails = [];
        $allEmployeeSalary = [];
        $allSalaryComponents = [];

        foreach($users as $user){

            $employeeSalaryDetails = [];

        //Calculate total days in selected months
        $monthYearString = $data['selected_month'];

        $date = Carbon::createFromFormat('F Y', $monthYearString);
        
        $monthName = $date->format('F'); // April (Alphbets month)
        $monthNumber = $date->format('m'); // 4 (numeric month)
        $year = $date->format('Y');  // 2025

        $month = date('n', strtotime($monthName));
        $dateforDays = Carbon::create($year, $month, 1);
        
        $totalDaysInSelectedMonth = $dateforDays->daysInMonth; // Total  Days in selected month

        //    dd($totalDaysInSelectedMonth);

        //Calcualte Week Offs in selected month and holidays

        $weekOffsAndHolidays = DB::table('calendra_masters')
        ->whereYear('date', $year)
        ->whereMonth('date', $month) // or $monthNumber
        ->where('organisation_id',$loginUserInfo->organisation_id)
        ->where(function($query) {
            $query->where('week_off', 'Yes')
                ->orWhere('holiday', 'Yes');
        })->get();

        $totalWorkingDaysInMonth = $totalDaysInSelectedMonth - count($weekOffsAndHolidays);  // Total Working Days in the selected month

        $presentDays = DB::table('login_logs')
        ->whereYear('login_date', $year)
        ->whereMonth('login_date', $month) // or $monthNumber
        ->where('user_id', $user->id)
        ->count();



        //Calculate Taken Leave by User in selected month
        $leaves = DB::table('leave_applies')
        ->where('user_id',$user->id)
        ->whereYear('start_date',$year)
        ->whereMonth('start_date',$month)
        ->where('leave_approve_status', 'Approved')
        ->get();

        //    dd($leaves);
    
    $totalLeaveDays = 0;
    
    foreach ($leaves as $leave) {
        $fromDate = Carbon::parse($leave->start_date);
        $toDate = Carbon::parse($leave->end_date);
    
        // If leave is for the same day
        if ($fromDate->eq($toDate)) {
            if ($leave->half_day === 'First Half' || $leave->half_day === 'Second Half') {
                $totalLeaveDays += 0.5;
            } else {
                $totalLeaveDays += 1;
            }
        } else {
            // Multi-day leave: count days between from and to (inclusive)
            $days = $fromDate->diffInDays($toDate) + 1;
            $totalLeaveDays += $days;
        }
    }

    
    $noOfDaysForPaySalary = $totalWorkingDaysInMonth - $totalLeaveDays;

    $workingDaysByUser = $totalDaysInSelectedMonth - $totalLeaveDays;

    $getCtcAndST = DB::table('employee_salaries')->where('user_id',$user->id)->first();

    $salaryComponents = DB::table('org_salary_template_components')->where('salary_template_id',$getCtcAndST->salary_template_id)->get();

    // dd($salaryComponents);

    $getCtcPerMonth = $getCtcAndST->user_ctc/12;

    // $getCtcPerMonth = number_format($getCtcAndST->user_ctc/12, 2);

    $employeeSalary = [];


    foreach($salaryComponents as $SC){

        $components_id = $SC->org_comp_id;
        $value = 0;
        $type = $SC->type;

        if($SC->calculation_type == 'Percentage'){

            if($SC->org_comp_id == 2){  //House Rent Allowance (HRA)

                $basicSalary = $getCtcPerMonth*50/100;

                $value = $basicSalary*$SC->value/100;

                $employeeSalary[$SC->id] = [
                    'value' => $value,
                    'type' => $type,
                    'components_id' => $components_id
                ];

            }else{

            $value = $getCtcPerMonth*$SC->value/100;

            $employeeSalary[$SC->org_comp_id] = [
                'value' => $value,
                'type' => $type,
                'components_id' => $components_id
            ];

        }

        }elseif($SC->calculation_type == 'Fixed'){

            $value = $SC->value;

            $employeeSalary[$SC->org_comp_id] = [
                'value' => $value,
                'type' => $type,
                'components_id' => $components_id
            ];



        }elseif($SC->calculation_type == 'Others'){

            $value = 0;

            $employeeSalary[$SC->org_comp_id] = [
                'value' => $value,
                'type' => $type,
                'components_id' => $components_id
            ];

        }

        
    }

    foreach($salaryComponents as $SCSA){

        if($SCSA->org_comp_id == 5 && $SCSA->calculation_type == 'Calculative' && $SCSA->type == 'Earning'){
            $SumOfEarnings = 0;
            foreach($employeeSalary as $ES){
                if($ES['type'] == 'Earning'){
                    $SumOfEarnings += $ES['value'];
                }
            }
            $components_id = $SCSA->org_comp_id;
            // $value = $getCtcPerMonth - $SumOfEarnings;
            $value = max(0, $getCtcPerMonth - $SumOfEarnings);
            $type = $SCSA->type;

            $employeeSalary[$SCSA->org_comp_id] = [
                'value' => $value,
                'type' => $type,
                'components_id' => $components_id
            ];

        }elseif($SCSA->org_comp_id == 11 && $SCSA->calculation_type == 'Calculative' && $SCSA->type == 'Earning'){

            $value = 0;

            $employeeSalary[$SCSA->id] = [
                'value' => $value,
                'type' => $SCSA->type,
                'components_id' => $SCSA->org_comp_id
            ];


        }elseif($SCSA->org_comp_id == 10 && $SCSA->calculation_type == 'Calculative' && $SCSA->type == 'Deduction'){

            $value = 0;

            $employeeSalary[$SCSA->id] = [
                'value' => $value,
                'type' => $SCSA->type,
                'components_id' => $SCSA->org_comp_id
            ];


        }
    }

    $totalEarning = 0;
    $totalDeduction = 0;

    foreach($employeeSalary as $empSal){

        if($empSal['type'] == 'Earning'){

            $totalEarning = $totalEarning + $empSal['value'];

        }elseif($empSal['type'] == 'Deduction'){

            $totalDeduction = $totalDeduction + $empSal['value'];

        }

    }

    $employeeSalaryDetails[$user->id] = [
        'user_id' => $user->id,
        'salary_cycle_id' => $data['cycle_id'],
        'salary_month' => $monthYearString,
        'total_days_month' => $totalDaysInSelectedMonth,
        'week_offs_holidays' => count($weekOffsAndHolidays),
        'total_working_daysMonth' => $totalWorkingDaysInMonth,
        'leave_taken' => $totalLeaveDays,
        'present_days' => $presentDays,
        'absent_days' => $totalWorkingDaysInMonth - $presentDays,
        'total_earning' => round($totalEarning, 2),
        'total_deducation' => round($totalDeduction, 2),
        'net_amount' => round($totalEarning - $totalDeduction, 2),
    ];

    // $employeeSalary['2'] = $employeeSalary;

    array_push($allemployeeSalaryDetails,$employeeSalaryDetails);
    // array_push($allEmployeeSalary,$employeeSalary);

    array_push($allEmployeeSalary, [
        'user_id' => $user->id,
        'employee_name' => $user->name,
        'salary_temp_id' => $getCtcAndST->salary_template_id,
        'salary_details' => $employeeSalary
    ]);

        } 
    // dd($orgsalaryComponents);
        //    dd($allEmployeeSalary);
        //    echo "<pre>";
        //    print_r($orgsalaryComponents);

        //    echo "<pre>";
        //    print_r($allEmployeeSalary);
            
        // dd($allemployeeSalaryDetails);

        // Call the new function to insert data into the payrolls table
        // Insert data into the payrolls table
        // foreach ($allemployeeSalaryDetails as $employeeSalaryDetail) {
        //     foreach ($employeeSalaryDetail as $salaryDetail) {
        //         $payrollId = DB::table('payrolls')->insertGetId([
        //             'organisation_id'    => Auth::user()->organisation_id,
        //             'user_id'            => $salaryDetail['user_id'],
        //             'salary_cycle_id'    => $salaryDetail['salary_cycle_id'],
        //             'salary_month'       => $salaryDetail['salary_month'],
        //             'days_count_month'   => $salaryDetail['total_days_month'],
        //             'week_offs'          => $salaryDetail['week_offs_holidays'],
        //             'holidays'           => 0, // Adjust if holidays are tracked separately
        //             'present_days_count' => $salaryDetail['present_days'],
        //             'absent_days'        => $salaryDetail['absent_days'],
        //             'total_earnings'     => round($salaryDetail['total_earning'] ?? 0, 2),
        //             'total_dedcutions'   => round($salaryDetail['total_deducation'] ?? 0, 2),
        //             'net_amount'         => round(($salaryDetail['total_earning'] ?? 0) - ($salaryDetail['total_deducation'] ?? 0), 2),
        //             'created_at'         => now(),
        //             'updated_at'         => now(),
        //         ]);

        //         // Insert into payroll_deductions table
        //         foreach ($allEmployeeSalary as $employee) {
        //             if ($employee['user_id'] == $salaryDetail['user_id']) {
        //                 foreach ($employee['salary_details'] as $componentId => $component) {
        //                     DB::table('payroll_deductions')->insert([
        //                         'payroll_id'           => $payrollId,
        //                         'user_id'              => $salaryDetail['user_id'],
        //                         'salary_components_id' => $component['components_id'],
        //                         'components_type'      => strtoupper($component['type']),
        //                         'amount'               => round($component['value'], 2),
        //                         'created_at'           => now(),
        //                         'updated_at'           => now(),
        //                     ]);
        //                 }
        //             }
        //         }
        //     }
        // }
        return view('user_view.salary_lookup',compact('orgsalaryComponents','allEmployeeSalary', 'allemployeeSalaryDetails'));

        
        }

   public function processSalaryDetails(Request $request)
{
    // Unserialize data
    $allemployeeSalaryDetails = unserialize($request->input('allemployeeSalaryDetails'));
    $allEmployeeSalary = unserialize($request->input('allEmployeeSalary'));
    $updatedSalaryData = $request->input('salary');

    foreach ($allemployeeSalaryDetails as $employeeSalaryDetail) {
        foreach ($employeeSalaryDetail as $salaryDetail) {
            $userId = $salaryDetail['user_id'];

            // Use updated totals if present
            $totalEarnings = isset($updatedSalaryData[$userId]['total_earning'])
                ? round($updatedSalaryData[$userId]['total_earning'], 2)
                : round($salaryDetail['total_earning'] ?? 0, 2);
                
            $totalDeductions = isset($updatedSalaryData[$userId]['total_deduction'])
                ? round($updatedSalaryData[$userId]['total_deduction'], 2)
                : round($salaryDetail['total_deducation'] ?? 0, 2);
                
            $netAmount = isset($updatedSalaryData[$userId]['net_salary'])
                ? round($updatedSalaryData[$userId]['net_salary'], 2)
                : round(($salaryDetail['total_earning'] ?? 0) - ($salaryDetail['total_deducation'] ?? 0), 2);
                

            // Insert into the payrolls table
            $payrollId = DB::table('payrolls')->insertGetId([
                'organisation_id'    => Auth::user()->organisation_id,
                'user_id'            => $userId,
                'salary_cycle_id'    => $salaryDetail['salary_cycle_id'],
                'salary_month'       => $salaryDetail['salary_month'],
                'days_count_month'   => $salaryDetail['total_days_month'],
                'week_offs'          => $salaryDetail['week_offs_holidays'],
                'holidays'           => 0, // Adjust if holidays are tracked separately
                'present_days_count' => $salaryDetail['present_days'],
                'absent_days'        => $salaryDetail['absent_days'],
                'total_earnings'     => $totalEarnings,
                'total_dedcutions'   => $totalDeductions,
                'net_amount'         => $netAmount,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // Insert into payroll_deductions table
            // Get the updated salary details from the request
                $updatedSalaryDetails = $request->input('salary', []);

                // Insert into payroll_deductions table
                foreach ($allEmployeeSalary as $employee) {
                    if ($employee['user_id'] == $userId) {
                        foreach ($employee['salary_details'] as $componentId => $component) {
                            // Check if the component exists in the updated form data
                            $amount = isset($updatedSalaryDetails[$userId][$componentId]) 
                                    ? round($updatedSalaryDetails[$userId][$componentId], 2) 
                                    : round($component['value'], 2);

                            DB::table('payroll_deductions')->insert([
                                'payroll_id'           => $payrollId,
                                'user_id'              => $userId,
                                'salary_components_id' => $componentId,
                                'components_type'      => strtoupper($component['type']),
                                'amount'               => $amount,
                                'created_at'           => now(),
                                'updated_at'           => now(),
                            ]);
                        }
                    }
                }
        }
    }

    // Redirect back with a success message
    return redirect()->route('user.setting')->with('success', 'Salary details processed successfully!');
}

    

// public function showLeaveSummary()
// {
    
// dd($leaveSummary);
//     return view('leave.summary', compact('leaveSummary'));
// }




}
