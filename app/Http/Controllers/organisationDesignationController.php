<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\organisation_designation;
use App\Models\organisation_department;
use App\Models\branche;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class organisationDesignationController extends Controller
{
    public function index(){
        $id = Auth::guard('superadmin')->user()->id;
        $departments = organisation_department::where('organisation_id', $id)->get();
        $branches = branche::where('organisation_id', $id)->get();

    $results = DB::table('organisation_designations')
    ->join('organisation_departments', 'organisation_designations.department_id', '=', 'organisation_departments.id')
    ->join('branches', 'organisation_designations.branch_id', '=', 'branches.id')
    ->select('organisation_departments.name as department_name', 'organisation_designations.name as designation_name','organisation_designations.id as designation_id','branches.id as branch_id','branches.name as branch_name')
    ->where('organisation_departments.organisation_id', '=', $id) // Adding a WHERE condition to filter by department name
    ->get();

    // dd($results);
        // dd($departments);
        // return view('superadmin_view.create_designation');
        return view('superadmin_view.create_designation', compact('departments','branches','results'));
    }

    public function insertDesignation(Request $request){

        $validated = $request->validate([
            'organisation_id' => 'required',
            'branch_id' => 'required',
            'department_id' => 'required',
            'name' => 'required',

        ]);

        $data = $request->all();

        // dd($data);
        $insert_status = organisation_designation::create([
            'organisation_id' => $data['organisation_id'],
            'branch_id' => $data['branch_id'],
            'department_id' => $data['department_id'],
            'name' => $data['name'],
        ]);

        if($insert_status){

            return redirect()->route('create_designation_form')->with('success', 'Designation created successfully!');

        }else{

            return redirect()->route('create_designation_form')->with('unsuccess', 'Designation not created successfully!');

        }
          

    }
}
