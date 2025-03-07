<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee_type;
use App\Models\User;
use App\Models\bank;
use App\Models\emp_previous_employment;
use App\Models\emp_family_details;
use App\Models\emp_education;
use App\Models\emp_bank_details;
use App\Models\emp_details;
use App\Models\emp_contact_details;
use App\Models\organisation_department;
use App\Models\organisation_designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class employmentDataController extends Controller
{
    public function showEmploymentData()
    {
        $loginUserInfo = Auth::user();
        $userId = $loginUserInfo->id;
        $organisationId = $loginUserInfo->organisation_id;

        // Store user ID and organisation ID in the session
        session(['user_id' => $userId, 'organisation_id' => $organisationId]);

        // Fetch user details using joins
        $userDetails = DB::table('users')
            ->leftJoin('emp_details', 'users.id', '=', 'emp_details.user_id')
            ->leftJoin('emp_contact_details', 'users.id', '=', 'emp_contact_details.user_id')
            ->leftJoin('emp_bank_details', 'users.id', '=', 'emp_bank_details.user_id')
            ->leftJoin('organisation_departments', 'emp_details.department', '=', 'organisation_departments.id')  // Join for department name
            ->leftJoin('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id')  // Join for designation name
            ->leftJoin('employee_types', 'emp_details.employee_type', '=', 'employee_types.id')  // Join for employee type name
            ->leftJoin('users as managers', 'emp_details.reporting_manager', '=', 'managers.id')  // Join for reporting manager name
            ->leftJoin('banks', 'emp_bank_details.sal_bank_name', '=', 'banks.id')  // Join for bank name using sal_bank_name
            ->select(
                'users.*',
                'emp_details.*',
                'emp_contact_details.*',
                'emp_bank_details.*',
                'organisation_departments.name as department_name',  // Select department name
                'organisation_designations.name as designation_name',  // Select designation name
                'employee_types.name as employee_type_name',  // Select employee type name
                'managers.name as reporting_manager_name',  // Select reporting manager name
                'banks.name as bank_name'  // Select bank name
            )
            ->where('users.id', $userId)
            ->where('users.organisation_id', $organisationId)
            ->first();

        // Fetch related data
        $empEducation = emp_education::where('user_id', $userId)->get();
        $empPreviousEmployments = emp_previous_employment::where('user_id', $userId)->get();
        $empFamilyDetails = emp_family_details::where('user_id', $userId)->get();

        return view('user_view.employment_data', compact(
            'userDetails',
            'empEducation',
            'empPreviousEmployments',
            'empFamilyDetails'
        ));
    }
}