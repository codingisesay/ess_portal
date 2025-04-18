<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\reimbursement_tracking;
// use App\Helpers\SalaryHelper;

class salaryBoxController extends Controller
{
    public function loadInsertForm(){
        $org_data = Auth::guard('superadmin')->user();
        $template_datas = DB::table('org_salary_templates')
        ->where('organisation_id', '=', $org_data->id)
        ->get();
        return view('superadmin_view.create_salary_template',compact('template_datas'));
    }

    public function loadcomponentsForm(){

        $org_data = Auth::guard('superadmin')->user();
        $templates = DB::table('org_salary_templates')
        ->where('organisation_id' , '=' , $org_data->id)
        ->get();
        $componentdata = DB::table('org_salary_template_components')
        ->join('org_salary_templates','org_salary_template_components.salary_template_id','=','org_salary_templates.id')
        ->select('org_salary_templates.name as template_name','org_salary_template_components.*')
        ->get();
        // dd($componentdata);
        return view('superadmin_view.create_salary_components',compact('templates','componentdata'));

    }



    public function insertSalaryTemplate(Request $request){
        $data = $request->validate([
            'template_name' => 'required',
            'min_ctc' => 'required',
            'max_ctc' => 'required',
            'status' => 'required',
        ]);

        $org_data = Auth::guard('superadmin')->user();

        $insertStatus = DB::table('org_salary_templates')->insert([
            'organisation_id' => $org_data->id,
            'name' => $data['template_name'],
            'min_ctc' => $data['min_ctc'],
            'max_ctc' => $data['max_ctc'],
            'status' => $data['status'],
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        if($insertStatus){

            return redirect()->route('salary_template_form')->with('success','Template Created Successfully!!');

        }

        return redirect()->route('salary_template_form')->with('error','Template Not Created Successfully!!');
    }

    public function insertSalaryComponents(Request $request){
        $data = $request->validate([
            'template_id' => 'required',
            'component_name' => 'required',
            'component_type' => 'required',
            'calculation_type' => 'required',
            'value' => 'required',
        ]);

        $org_data = Auth::guard('superadmin')->user();

        $insertStatus = DB::table('org_salary_template_components')->insert([
            'salary_template_id' => $data['template_id'],
            'name' => $data['component_name'],
            'type' => $data['component_type'],
            'calculation_type' => $data['calculation_type'],
            'value' => $data['value'],
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        if($insertStatus){

            return redirect()->route('create_salary_components')->with('success','Components Created Successfully!!');

        }

        return redirect()->route('create_salary_components')->with('error','Components Not Created Successfully!!');
    }



    public function loadTaxCycleForm(){
        $org_data = Auth::guard('superadmin')->user();
        $orgTaxRegim = DB::table('org_tax_regime_years')
        ->where('organisation_id','=',$org_data->id)
        ->get();

        return view('superadmin_view.create_tax_cycle',compact('orgTaxRegim'));

    }



    public function insertTaxCycle(Request $request){

        $data = $request->validate([
            'template_name' => 'required',
            'from' => 'required',
            'to' => '',
            'status' => 'required',
        ]);
        $org_data = Auth::guard('superadmin')->user();

       $status = DB::table('org_tax_regime_years')->insert([
            'organisation_id' => $org_data->id,
            'name' => $data['template_name'],
            'applicable_from' => $data['from'],
            'applicable_to' => $data['to'],
            'status' => $data['status'],
            'created_at' => NOW(),
            'updated_at' => NOW(),

        ]);

        if($status){

            return redirect()->route('tax_cycle')->with('success','Tax Cycyle Created Successfully!!');

        }

        return redirect()->route('tax_cycle')->with('error','Tax Cycyle Created Successfully!!');

    }

    public function loadTaxForm(){
        $org_data = Auth::guard('superadmin')->user();

        $taxregim = DB::table('org_tax_regime_years')
        ->where('organisation_id','=',$org_data->id)
        ->where('status','=','Active')
        ->get();

        $datafortaxes = DB::table('org_tax_slabs')
        ->join('org_tax_regime_years','org_tax_slabs.org_tax_regime_id','=','org_tax_regime_years.id')
        ->select(
            'org_tax_slabs.id', // Ensure the ID is included in the query
            'org_tax_regime_years.name as org_tax_regime_years_name',
            'org_tax_slabs.tax_type as tax_type',
            'org_tax_slabs.min_income as min_income',
            'org_tax_slabs.max_income as max_income',
            'org_tax_slabs.tax as tax_per',
            'org_tax_slabs.fixed_amount as fixed_amount'
        )
        ->get();

        return view('superadmin_view.create_tax',compact('taxregim','datafortaxes'));

    }

    public function insertTax(Request $request)
    {

        $data = $request->validate([
            'tax_cycle_type' => 'required',
            'tax_type' => 'required',
            'min_income' => 'required',
            'max_income' => 'required',
            'tax_per' => 'required',
            'fixed_amount' => 'required',
            
        ]);
        $org_data = Auth::guard('superadmin')->user();

       $status = DB::table('org_tax_slabs')->insert([
            'organisation_id' => $org_data->id,
            'org_tax_regime_id' => $data['tax_cycle_type'],
            'tax_type' => $data['tax_type'],
            'min_income' => $data['min_income'],
            'max_income' => $data['max_income'],
            'tax' => $data['tax_per'],
            'fixed_amount' => $data['fixed_amount'],
            'created_at' => NOW(),
            'updated_at' => NOW(),

        ]);

        if ($status) {
            return redirect()->route('taxes')->with('success', 'Tax Cycyle Created Successfully!!');
        }

        return redirect()->route('taxes')->with('error', 'Tax Cycyle Created Successfully!!');
    }

    public function updateSalaryTemplate(Request $request, $id)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
            'min_ctc' => 'required|numeric',
            'max_ctc' => 'required|numeric',
            'status' => 'required|in:Active,Inactive',
        ]);

        $template = DB::table('org_salary_templates')->where('id', $id)->first();

        if (!$template) {
            return redirect()->route('salary_template_form')->with('error', 'Salary Template not found.');
        }

        $status = DB::table('org_salary_templates')
            ->where('id', $id)
            ->update([
                'name' => $request->template_name,
                'min_ctc' => $request->min_ctc,
                'max_ctc' => $request->max_ctc,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        if ($status) {
            return redirect()->route('salary_template_form')->with('success', 'Salary Template updated successfully.');
        } else {
            return redirect()->route('salary_template_form')->with('error', 'Failed to update Salary Template.');
        }
    }

    public function updateSalaryComponent(Request $request, $id)
    {
        $request->validate([
            'template_id' => 'required|exists:org_salary_templates,id',
            'component_name' => 'required|string|max:255',
            'component_type' => 'required|in:Earning,Deduction',
            'calculation_type' => 'required|in:Percentage,Fixed',
            'value' => 'required|numeric',
        ]);

        $component = DB::table('org_salary_template_components')->where('id', $id)->first();

        if (!$component) {
            return redirect()->route('create_salary_components')->with('error', 'Salary Component not found.');
        }

        $status = DB::table('org_salary_template_components')
            ->where('id', $id)
            ->update([
                'salary_template_id' => $request->template_id,
                'name' => $request->component_name,
                'type' => $request->component_type,
                'calculation_type' => $request->calculation_type,
                'value' => $request->value,
                'updated_at' => now(),
            ]);

        if ($status) {
            return redirect()->route('create_salary_components')->with('success', 'Salary Component updated successfully.');
        } else {
            return redirect()->route('create_salary_components')->with('error', 'Failed to update Salary Component.');
        }
    }

    public function updateTaxCycle(Request $request, $id)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
            'status' => 'required|in:Active,Inactive',
        ]);

        $taxCycle = DB::table('org_tax_regime_years')->where('id', $id)->first();

        if (!$taxCycle) {
            return redirect()->route('tax_cycle')->with('error', 'Tax Cycle not found.');
        }

        $status = DB::table('org_tax_regime_years')
            ->where('id', $id)
            ->update([
                'name' => $request->template_name,
                'applicable_from' => $request->from,
                'applicable_to' => $request->to,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        if ($status) {
            return redirect()->route('tax_cycle')->with('success', 'Tax Cycle updated successfully.');
        } else {
            return redirect()->route('tax_cycle')->with('error', 'Failed to update Tax Cycle.');
        }
    }

    public function updateTaxSlab(Request $request, $id)
    {
        $request->validate([
            'tax_cycle_type' => 'required|exists:org_tax_regime_years,id',
            'tax_type' => 'required|string|max:255',
            'min_income' => 'required|numeric',
            'max_income' => 'required|numeric',
            'tax_per' => 'required|numeric',
            'fixed_amount' => 'required|numeric',
        ]);

        $taxSlab = DB::table('org_tax_slabs')->where('id', $id)->first();

        if (!$taxSlab) {
            return redirect()->route('taxes')->with('error', 'Tax Slab not found.');
        }

        $status = DB::table('org_tax_slabs')
            ->where('id', $id)
            ->update([
                'org_tax_regime_id' => $request->tax_cycle_type,
                'tax_type' => $request->tax_type,
                'min_income' => $request->min_income,
                'max_income' => $request->max_income,
                'tax' => $request->tax_per,
                'fixed_amount' => $request->fixed_amount,
                'updated_at' => now(),
            ]);

        if ($status) {
            return redirect()->route('taxes')->with('success', 'Tax Slab updated successfully.');
        } else {
            return redirect()->route('taxes')->with('error', 'Failed to update Tax Slab.');
        }
    }

   
 public function loadDashboard(){


    return view('user_view.payrollDashboard');

 }

 public function loadclaimform(){
    $loginUserInfo = Auth::user();
    $reim_type = DB::table('organisation_reimbursement_types')
    ->where('organisation_id','=',$loginUserInfo->organisation_id)
    ->where('status','=','Active')
    ->get();

    // dd($reim_type);
    return view('user_view.claim_form',compact('reim_type'));
 }

 public function loadUserClaims($user_id, $reimbursement_traking_id)
{
    
    $reimbursementList = DB::table('reimbursement_trackings')
    ->join('emp_details', 'reimbursement_trackings.user_id', '=', 'emp_details.user_id')
    ->join('reimbursement_form_entries', 'reimbursement_trackings.id', '=', 'reimbursement_form_entries.reimbursement_trackings_id')
    ->join('assign_reimbursement_tokens', 'reimbursement_trackings.id', '=', 'assign_reimbursement_tokens.reimbursement_tracking_id')
    ->select(
        'emp_details.employee_no',
        'emp_details.employee_name',
        'emp_details.user_id',
        'reimbursement_trackings.token_number',
        'reimbursement_trackings.status',
        'reimbursement_trackings.id',
        DB::raw('SUM(reimbursement_form_entries.amount) as total_amount'),
        DB::raw('COUNT(reimbursement_form_entries.id) as no_of_entries') 
    )
    ->where('reimbursement_trackings.id', '=', $reimbursement_traking_id)
    ->where('reimbursement_trackings.status', '=', 'Pending')
    ->groupBy(
        'reimbursement_trackings.id',
        'reimbursement_trackings.token_number',
        'reimbursement_trackings.status',
        'emp_details.employee_no',
        'emp_details.employee_name',
        'emp_details.user_id'
    )
    ->get();

  dd($reimbursementList);

    return view('user_view.users_claim', compact('reimbursementList'));
}

 public function loadMangerClaims(){
    return view('user_view.managers_claim');
 }

 public function loadMaxAmoutRm($rm_id){

    $data = DB::table('organisation_reimbursement_type_restrictions')
    ->select('organisation_reimbursement_type_restrictions.max_amount as max_amount')
    ->where('reimbursement_type_id',$rm_id)
    ->first();
    // $max_amount = 200;
    // dd($max_amount);
    return response()->json([
        'max_amount' => $data->max_amount,  // This is the data you will send back to the front-end
    ]);

 }

 
 
 public function insertReimbursementForm(Request $request)
 {
     // Step 1: Validate input
     $data = $request->validate([
         'clam_comment' => 'nullable|string',
         'start_date' => 'required|date',
         'end_date' => 'required|date',
         'bill_date.*' => 'required|date',
         'type.*' => 'required',
         'entered_amount.*' => 'required|numeric',
         'bills.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
         'comments.*' => 'nullable|string'
     ]);
 
     $loginUserInfo = Auth::user();

    //  $billCount = count($data['bill_date']);
   // Insert into reimbursement_tracking
   $reimbursement = reimbursement_tracking::create([
    'start_date'   => $data['start_date'],
    'end_date'     => $data['end_date'],
    'description'  => $data['clam_comment'],
    'status'       => 'Pending',
    'user_id'      => $loginUserInfo->id,
]);

$insertedId = $reimbursement->id;

        // Step 3: Loop through bills
        foreach ($data['bill_date'] as $i => $billDate) {
            // Upload bill file if present
            $filePath = null;
            if ($request->hasFile("bills.$i")) {
                $filePath = $request->file("bills.$i")->store('bills', 'public');
            }

            // Step 4: Insert into reimbursement_entries table
           $billsUpload = DB::table('reimbursement_form_entries')->insert([
                'date' => $billDate,
                'reimbursement_trackings_id' => $insertedId,
                'organisation_reimbursement_types_id' => $data['type'][$i],
                'amount' => $data['entered_amount'][$i],
                'upload_bill' => $filePath,
                'description_by_applicant' => $data['comments'][$i] ?? null,
                'status' => 'Review',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

       $manger =  DB::table('emp_details')->where('user_id',$loginUserInfo->id)->first();

        

        if($billsUpload){

            //assign_reimbursement_tokens to users like managers/finace.

            $Insert = DB::table('assign_reimbursement_tokens')->insert([

                'user_id' => $manger->reporting_manager,
                'reimbursement_tracking_id' => $insertedId,
                'created_at' => NOW(),
                'updated_at' => NOW(),

            ]);

            return redirect()->route('PayRollDashboard')->with('success','Bills Uploaded');

        }

        return redirect()->route('PayRollDashboard')->with('error','Bills Not Uploaded');
        
 
        
     

 }
 

}
