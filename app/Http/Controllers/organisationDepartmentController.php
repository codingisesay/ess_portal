<?php

namespace App\Http\Controllers;
use App\Models\organisation_department;
use Illuminate\Http\Request;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class organisationDepartmentController extends Controller
{
    public function index(){

        $id = Auth::guard('superadmin')->user()->id;
       
         $departments = organisation_department::where('organisation_id', $id)->get();
      
         // Pass the data to the view
         return view('superadmin_view.create_department', compact('departments'));
        
    }

    public function insertDepartment(Request $request){

        $validated = $request->validate([
            'organisation_id' => 'required',
            'department_name' => 'required',
        ]);

        $data = $request->all();

        $insertStatus = organisation_department::create([
            'organisation_id' => $data['organisation_id'],
            'name' => $data['department_name'],
        ]);

        if($insertStatus){

            return redirect()->route('create_department_form')->with('success', 'Record Inserted successfully!');

        }else{

            return redirect()->route('create_department_form')->with('unsuccess', 'Record not Inserted successfully!');

        }
        

    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required',
        ]);

        $department = organisation_department::find($request->department_id);
        $department->name = $request->department_name;
        $department->save();

        return redirect()->back()->with('success', 'Department updated successfully');
    }

}
