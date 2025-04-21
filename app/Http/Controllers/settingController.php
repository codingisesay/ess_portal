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
    public function showsetting()
    {
        $title = "Settings";
        $loginUserInfo = Auth::user();
       
        $users = User::where('organisation_id', $loginUserInfo->organisation_id)->paginate(10);

        // $users_for_salary = User::where('organisation_id', $loginUserInfo->organisation_id)->get();
        $users_for_salary = DB::table('users')
        ->leftjoin('employee_salaries','users.id','=','employee_salaries.user_id')
        ->leftjoin('org_salary_templates','employee_salaries.salary_template_id','=','org_salary_templates.id')
        ->select('users.employeeID as emp_employeeID',
        'users.id as user_id',
        'org_salary_templates.name as org_salary_templates_name',
        'org_salary_templates.id as org_salary_templates_id',
        'employee_salaries.user_ctc as user_ctc'
        )
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

// dd($monthsInCycle);
        return view('user_view.setting',compact('users','title','salary_templates','users_for_salary','monthsInCycle','dataofcurrentyear'));
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
       ->where('id', '=', 2) //This is for testing, after function body ready remove this condition
       ->get();

       //Calculate total days in selected months

       $monthYearString = $data['selected_month'];

       $date = Carbon::createFromFormat('F Y', $monthYearString);
       
       $monthName = $date->format('F'); // April (Alphbets month)
       $monthNumber = $date->format('m'); // 4 (numeric month)
       $year = $date->format('Y');  // 2025

       $month = date('n', strtotime($monthName));
       $dateforDays = Carbon::create($year, $month, 1);
       
       $totalDaysInSelectedMonth = $dateforDays->daysInMonth; // Total  Days in selected month

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

    //    dd($totalWorkingDaysInMonth);

       foreach($users as $user){
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

dd($noOfDaysForPaySalary);


       } 
        



       
    }

}
