<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\branche;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ororganisationBranchController extends Controller
{
    public function index(){
        $id = Auth::guard('superadmin')->user()->id;
        $branchs = branche::where('organisation_id', $id)->get();
        // dd($branchs);
        return view('superadmin_view.create_branch',compact('branchs'));
    }

    public function insertBranch(Request $request){

        $data = $request->validate([
            'branchname' => 'required',
            'mobile' => 'required',
            'branchmailid' => 'required',
            'Building_No' => 'required',
            'premises_name' => 'required',
            'landmark' => 'required',
            'road_street' => 'nullable',
            'pincode' => 'required',
            'district' => 'required',
            'state' => 'required',
            'country' => 'required',
        ]);

        $id = Auth::guard('superadmin')->user()->id;

        $status = DB::table('branches')->insert([
            'organisation_id' => $id,
            'name' => $data['branchname'],
            'mobile' => $data['mobile'],
            'branch_email' => $data['branchmailid'],
            'building_no' => $data['Building_No'],
            'premises_name' => $data['premises_name'],
            'landmark' => $data['landmark'],
            'road_street' => $data['road_street'],
            'pincode' => $data['pincode'],
            'district' => $data['district'],
            'state' => $data['state'],
            'country' => $data['country'],
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        if($status){

            return redirect()->route('create_branch_form')->with('success', 'Your Branch Details has been updated successfully!');

        }else{

            return redirect()->route('create_branch_form')->with('error', 'Your Branch Details has been not updated successfully!');

        }

    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'branchname' => 'required',
            'mobile' => 'required',
            'branchmailid' => 'required|email',
            'Building_No' => 'required',
            'premises_name' => 'required',
            'landmark' => 'required',
            'road_street' => 'required',
            'pincode' => 'required',
            'district' => 'required',
            'state' => 'required',
            'country' => 'required',
        ]);

        $branch = branche::find($request->branch_id);
        $branch->name = $request->branchname;
        $branch->mobile = $request->mobile;
        $branch->branch_email = $request->branchmailid;
        $branch->building_no = $request->Building_No;
        $branch->premises_name = $request->premises_name;
        $branch->landmark = $request->landmark;
        $branch->road_street = $request->road_street;
        $branch->pincode = $request->pincode;
        $branch->district = $request->district;
        $branch->state = $request->state;
        $branch->country = $request->country;
        $branch->save();

        return redirect()->back()->with('success', 'Branch updated successfully');
    }
}
