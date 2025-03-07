<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class organisationController extends Controller
{
    public function showOrganisation()
    {
        $user = Auth::user(); // Get the logged-in user
        $employees = DB::table('emp_details')
            ->join('emp_contact_details', 'emp_details.user_id', '=', 'emp_contact_details.user_id')
            ->leftJoin('organisation_departments', 'emp_details.department', '=', 'organisation_departments.id')  // Join for department name
            ->leftJoin('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id')  // Join for designation name
            ->leftJoin('employee_types', 'emp_details.employee_type', '=', 'employee_types.id')  // Join for employee type name
            ->leftJoin('users as managers', 'emp_details.reporting_manager', '=', 'managers.id')  // Join for reporting manager name
            ->select(
                'emp_details.user_id',
                'emp_details.employee_name',
                'emp_details.designation',
                'emp_details.employee_no',
                'emp_details.reporting_manager',  // Keep the reporting manager ID
                'managers.name as reporting_manager_name',  // Select reporting manager name
                'organisation_departments.name as department',  // Select department name
                'organisation_designations.name as designation',  // Select designation name
                'emp_contact_details.per_city',
                'emp_contact_details.offical_phone_number',
                'emp_contact_details.offical_email_address'
            )
            ->get();
// dd($employees);
        return view('user_view.organisation', compact('user', 'employees'));
    }

    public function displayEmployeeTree($parentId = null, $departmentColors)
    {
        // ...existing code...
    }
}