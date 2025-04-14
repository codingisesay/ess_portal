<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReimbursementController extends Controller
{
    
    public function index(){
        // $id = Auth::guard('superadmin')->user()->id;
        // // $mailDatas = organisation_config_mail::where('organisation_id',$id)->get();

        // $mailDatas = DB::table('organisation_reimbursement_types')->get();
        return view('superadmin_view.create_reimbursement');
    }

 
    public function show($id)
    {
        // Show logic
    }

    public function store(Request $request)
    {
        // Store logic
    }

    // Other methods...
}
