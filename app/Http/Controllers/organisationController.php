<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganisationController extends Controller
{
    public function showOrganisation()
    {
        $title = "Organization Chart";
        $user = Auth::user();

        // Get the ID of the user with name "none" in the same organisation
        $noneUser = DB::table('users')
            ->where('name', 'none')
            ->where('organisation_id', $user->organisation_id)
            ->first();

        $noneUserId = $noneUser ? $noneUser->id : null;

        $employees_login = DB::table('emp_details')
        ->join('emp_contact_details', 'emp_details.user_id', '=', 'emp_contact_details.user_id')
        ->leftJoin('organisation_departments', 'emp_details.department', '=', 'organisation_departments.id')
        ->leftJoin('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id')
        ->leftJoin('employee_types', 'emp_details.employee_type', '=', 'employee_types.id')
        ->leftJoin('users as managers', 'emp_details.reporting_manager', '=', 'managers.id')
        ->leftJoin('user_status_imgs', 'emp_details.user_id', '=', 'user_status_imgs.user_id') // Join profile image
        ->select(
            'emp_details.user_id',
            'emp_details.employee_name',
            'emp_details.designation',
            'emp_details.employee_no',
            'emp_details.reporting_manager',
            'managers.name as reporting_manager_name',
            'organisation_departments.name as department',
            'organisation_designations.name as designation',
            'emp_contact_details.per_city',
            'emp_contact_details.offical_phone_number',
            'emp_contact_details.offical_email_address',
            'emp_contact_details.emergency_contact_person',
            'emp_contact_details.emergency_contact_number',
            'emp_details.gender',
            'user_status_imgs.imagelink as profile_image' // Fetch profile image
        )
        ->where('emp_details.user_id', '=', $user->id) // Add the session user_id condition
        ->first();

        // dd($employees_login);

        // Fetch employees with profile images
        $employees = DB::table('emp_details')
            ->join('emp_contact_details', 'emp_details.user_id', '=', 'emp_contact_details.user_id')
            ->leftJoin('organisation_departments', 'emp_details.department', '=', 'organisation_departments.id')
            ->leftJoin('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id')
            ->leftJoin('employee_types', 'emp_details.employee_type', '=', 'employee_types.id')
            ->leftJoin('users as managers', 'emp_details.reporting_manager', '=', 'managers.id')
            ->leftJoin('user_status_imgs', 'emp_details.user_id', '=', 'user_status_imgs.user_id') // Join profile image
            ->leftJoin('branches', 'emp_details.branch_id', '=', 'branches.id')  // Join for branch name using branch_id
            ->select(
                'emp_details.user_id',
                'emp_details.employee_name',
                'emp_details.designation',
                'emp_details.employee_no',
                'emp_details.reporting_manager',
                'employee_types.name as employee_type_name',
                'managers.name as reporting_manager_name',
                'organisation_departments.name as department',
                'organisation_designations.name as designation',
                'emp_contact_details.per_city',
                'emp_contact_details.emergency_contact_person',
                'emp_contact_details.emergency_contact_number',
                'emp_contact_details.offical_phone_number',
                'emp_contact_details.offical_email_address',
                'emp_details.gender',
                'branches.name as branch_name',  // Select branch name
                'user_status_imgs.imagelink as profile_image' // Fetch profile image
            )
            ->get();
// dd($employees);
        // Build hierarchy
        $employeeHierarchy = $this->buildHierarchy($employees, $noneUserId);

        return view('user_view.organisation', compact('user', 'employeeHierarchy', 'title','employees_login'));
    }

    private function buildHierarchy($employees, $parentId = null)
    {
        $tree = [];
        foreach ($employees as $employee) {
            if ($employee->reporting_manager == $parentId) {
                $employee->subordinates = $this->buildHierarchy($employees, $employee->user_id);
                $tree[] = $employee;
            }
        }
        return $tree;
    }

    public function showHorizontalOrganisation()
    {
        $title = "Horizontal Organization Chart";
        $user = Auth::user();
    
        // Get the ID of the user with name "none" in the same organisation
        $noneUser = DB::table('users')
            ->where('name', 'none')
            ->where('organisation_id', $user->organisation_id)
            ->first();
    
        $noneUserId = $noneUser ? $noneUser->id : null;
    
        // Fetch employees with profile images
        $employees = DB::table('emp_details')
            ->join('emp_contact_details', 'emp_details.user_id', '=', 'emp_contact_details.user_id')
            ->leftJoin('organisation_departments', 'emp_details.department', '=', 'organisation_departments.id')
            ->leftJoin('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id')
            ->leftJoin('employee_types', 'emp_details.employee_type', '=', 'employee_types.id')
            ->leftJoin('users as managers', 'emp_details.reporting_manager', '=', 'managers.id')
            ->leftJoin('user_status_imgs', 'emp_details.user_id', '=', 'user_status_imgs.user_id') // Join profile image
            ->select(
                'emp_details.user_id',
                'emp_details.employee_name',
                'emp_details.designation',
                'emp_details.employee_no',
                'emp_details.reporting_manager',
                'managers.name as reporting_manager_name',
                'organisation_departments.name as department',
                'organisation_designations.name as designation',
                'emp_contact_details.per_city',
                'emp_contact_details.offical_phone_number',
                'emp_contact_details.offical_email_address',
                'emp_details.gender',
                'user_status_imgs.imagelink as profile_image' // Fetch profile image
            )
            ->get();
    
        // Build hierarchy (same as the previous method)
        $employeeHierarchy = $this->buildHierarchy($employees, $noneUserId);
    // dd($employeeHierarchy);
        return view('user_view.horizontal_organisation', compact('user', 'employeeHierarchy', 'title'));
    }
    


}
  
