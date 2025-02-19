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

class EmploymentDataController extends Controller
{
    public function showEmploymentData()
    {
        $loginUserInfo = Auth::user();
        $userId = $loginUserInfo->id;

        // Fetch user details using joins
        $userDetails = DB::table('users')
            ->leftJoin('emp_details', 'users.id', '=', 'emp_details.user_id')
            ->leftJoin('emp_contact_details', 'users.id', '=', 'emp_contact_details.user_id')
            ->leftJoin('emp_bank_details', 'users.id', '=', 'emp_bank_details.user_id')
            ->select('users.*', 'emp_details.*', 'emp_contact_details.*', 'emp_bank_details.*')
            ->where('users.id', $userId)
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