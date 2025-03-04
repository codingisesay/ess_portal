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
            ->select(
                'emp_details.user_id',
                'emp_details.employee_name',
                'emp_details.designation',
                'emp_details.employee_no',
                'emp_details.reporting_manager',
                'emp_details.department',
                'emp_contact_details.per_city',
                'emp_contact_details.offical_phone_number',
                'emp_contact_details.offical_email_address'
            )
            ->get();

        return view('user_view.organisation', compact('user', 'employees'));
    }

    public function displayEmployeeTree($parentId = null, $departmentColors)
    {
        // ...existing code...
    }
}