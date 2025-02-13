<?php

namespace App\Http\Controllers;
use App\Models\employee_type;
use App\Models\User;
use App\Models\emp_details;
use App\Models\emp_contact_details;
use App\Models\organisation_department;
use App\Models\organisation_designation;
use Illuminate\Http\Request;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class empDetailFormController extends Controller
{
    public function index(){

        $loginUserInfo = Auth::user();
        // echo $loginUserInfo->id;
        // echo $loginUserInfo->organisation_id;

          //     $results = DB::table('organisation_designations')
    // ->join('organisation_departments', 'organisation_designations.department_id', '=', 'organisation_departments.id')
    // ->join('branches', 'organisation_designations.branch_id', '=', 'branches.id')
    // ->select('organisation_departments.name as department_name', 'organisation_designations.name as designation_name','organisation_designations.id as designation_id','branches.id as branch_id','branches.name as branch_name')
    // ->where('organisation_departments.organisation_id', '=', $id) // Adding a WHERE condition to filter by department name
    // ->get();

              $results = DB::table('emp_details')
    ->join('employee_types', 'emp_details.employee_type', '=', 'employee_types.id')
    ->join('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id')
    ->join('users', 'emp_details.reporting_manager', '=', 'users.id')
    ->join('organisation_departments', 'emp_details.department', '=', 'organisation_departments.id')
    ->select('emp_details.employee_type as employee_type','employee_types.name as employee_type_name','emp_details.employee_no as employee_no','emp_details.employee_name as employee_name',
             'emp_details.Joining_date as Joining_date','emp_details.reporting_manager as reporting_manager_id','users.name as reporting_manager_name','emp_details.total_experience as total_experience',
             'organisation_designations.name as role_name','emp_details.designation as designation_id','organisation_departments.name as department_name','emp_details.department as department_id','emp_details.gender as gender',
             'emp_details.date_of_birth as date_of_birth','emp_details.blood_group as blood_group','emp_details.nationality as nationality',
             'emp_details.religion as religion','emp_details.marital_status as marital_status','emp_details.anniversary_date as anniversary_date',
             'emp_details.universal_account_number as universal_account_number','emp_details.provident_fund as provident_fund','emp_details.esic_no as esic_no',)
    ->where('emp_details.user_id', '=', $loginUserInfo->id) // Adding a WHERE condition to filter by department name
    ->get();

    // dd($results);

        $users = User::where('organisation_id', $loginUserInfo->organisation_id)->get();
        $departments = organisation_department::where('organisation_id', $loginUserInfo->organisation_id)->get();
        $designations = organisation_designation::where('organisation_id', $loginUserInfo->organisation_id)->get();

        $emp_types = employee_type::get();


        return view('user_view.emp_details',compact('emp_types','users','departments','designations','results'));
        // return view('user_view.emp_details');
    }

    public function loadcontectuser(){
        $loginUserInfo = Auth::user();
        // echo $loginUserInfo->id;
        $emp_contact_datas = emp_contact_details::where('user_id', $loginUserInfo->id)->get();
        // dd($emp_contact_datas);
        return view('user_view.emp_contact_details',compact('emp_contact_datas'));
    }

    public function loadeducationuser(){
        return view('user_view.emp_edu_details');
    }

    public function loadbankuser(){

        return view('user_view.emp_bank_details');

    }

    public function loadfamilyuser(){

        return view('user_view.emp_family_details');

    }

    public function loadpreempuser(){

        return view('user_view.emp_pre_empl_det');

    }

    public function insertDetail(Request $request){

        $validated = $request->validate([
            'emp_type' => 'required',
            'employee_no' => 'required',
            'employee_name' => 'required',
            'joining_date' => 'required',
            'reporting_manager' => 'required',
            'total_exp' => 'required',
            'designation' => 'required',
            'department' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'blood_group' => 'required',
            'nationality' => 'required',
            'religion' => 'required',
            'marital_status' => 'required',
            'anniversary_date' => 'required',
            'uan' => 'required',
            'pf' => 'required',
            'esic' => 'required',

        ]);
    

        $data = $request->all();
        $loginUserInfo = Auth::user();
        

        // dd($data);


// Using Query Builder to insert data
     $emp_detail_status =  DB::table('emp_details')->insert([
    'employee_type' => $data['emp_type'],
    'employee_no' => $data['employee_no'],
    'employee_name' => $data['employee_name'],
    'Joining_date' => $data['joining_date'],
    'reporting_manager' => $data['reporting_manager'],
    'total_experience' => $data['total_exp'],
    'designation' => $data['designation'],
    'department' => $data['department'],
    'gender' => $data['gender'],
    'date_of_birth' => $data['birth_date'],
    'blood_group' => $data['blood_group'],
    'nationality' => $data['nationality'],
    'religion' => $data['religion'],
    'marital_status' => $data['marital_status'],
    'anniversary_date' => $data['anniversary_date'],
    'universal_account_number' => $data['uan'],
    'provident_fund' => $data['pf'],
    'esic_no' => $data['esic'],
    'user_id' => $loginUserInfo->id,
    'created_at' => NOW(),
    'updated_at' => NOW(),
     ]);

     if($emp_detail_status){

        return redirect()->route('user.contact');

     }


    }

    public function insertcontact(Request $request){

        $validated = $request->validate([
            'building_no_permanent' => 'required',
            'name_of_premises_permanent' => 'required',
            'nearby_landmark_permanent' => 'required',
            'road_street_permanent' => 'required',
            'nationality_permanent' => 'required',
            'pincode_permanent' => 'required',
            'state_permanent' => 'required',
            'city_permanent' => 'required',
            'district_permanent' => 'required',

            'building_no_correspondence' => 'required',
            'name_of_premises_correspondence' => 'required',
            'nearby_landmark_correspondence' => 'required',
            'road_street_correspondence' => 'required',
            'nationality_correspondence' => 'required',
            'pincode_correspondence' => 'required',
            'city_correspondence' => 'required',
            'state_correspondence' => 'required',
            'district_correspondence' => 'required',

            'Offical_Phone_Number' => 'required',
            'Alternate_Phone_Number' => 'required',
            'Email_Addres' => 'required',
            'Offical_Email_Address' => 'required',

            'Emergency_Contact_Person' => 'required',
            'Emergency_Contact_Number' => 'required',

        ]);

        $data = $request->all();
        $loginUserInfo = Auth::user();

        // dd($data);

        // Using Query Builder to insert data
     $emp_contact_status =  DB::table('emp_contact_details')->insert([
        'per_building_no' => $data['building_no_permanent'],
        'per_name_of_premises' => $data['name_of_premises_permanent'],
        'per_nearby_landmark' => $data['nearby_landmark_permanent'],
        'per_road_street' => $data['road_street_permanent'],
        'per_country' => $data['nationality_permanent'],
        'per_pincode' => $data['pincode_permanent'],
        'per_district' => $data['district_permanent'],
        'per_city' => $data['city_permanent'],
        'per_state' => $data['state_permanent'],

        'cor_building_no' => $data['building_no_correspondence'],
        'cor_name_of_premises' => $data['name_of_premises_correspondence'],
        'cor_nearby_landmark' => $data['nearby_landmark_correspondence'],
        'cor_road_street' => $data['road_street_correspondence'],
        'cor_country' => $data['nationality_correspondence'],
        'cor_pincode' => $data['pincode_correspondence'],
        'cor_district' => $data['district_correspondence'],
        'cor_city' => $data['city_correspondence'],
        'cor_state' => $data['state_correspondence'],

        'offical_phone_number' => $data['Offical_Phone_Number'],
        // 'alternate_phone_number' => $data['Alternate_Phone_Number'],
        'email_address' => $data['Email_Addres'],
        'offical_email_address' => $data['Offical_Email_Address'],

        'emergency_contact_person' => $data['Emergency_Contact_Person'],
        'emergency_contact_number' => $data['Emergency_Contact_Number'],
        'user_id' => $loginUserInfo->id,
        'created_at' => NOW(),
        'updated_at' => NOW(),
         ]);
    
         if($emp_contact_status){
    
            return redirect()->route('user.edu');
    
         }
    

    }
}
