<?php

namespace App\Http\Controllers;
use App\Models\employee_type;
use App\Models\User;
use App\Models\bank;
use App\Models\branche;
use App\Models\emp_previous_employment;
use App\Models\emp_family_details;
use App\Models\emp_education;
use App\Models\emp_bank_details;
use App\Models\emp_details;
use App\Models\countrie;
use App\Models\userHomePageStatus;
use App\Models\emp_contact_details;
use App\Models\organisation_department;
use App\Models\organisation_designation;
use Illuminate\Http\Request;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class empDetailFormController extends Controller
{
    public function index(){

        $loginUserInfo = Auth::user();
        $loginUserInfo->id;
        $loginUserInfo->organisation_id;

        $users = User::where('organisation_id', $loginUserInfo->organisation_id)->get();
        $departments = organisation_department::where('organisation_id', $loginUserInfo->organisation_id)->get();
        $designations = organisation_designation::where('organisation_id', $loginUserInfo->organisation_id)->get();
        $branches = branche::where('organisation_id', $loginUserInfo->organisation_id)->get();

        // dd($branches);

        $emp_types = employee_type::get();

        $results = DB::table('emp_details')
        ->join('employee_types', 'emp_details.employee_type', '=', 'employee_types.id')
        ->join('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id')
        ->join('users', 'emp_details.reporting_manager', '=', 'users.id')
        ->join('organisation_departments', 'emp_details.department', '=', 'organisation_departments.id')
        ->join('branches','emp_details.branch_id', '=', 'branches.id')
        ->select('emp_details.employee_type as employee_type','employee_types.name as employee_type_name','emp_details.employee_no as employee_no','emp_details.employee_name as employee_name',
                 'emp_details.Joining_date as Joining_date','emp_details.reporting_manager as reporting_manager_id','users.name as reporting_manager_name','emp_details.total_experience as total_experience',
                 'organisation_designations.name as role_name','emp_details.designation as designation_id','organisation_departments.name as department_name','emp_details.department as department_id','emp_details.gender as gender',
                 'emp_details.date_of_birth as date_of_birth','emp_details.blood_group as blood_group','emp_details.nationality as nationality',
                 'emp_details.religion as religion','emp_details.marital_status as marital_status','emp_details.anniversary_date as anniversary_date',
                 'emp_details.universal_account_number as universal_account_number','emp_details.provident_fund as provident_fund','emp_details.esic_no as esic_no',
                 'emp_details.branch_id as branch_id', 'branches.name as branch_name')

        ->where('emp_details.user_id', '=', $loginUserInfo->id) // Adding a WHERE condition to filter by department name
        ->get();


        return view('user_view.emp_details',compact('emp_types','users','departments','designations','results','branches'));
        // return view('user_view.emp_details');
    }

    public function loadcontectuser(){
        $loginUserInfo = Auth::user();
        // echo $loginUserInfo->id;
        $emp_contact_datas = emp_contact_details::where('user_id', $loginUserInfo->id)->get();
        $countrys = countrie::get();
        // dd($emp_contact_datas);
        return view('user_view.emp_contact_details',compact('emp_contact_datas','countrys'));
    }

    public function loadeducationuser(){
        $loginUserInfo = Auth::user();
        $emp_eduction_details = emp_education::where('user_id', $loginUserInfo->id)->get();
        return view('user_view.emp_edu_details',compact('emp_eduction_details'));
    }

    public function loadbankuser(){
        $banks = bank::orderBy('id', 'asc')->get();
        $loginUserInfo = Auth::user();

        $countrys = DB::table('countries')->get();

        $emp_bank_datas = DB::table('emp_bank_details')
        // First join for per_bank_name
        ->join('banks as per_bank', 'emp_bank_details.per_bank_name', '=', 'per_bank.id')
        // Second join for sal_bank_name
        ->join('banks as sal_bank', 'emp_bank_details.sal_bank_name', '=', 'sal_bank.id')
        // Select all columns from emp_bank_details and the bank names
        ->select('emp_bank_details.*', 
                  'emp_bank_details.per_bank_name as per_bank_id',
                  'emp_bank_details.sal_bank_name as sal_bank_id',
                 'per_bank.name as per_bank_name', 
                 'sal_bank.name as sal_bank_name')
        // Filtering by user_id
        ->where('emp_bank_details.user_id', '=', $loginUserInfo->id)
        ->get();

      
        // echo $loginUserInfo->id;
        // $emp_bank_datas = emp_bank_details::where('user_id', $loginUserInfo->id)->get();

       
        return view('user_view.emp_bank_details',compact('banks','emp_bank_datas','countrys'));

    }

    public function loadfamilyuser(){
        $loginUserInfo = Auth::user();
       $familyDetails = emp_family_details::where('user_id', $loginUserInfo->id)->get();
        return view('user_view.emp_family_details',compact('familyDetails'));

    }

    public function insertfamity(Request $request){

        $data = $request->validate([
            'name' => 'required|array',
            'relation' => 'required|array',
            'birth_date' => 'required|array',
            'gender' => 'required|array',
            'age' => 'required',
            'dependent' => 'required|array',
            'phone_number' => 'nullable|array',
        ]);
        
        $loginUserInfo = Auth::user();

        $emp_Family_details = emp_family_details::where('user_id', $loginUserInfo->id)->get();
        if($emp_Family_details->isNotEmpty()){
            $deleteStaus = emp_family_details::where('user_id', $loginUserInfo->id)->delete();

                // Loop through the validated data and insert into the database
        foreach ($data['name'] as $index => $name) {
            // Ensure that all fields for this index exist, and if not, assign null or handle accordingly
            $updatestatus = DB::table('emp_family_details')->insert([
                'name' => isset($data['name'][$index]) ? $data['name'][$index] : null,
                'relation' => isset($data['relation'][$index]) ? $data['relation'][$index] : null,
                'birth_date' => isset($data['birth_date'][$index]) ? $data['birth_date'][$index] : null,
                'gender' => isset($data['gender'][$index]) ? $data['gender'][$index] : null,
                'age' => isset($data['age'][$index]) ? $data['age'][$index] : null,
                'dependent' => isset($data['dependent'][$index]) ? $data['dependent'][$index] : null,
                'phone_number' => isset($data['phone_number'][$index]) ? $data['phone_number'][$index] : null,
                'user_id' => $loginUserInfo->id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }

        if($updatestatus){
        
            // session()->flash('success', 'Your Family Details has been updated successfully!');
            return redirect()->route('user.preemp')->with('success', 'Your Family Details has been updated successfully!');
    
         }else{

            // session()->flash('error', 'Your Family Details has Not been updated successfully!');
            return redirect()->route('user.preemp')->with('error', 'Your Family Details has been updated successfully!');
            // return redirect()->route('user.preemp');

         }

        }else{

                // Loop through the validated data and insert into the database
        foreach ($data['name'] as $index => $name) {
            // Ensure that all fields for this index exist, and if not, assign null or handle accordingly
           $insertStatus = DB::table('emp_family_details')->insert([
                'name' => isset($data['name'][$index]) ? $data['name'][$index] : null,
                'relation' => isset($data['relation'][$index]) ? $data['relation'][$index] : null,
                'birth_date' => isset($data['birth_date'][$index]) ? $data['birth_date'][$index] : null,
                'gender' => isset($data['gender'][$index]) ? $data['gender'][$index] : null,
                'age' => isset($data['age'][$index]) ? $data['age'][$index] : null,
                'dependent' => isset($data['dependent'][$index]) ? $data['dependent'][$index] : null,
                'phone_number' => isset($data['phone_number'][$index]) ? $data['phone_number'][$index] : null,
                'user_id' => $loginUserInfo->id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }
        if($insertStatus){
        
            // session()->flash('success', 'Your Family Details has been Inserted successfully!');
            // return redirect()->route('user.preemp');
            return redirect()->route('user.preemp')->with('success', 'Your Family Details has been inserted successfully!');
    
         }else{

            // session()->flash('error', 'Your Family Details has Not been Inserted successfully!');
            // return redirect()->route('user.preemp');

            return redirect()->route('user.preemp')->with('error', 'Your Family Details has not been inserted successfully!');

         }

        }
        

    }

    public function loadpreempuser(){
       
        $loginUserInfo = Auth::user();

        $countrys = countrie::get();

        $emp_preEmp_details = emp_previous_employment::where('user_id', $loginUserInfo->id)->get();
   
// dd($emp_preEmp_details);

        return view('user_view.emp_pre_empl_det',compact('emp_preEmp_details','countrys'));

    }

    public function insertPreEmp(Request $request){

        $data = $request->validate([
            'employer_name' => 'required|array',
            'country' => 'required|array',
            'city' => 'required|array',
            'from_date' => 'required|array',
            'to_date' => 'required',
            'designation' => 'required|array',
            'last_drawn_salary' => 'nullable|array',
            'relevant_experience' => 'required',
            'reason_for_leaving' => 'required|array',
            'major_responsibilities' => 'nullable|array',
            
            
            
        ]);
        
        $loginUserInfo = Auth::user();

        $emp_preEmp_details = emp_previous_employment::where('user_id', $loginUserInfo->id)->get();

        // dd($emp_preEmp_details);

        if($emp_preEmp_details->isNotEmpty()){

            // $deleteStaus = emp_previous_employment::destroy();

            $deleteStaus = emp_previous_employment::where('user_id', $loginUserInfo->id)->delete();
                                     // Loop through the validated data and insert into the database
        foreach ($data['employer_name'] as $index => $employer_name) {
            // Ensure that all fields for this index exist, and if not, assign null or handle accordingly
          $updatestatus = DB::table('emp_previous_employments')->insert([
                'employer_name' => isset($data['employer_name'][$index]) ? $data['employer_name'][$index] : null,
                'country' => isset($data['country'][$index]) ? $data['country'][$index] : null,
                'city' => isset($data['city'][$index]) ? $data['city'][$index] : null,
                'from_date' => isset($data['from_date'][$index]) ? $data['from_date'][$index] : null,
                'to_date' => isset($data['to_date'][$index]) ? $data['to_date'][$index] : null,
                'designation' => isset($data['designation'][$index]) ? $data['designation'][$index] : null,
                'last_drawn_annual_salary' => isset($data['last_drawn_salary'][$index]) ? $data['last_drawn_salary'][$index] : null,

                'relevant_experience' => isset($data['relevant_experience'][$index]) ? $data['relevant_experience'][$index] : null,
                'reason_for_leaving' => isset($data['reason_for_leaving'][$index]) ? $data['reason_for_leaving'][$index] : null,
                'major_responsibilities' => isset($data['major_responsibilities'][$index]) ? $data['major_responsibilities'][$index] : null,

                'user_id' => $loginUserInfo->id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }

        if($updatestatus){
        
            // session()->flash('success', 'Data has been updated successfully!');
            return redirect()->route('user.docupload')->with('success','Data has been updated successfully!');
    
         }else{

            // session()->flash('error', 'Data has Not been updated successfully!');
            return redirect()->route('user.docupload')->with('error','No Item Modified!');

         }

        }else{

                            // Loop through the validated data and insert into the database
        foreach ($data['employer_name'] as $index => $employer_name) {
            // Ensure that all fields for this index exist, and if not, assign null or handle accordingly
          $InsertStaus =  DB::table('emp_previous_employments')->insert([
                'employer_name' => isset($data['employer_name'][$index]) ? $data['employer_name'][$index] : null,
                'country' => isset($data['country'][$index]) ? $data['country'][$index] : null,
                'city' => isset($data['city'][$index]) ? $data['city'][$index] : null,
                'from_date' => isset($data['from_date'][$index]) ? $data['from_date'][$index] : null,
                'to_date' => isset($data['to_date'][$index]) ? $data['to_date'][$index] : null,
                'designation' => isset($data['designation'][$index]) ? $data['designation'][$index] : null,
                'last_drawn_annual_salary' => isset($data['last_drawn_salary'][$index]) ? $data['last_drawn_salary'][$index] : null,

                'relevant_experience' => isset($data['relevant_experience'][$index]) ? $data['relevant_experience'][$index] : null,
                'reason_for_leaving' => isset($data['reason_for_leaving'][$index]) ? $data['reason_for_leaving'][$index] : null,
                'major_responsibilities' => isset($data['major_responsibilities'][$index]) ? $data['major_responsibilities'][$index] : null,

                'user_id' => $loginUserInfo->id,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }

        }
        
        
        if($InsertStaus){
        
            // session()->flash('success', 'Data has been Inserted successfully!');
            // return redirect()->route('user.docupload');
            return redirect()->route('user.docupload')->with('success','Data has been inserted successfully!');
    
         }else{

            // session()->flash('error', 'Data has Not been Inserted successfully!');
            // return redirect()->route('user.docupload');
            return redirect()->route('user.docupload')->with('error','Data has been not inserted successfully!');

         }

    }

    public function loaddocuploaduser(){
        return view('user_view.emp_doc_upload');
    }

    public function insertDetail(Request $request)
{
    $validated = $request->validate([
        'employmentType' => 'required',
        'employeeNo' => 'required',
        'employeeName' => 'required',
        'joiningDate' => 'required',
        'reportingManager' => 'required',
        'totalExperience' => 'required',
        'designation' => 'required',
        'branch' => 'required',
        'department' => 'required',
        'gender' => 'required',
        'dateOfBirth' => 'required',
        'bloodGroup' => 'nullable',
        'nationality' => 'required',
        'religion' => 'required',
        'maritalStatus' => 'required',
        'anniversaryDate' => 'sometimes|required_if:maritalStatus,Married|nullable|date',
        'uan' => 'nullable',
        'providentFund' => 'nullable',
        'esicNo' => 'nullable',
    ]);

    $data = $request->all();
    $data['anniversaryDate'] = $data['anniversaryDate'] ?? null; // Ensure anniversaryDate is always set

    $loginUserInfo = Auth::user();
    $loginUserInfo->id;
// dd($data);
    $users = User::where('organisation_id', $loginUserInfo->organisation_id)->get();
    $empStatus = emp_details::where('user_id', $loginUserInfo->id)->get();

    if ($empStatus->isNotEmpty()) {
        $updatestatus = DB::table('emp_details')
            ->where('user_id', $loginUserInfo->id)
            ->update([
                'employee_type' => $data['employmentType'],
                'employee_no' => $data['employeeNo'],
                'employee_name' => $data['employeeName'],
                'Joining_date' => $data['joiningDate'],
                'reporting_manager' => $data['reportingManager'],
                'total_experience' => $data['totalExperience'],
                'designation' => $data['designation'],
                'branch_id' => $data['branch'],
                'department' => $data['department'],
                'gender' => $data['gender'],
                'date_of_birth' => $data['dateOfBirth'],
                'blood_group' => $data['bloodGroup'],
                'nationality' => $data['nationality'],
                'religion' => $data['religion'],
                'marital_status' => $data['maritalStatus'],
                'anniversary_date' => $data['anniversaryDate'],
                'universal_account_number' => $data['uan'],
                'provident_fund' => $data['providentFund'],
                'esic_no' => $data['esicNo'],
            ]);

        if ($updatestatus) {
            // session()->flash('success', 'Data has been updated successfully!');
            return redirect()->route('user.contact')->with('success', 'Data has been updated successfully!');
        } else {
            // session()->flash('error', 'No Item Modified!');
            return redirect()->route('user.contact')->with('error', 'No Item Modified!');;
        }
    } else {
        $emp_detail_status = DB::table('emp_details')->insert([
            'employee_type' => $data['employmentType'],
            'employee_no' => $data['employeeNo'],
            'employee_name' => $data['employeeName'],
            'Joining_date' => $data['joiningDate'],
            'reporting_manager' => $data['reportingManager'],
            'total_experience' => $data['totalExperience'],
            'designation' => $data['designation'],
            'branch_id' => $data['branch'],
            'department' => $data['department'],
            'gender' => $data['gender'],
            'date_of_birth' => $data['dateOfBirth'],
            'blood_group' => $data['bloodGroup'],
            'nationality' => $data['nationality'],
            'religion' => $data['religion'],
            'marital_status' => $data['maritalStatus'],
            'anniversary_date' => $data['anniversaryDate'],
            'universal_account_number' => $data['uan'],
            'provident_fund' => $data['providentFund'],
            'esic_no' => $data['esicNo'],
            'user_id' => $loginUserInfo->id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        if ($emp_detail_status) {
            // session()->flash('success', 'Data has been updated successfully!');
            return redirect()->route('user.contact')->with('success', 'Data has been inserted successfully!');
        } else {
            // session()->flash('error', 'Data has Not been updated successfully!');
            return redirect()->route('user.contact')->with('error', 'Issue while inserting Data!');;
        }
    }
}

public function insertcontact(Request $request)
{
    $validated = $request->validate([
        'permanent_building_no' => 'required',
        'permanent_premises_name' => 'required',
        'permanent_landmark' => 'required',
        'permanent_road_street' => 'required',
        'permanent_country' => 'required',
        'permanent_pincode' => 'sometimes|required_if:permanent_country,India',
        'permanent_district' => 'required',
        'permanent_city' => 'required',
        'permanent_state' => 'required',

<<<<<<< HEAD
        // Correspondence address fields are now optional
        'correspondence_building_no' => 'nullable',
        'correspondence_premises_name' => 'nullable',
        'correspondence_landmark' => 'nullable',
        'correspondence_road_street' => 'nullable',
        'correspondence_country' => 'nullable',
        'correspondence_pincode' => 'nullable',
        'correspondence_district' => 'nullable',
        'correspondence_city' => 'nullable',
        'correspondence_state' => 'nullable',
=======
        'correspondence_building_no' => '',
        'correspondence_premises_name' => '',
        'correspondence_landmark' => '',
        'correspondence_road_street' => '',
        'correspondence_country' => '',
        'correspondence_pincode' => '',
        'correspondence_district' => '',
        'correspondence_city' => '',
        'correspondence_state' => '',
>>>>>>> c4b0c0d688b5d8588d646811c2a6ad22de77a34b

        'phoneNumber' => 'required',
        'emailID' => 'required',
        'email' => 'required',

        'emergency_contact_name' => 'required',
        'emergency_contact_number' => 'required',
    ]);

    $data = $request->all();
    $loginUserInfo = Auth::user();
    $empContactStatus = emp_contact_details::where('user_id', $loginUserInfo->id)->get();

    if ($empContactStatus->isNotEmpty()) {
        // Ensure all correspondence fields are checked or set to null if not provided
        $correspondenceCountry = $data['correspondence_country'] ?? null;
        $correspondencePincode = $data['correspondence_pincode'] ?? null;

        // Using Query Builder to update data
        $updatecontactstatus = DB::table('emp_contact_details')
            ->where('user_id', $loginUserInfo->id)
            ->update([
                'per_building_no' => $data['permanent_building_no'],
                'per_name_of_premises' => $data['permanent_premises_name'],
                'per_nearby_landmark' => $data['permanent_landmark'],
                'per_road_street' => $data['permanent_road_street'],
                'per_country' => $data['permanent_country'],
                'per_pincode' => $data['permanent_pincode'],
                'per_district' => $data['permanent_district'],
                'per_city' => $data['permanent_city'],
                'per_state' => $data['permanent_state'],

                'cor_building_no' => $data['correspondence_building_no'],
                'cor_name_of_premises' => $data['correspondence_premises_name'],
                'cor_nearby_landmark' => $data['correspondence_landmark'],
                'cor_road_street' => $data['correspondence_road_street'],
                'cor_country' => $correspondenceCountry,
                'cor_pincode' => $correspondencePincode,
                'cor_district' => $data['correspondence_district'],
                'cor_city' => $data['correspondence_city'],
                'cor_state' => $data['correspondence_state'],

                'offical_phone_number' => $data['phoneNumber'],
                'alternate_phone_number' => $data['alternate_phone_number'] ?? null,
                'email_address' => $data['emailID'],
                'offical_email_address' => $data['email'],

                'emergency_contact_person' => $data['emergency_contact_name'],
                'emergency_contact_number' => $data['emergency_contact_number'],
            ]);

        if ($updatecontactstatus) {
            return redirect()->route('user.edu')->with('success', 'Data has been updated successfully!');
        } else {
            return redirect()->route('user.edu')->with('error', 'No Item Modified!');
        }
    } else {
        // Ensure all correspondence fields are checked or set to null if not provided
        $correspondenceCountry = $data['correspondence_country'] ?? null;
        $correspondencePincode = $data['correspondence_pincode'] ?? null;

        // Using Query Builder to insert data
        $emp_contact_status = DB::table('emp_contact_details')->insert([
            'per_building_no' => $data['permanent_building_no'],
            'per_name_of_premises' => $data['permanent_premises_name'],
            'per_nearby_landmark' => $data['permanent_landmark'],
            'per_road_street' => $data['permanent_road_street'],
            'per_country' => $data['permanent_country'],
            'per_pincode' => $data['permanent_pincode'],
            'per_district' => $data['permanent_district'],
            'per_city' => $data['permanent_city'],
            'per_state' => $data['permanent_state'],

            'cor_building_no' => $data['correspondence_building_no'],
            'cor_name_of_premises' => $data['correspondence_premises_name'],
            'cor_nearby_landmark' => $data['correspondence_landmark'],
            'cor_road_street' => $data['correspondence_road_street'],
            'cor_country' => $correspondenceCountry,
            'cor_pincode' => $correspondencePincode,
            'cor_district' => $data['correspondence_district'],
            'cor_city' => $data['correspondence_city'],
            'cor_state' => $data['correspondence_state'],

            'offical_phone_number' => $data['phoneNumber'],
            'alternate_phone_number' => $data['alternate_phone_number'] ?? null,
            'email_address' => $data['emailID'],
            'offical_email_address' => $data['email'],

            'emergency_contact_person' => $data['emergency_contact_name'],
            'emergency_contact_number' => $data['emergency_contact_number'],
            'user_id' => $loginUserInfo->id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        if ($emp_contact_status) {
            return redirect()->route('user.edu')->with('success', 'Data has been inserted successfully!');
        } else {
            return redirect()->route('user.edu')->with('error', 'Data has Not been inserted successfully!');
        }
    }
}

    public function insertEducation(Request $request){
// Store Education Data
    // Validate the input fields as arrays
    $data = $request->validate([
        'course_type' => 'required|array',
        'degree' => 'required|array',
        'university' => 'required|array',
        'institution' => 'required|array',
        // 'passing_year' => 'required|array',
        'percentage' => 'required|array',
        'certification_name' => 'nullable|array',
        'marks_obtained' => 'nullable|array',
        'total_marks' => 'nullable|array',
        'date_of_certificate' => 'nullable|array',
    ]);
    
    $loginUserInfo = Auth::user();
    $emp_edu_details = emp_education::where('user_id', $loginUserInfo->id)->get();

    if($emp_edu_details->isNotEmpty()){

        $deleteStaus = emp_education::where('user_id', $loginUserInfo->id)->delete();

        // Loop through the validated data and insert into the database
    foreach ($data['degree'] as $index => $degree) {
        // Ensure that all fields for this index exist, and if not, assign null or handle accordingly
       $updateStatus = DB::table('emp_educations')->insert([
            'course_type' => isset($data['course_type'][$index]) ? $data['course_type'][$index] : null,
            'degree' => $degree,
            'university_board' => isset($data['university'][$index]) ? $data['university'][$index] : null,
            'institution' => isset($data['institution'][$index]) ? $data['institution'][$index] : null,
            'passing_year' => isset($data['passing_year'][$index]) ? $data['passing_year'][$index] : null,
            'percentage_cgpa' => isset($data['percentage'][$index]) ? $data['percentage'][$index] : null,
            'certification_name' => isset($data['certification_name'][$index]) ? $data['certification_name'][$index] : null,
            'marks_obtained' => isset($data['marks_obtained'][$index]) ? $data['marks_obtained'][$index] : null,
            'out_of_marks_total_marks' => isset($data['total_marks'][$index]) ? $data['total_marks'][$index] : null,
            'date_of_certificate' => isset($data['date_of_certificate'][$index]) ? $data['date_of_certificate'][$index] : null,
            'user_id' => $loginUserInfo->id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    if($updateStatus){

        // session()->flash('success', 'Data has been Updated successfully!');
        return redirect()->route('user.bank')->with('success', 'Data has been Updated successfully!');

}else{
    // session()->flash('error', 'Data has Not been Updated successfully!');
        return redirect()->route('user.bank')->with('error', 'No Item Modified!');

}
        

    }else{

                // Loop through the validated data and insert into the database
    foreach ($data['degree'] as $index => $degree) {
        // Ensure that all fields for this index exist, and if not, assign null or handle accordingly
       $insertStatus = DB::table('emp_educations')->insert([
            'course_type' => isset($data['course_type'][$index]) ? $data['course_type'][$index] : null,
            'degree' => $degree,
            'university_board' => isset($data['university'][$index]) ? $data['university'][$index] : null,
            'institution' => isset($data['institution'][$index]) ? $data['institution'][$index] : null,
            'passing_year' => isset($data['passing_year'][$index]) ? $data['passing_year'][$index] : null,
            'percentage_cgpa' => isset($data['percentage'][$index]) ? $data['percentage'][$index] : null,
            'certification_name' => isset($data['certification_name'][$index]) ? $data['certification_name'][$index] : null,
            'marks_obtained' => isset($data['marks_obtained'][$index]) ? $data['marks_obtained'][$index] : null,
            'out_of_marks_total_marks' => isset($data['total_marks'][$index]) ? $data['total_marks'][$index] : null,
            'date_of_certificate' => isset($data['date_of_certificate'][$index]) ? $data['date_of_certificate'][$index] : null,
            'user_id' => $loginUserInfo->id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    if($insertStatus){

        // session()->flash('success', 'Data has been Inserted successfully!');
        return redirect()->route('user.bank')->with('success', 'Data has been Inserted successfully!');

    }else{
        // session()->flash('error', 'Data has Not been Inserted successfully!');
            return redirect()->route('user.bank')->with('error','Data has Not been Inserted successfully!');

    }

    }
    
       // return redirect()->route('user.edu')->with('success', 'Education added successfully.');

}

// Delete Educations
public function DeleteEducation($id)
{

    emp_education::where('id', $id)->delete(); 
}

public function DeleteFamily($id){

    // dd($id);

    emp_family_details::where('id', $id)->delete(); 

}

public function DeletePreViousEmpy($id){

    emp_previous_employment::where('id', $id)->delete(); 

}



public function insertBank(Request $request){

    $data = $request->validate([
        'bankName1' => 'required',
        'branchName1' => 'required',
        'accountNumber1' => 'required',
        'ifscCode1' => 'required',
        'bankName2' => 'required',
        'branchName2' => 'required',
        'accountNumber2' => 'required',
        'ifscCode2' => 'required',
        'passportNumber' => '',
        'country' => '',
        'passportIssueDate' => '',
        'passportExpiryDate' => '',
        'usaVisa' => '',
        'visaExpiryDate' => '',
        'vehicleType' => '',
        'vehicleModel' => '',
        'vehicleOwner' => '',
        'registrationNumber' => '',
        'insuranceProvider' => '',
        'insuranceExpiry' => '',
    ]);

    // dd($data);

    $loginUserInfo = Auth::user();

    $empBankStatus = emp_bank_details::where('user_id', $loginUserInfo->id)->get();

    if($empBankStatus->isNotEmpty()){

        $updatebankstatus = DB::table('emp_bank_details')
        ->where('user_id', $loginUserInfo->id) 
        ->update([

            'per_bank_name' => $data['bankName1'],
            'per_branch_name' => $data['branchName1'],
            'per_account_number' => $data['accountNumber1'],
            'per_ifsc_code' => $data['ifscCode1'],
            'sal_bank_name' => $data['bankName2'],
            'sal_branch_name' => $data['branchName2'],
    
            'sal_account_number' => $data['accountNumber2'],
            'sal_ifsc_code' => $data['ifscCode2'],
            'passport_number' => $data['passportNumber'],
            'issuing_country' => $data['country'],
            'passport_issue_date' => $data['passportIssueDate'],
            'passport_expiry_date' => $data['passportExpiryDate'],
    
            'active_visa' => $data['usaVisa'],
            'visa_expiry_date' => $data['visaExpiryDate'],
            'vehicle_type' => $data['vehicleType'],
            'vehicle_model' => $data['vehicleModel'],
            'vehicle_owner' => $data['vehicleOwner'],
            'vehicle_number' => $data['registrationNumber'],
    
            'insurance_provider' => $data['insuranceProvider'],
            'insurance_expiry_date' => $data['insuranceExpiry'],
            
          
        ]);

        if($updatebankstatus){
            // session()->flash('success', 'Data has been updated successfully!');
            return redirect()->route('user.family')->with('success','Data has been updated successfully!');
    
         }else{
    
            // session()->flash('error', 'Data has Not been updated successfully!');
            return redirect()->route('user.family')->with('error','No Item Modified!');
    
         }



}else{

    $emp_bank_status =  DB::table('emp_bank_details')->insert([

        'per_bank_name' => $data['bankName1'],
        'per_branch_name' => $data['branchName1'],
        'per_account_number' => $data['accountNumber1'],
        'per_ifsc_code' => $data['ifscCode1'],
        'sal_bank_name' => $data['bankName2'],
        'sal_branch_name' => $data['branchName2'],

        'sal_account_number' => $data['accountNumber2'],
        'sal_ifsc_code' => $data['ifscCode2'],
        'passport_number' => $data['passportNumber'],
        'issuing_country' => $data['country'],
        'passport_issue_date' => $data['passportIssueDate'],
        'passport_expiry_date' => $data['passportExpiryDate'],

        'active_visa' => $data['usaVisa'],
        'visa_expiry_date' => $data['visaExpiryDate'],
        'vehicle_type' => $data['vehicleType'],
        'vehicle_model' => $data['vehicleModel'],
        'vehicle_owner' => $data['vehicleOwner'],
        'vehicle_number' => $data['registrationNumber'],

        'insurance_provider' => $data['insuranceProvider'],
        'insurance_expiry_date' => $data['insuranceExpiry'],
        'user_id' => $loginUserInfo->id,
        'created_at' => NOW(),
        'updated_at' => NOW(),
        

    ]);

    if($emp_bank_status){
        // session()->flash('success', 'Data has been Inserted successfully!');
        return redirect()->route('user.family')->with('success','Data has been inserted successfully!');

     }else{

        // session()->flash('error', 'Data has Not been Inserted successfully!');
        return redirect()->route('user.family')->with('error','Data has Not been inserted successfully!');

     }



}
}

  // Handle file upload request
  public function upload(Request $request)
  {
    
    $request->validate([
        'photo' => 'required', // ensure it's an array of files
        'photo.*' => 'file', // ensure each element is a valid file
    ]);
     // Get the original file name
    //  $originalFileName = $file->getClientOriginalName();

    foreach ($request->file('photo') as $file) {
        $path = $file->store('employee_enroll_files', 'public');
        $originalFileName = $file->getClientOriginalName();
       
    }
    // dd($path); // This will dump the path for the first file
    $loginUserInfo = Auth::user();
    if($path){

        DB::table('document_uploads')->insert([
            'user_id' => $loginUserInfo->id,
            'document_type' => $originalFileName,
            'file_path' => $path,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        return true;

    }else{

        return false;

    }
   }

   public function homePageRedirect(){
    $loginUserInfo = Auth::user();

    $results = DB::table('emp_details')
    ->join('employee_types', 'emp_details.employee_type', '=', 'employee_types.id')
    ->join('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id')
    ->join('users', 'emp_details.reporting_manager', '=', 'users.id')
    ->join('organisation_departments', 'emp_details.department', '=', 'organisation_departments.id')
    ->select('emp_details.*', 
             'employee_types.*',
             'organisation_designations.*',
             'users.*',
             'organisation_departments.*')
    ->where('emp_details.user_id', '=', $loginUserInfo->id)
    ->get();

    // dd($results);
    if(is_null($results['0']->employee_type) && is_null($results['0']->employee_no) && is_null($results['0']->employee_name)){

        return redirect()->route('user.logout');

    }else{

        userHomePageStatus::insert([
            'user_id' => $loginUserInfo->id,
            'homePageStatus' => '1',
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    
        return redirect()->route('user.homepage');

    }
}
}

