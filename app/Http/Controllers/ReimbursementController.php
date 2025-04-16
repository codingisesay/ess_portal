<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReimbursementController extends Controller
{
    
    public function index(){
        $id = Auth::guard('superadmin')->user()->id;
        // // $mailDatas = organisation_config_mail::where('organisation_id',$id)->get();

        $reim_type = DB::table('organisation_reimbursement_types')
        ->where('organisation_id',$id)
        ->where('status','Active')
        ->get();
        return view('superadmin_view.create_reimbursement',compact('reim_type'));
    }

 
public function insertReimbursementType(Request $request){

    $data = $request->validate([
        'category_name' => 'required',
        'category_short_name' => 'required',
        'status' => 'required',
      
    ]);
     $id = Auth::guard('superadmin')->user()->id;

     $status = DB::table('organisation_reimbursement_types')->insert([

        'organisation_id' => $id,
        'name' => $data['category_name'],
        'short_name' => $data['category_short_name'],
        'status' => $data['status'],
        'created_at' => NOW(),
        'updated_at' => NOW(),

     ]);

     if($status){

        return redirect()->route('reimbursement')->with('success','Record Inserted !!');

     }

     return redirect()->route('reimbursement')->with('error','Record Not Inserted !!');

}

public function insertReimbursementValidation(Request $request){
    $data = $request->validate([
        'reimbursement_type_id' => 'required',
        'max_amount' => 'required',
        'bill_required' => 'required',
        'tax_required' => 'required',
      
    ]);
     $id = Auth::guard('superadmin')->user()->id;

     $status = DB::table('organisation_reimbursement_type_restrictions')->insert([

        'reimbursement_type_id' => $data['reimbursement_type_id'],
        'max_amount' => $data['max_amount'],
        'bill_required' => $data['bill_required'],
        'tax_applicable' => $data['tax_required'],
        'created_at' => NOW(),
        'updated_at' => NOW(),

     ]);

     if($status){

        return redirect()->route('reimbursement_restrictions')->with('success','Record Inserted !!');

     }

     return redirect()->route('reimbursement_restrictions')->with('error','Record Not Inserted !!');

}


    
    public function reimbursement_restrictions_load(){ 

        $id = Auth::guard('superadmin')->user()->id;
        // // $mailDatas = organisation_config_mail::where('organisation_id',$id)->get();

        $reim_type = DB::table('organisation_reimbursement_types')
        ->where('organisation_id',$id)
        ->where('status','Active')
        ->get();

        $table_data = DB::table('organisation_reimbursement_type_restrictions')
        ->join('organisation_reimbursement_types','organisation_reimbursement_type_restrictions.reimbursement_type_id','=','organisation_reimbursement_types.id')
        ->select('organisation_reimbursement_types.name as reim_type',
        'organisation_reimbursement_type_restrictions.max_amount as max_amount',
        'organisation_reimbursement_type_restrictions.bill_required as bill_required',
        'organisation_reimbursement_type_restrictions.tax_applicable as tax_applicable')
        ->where('organisation_reimbursement_types.organisation_id','=',$id)
        ->get();

        // dd($table_data);

        return view('superadmin_view.create_reimbursement_restrictions',compact('reim_type','table_data'));
    }


}
