<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\reimbursement_tracking;
use Barryvdh\DomPDF\Facade\Pdf;
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
   
         $orgComp = DB::table('org_salary_components')
         ->where('organisation_id' , '=' , $org_data->id)
         ->where('status' , '=' , 'Active')
         ->get();

        $componentdata = DB::table('org_salary_template_components')
        ->join('org_salary_templates','org_salary_template_components.salary_template_id','=','org_salary_templates.id')
        ->join('org_salary_components', 'org_salary_template_components.org_comp_id','=','org_salary_components.id')
        ->select('org_salary_templates.name as template_name','org_salary_template_components.*','org_salary_components.*')
        ->get();
        // dd($componentdata);
        return view('superadmin_view.create_salary_components',compact('templates','componentdata','orgComp'));

    }



    public function insertSalaryTemplate(Request $request){
        $data = $request->validate([
            'template_name' => 'required',
            'min_ctc' => '',
            'max_ctc' => '',
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
            'component_id' => 'required',
            'component_type' => 'required',
            'calculation_type' => 'required',
            'value' => '',
        ]);

        $org_data = Auth::guard('superadmin')->user();

        $insertStatus = DB::table('org_salary_template_components')->insert([
            'salary_template_id' => $data['template_id'],
            'org_comp_id' => $data['component_id'],
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
            'min_ctc' => 'nullable|numeric',
            'max_ctc' => 'nullable|numeric',
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
                'org_comp_id' => $request->component_name,
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

   
 public function loadDashboard(Request $request)
{
    $loginUserInfo = Auth::user();

    // Fetch payroll data for the logged-in user
    $payrollData = DB::table('payrolls')
        ->where('user_id', $loginUserInfo->id)
        ->orderBy('created_at', 'desc') // Get the latest payroll data
        ->first();


   // Fetch payroll deductions data for the logged-in user
        $payrollDeductions = DB::table('payroll_deductions')
        ->join('org_salary_components', 'payroll_deductions.salary_components_id', '=', 'org_salary_components.id')
        ->join('payrolls', 'payroll_deductions.payroll_id', '=', 'payrolls.id')
        ->select(
            'payroll_deductions.payroll_id',
            'payroll_deductions.amount',
            'org_salary_components.name as component_name', // Corrected column name
            'org_salary_components.type',
            'payroll_deductions.created_at',
            'payroll_deductions.*', 'payrolls.salary_month'
        )
        ->where('payroll_deductions.user_id', $loginUserInfo->id)
        ->orderBy('payroll_deductions.created_at', 'desc')
        ->get();

    // Fetch reimbursement claims data for the logged-in user
    $reimbursementClaims = DB::table('reimbursement_trackings')
        ->join('reimbursement_form_entries', 'reimbursement_trackings.id', '=', 'reimbursement_form_entries.reimbursement_trackings_id')
        ->select(
            'reimbursement_trackings.id as tracking_id',
            'reimbursement_trackings.token_number',
            'reimbursement_trackings.created_at as claim_date',
            DB::raw('SUM(reimbursement_form_entries.amount) as total_amount'),
            'reimbursement_trackings.description as purpose',
            'reimbursement_trackings.status',
            DB::raw('COUNT(reimbursement_form_entries.id) as no_of_entries'),
            DB::raw('GROUP_CONCAT(reimbursement_form_entries.upload_bill) as bundled_bills') // Bundle bills
        )
        ->where('reimbursement_trackings.user_id', '=', $loginUserInfo->id)
        ->groupBy(
            'reimbursement_trackings.id',
            'reimbursement_trackings.token_number',
            'reimbursement_trackings.created_at',
            'reimbursement_trackings.description',
            'reimbursement_trackings.status'
        )
        ->orderBy('reimbursement_trackings.created_at', 'desc') // Order by claim date
        
        ->get();

       
        
   

    // Determine the current financial year
   // **1. Determine the Current Financial Year (Apr to Mar)**
    $currentYear = now()->year;
    $currentMonth = now()->month;
    $currentFYStart = $currentMonth >= 4 ? $currentYear : $currentYear - 1;
    $currentFYEnd = $currentFYStart + 1;
    $startDate = "{$currentFYStart}-04-01";
    $endDate = "{$currentFYEnd}-03-31";

    // **5. Fetch Current FY Monthly Tax Data**
    $incomeTaxComponentId = 7; // Assuming the ID for "Income Tax (Section 192)" is 7
    $monthlyTaxData = DB::table('payroll_deductions')
        ->selectRaw('MONTH(STR_TO_DATE(created_at, "%d-%m-%Y")) as month, SUM(amount) as total_tax')
        ->where('user_id', $loginUserInfo->id)
        ->where('salary_components_id', $incomeTaxComponentId)
        ->whereBetween(DB::raw('STR_TO_DATE(created_at, "%d-%m-%Y")'), [$startDate, $endDate])
        ->groupBy(DB::raw('MONTH(STR_TO_DATE(created_at, "%d-%m-%Y"))'))
        ->orderBy(DB::raw('MONTH(STR_TO_DATE(created_at, "%d-%m-%Y"))'))
        ->pluck('total_tax', 'month')
        ->toArray();

    // **6. Fill Missing Months with Zero**
    $fullYearData = [];
    for ($i = 4; $i <= 12; $i++) { // Apr to Dec
        $fullYearData[] = $monthlyTaxData[$i] ?? 0;
    }
    for ($i = 1; $i <= 3; $i++) { // Jan to Mar
        $fullYearData[] = $monthlyTaxData[$i] ?? 0;
    }
  
    return view('user_view.payrollDashboard', compact('payrollData', 'payrollDeductions','reimbursementClaims','fullYearData'));
}



public function downloadPayslip($payroll_id)
{
    // Fetch payroll data for the given payroll ID
    $payroll = DB::table('payrolls')
        ->join('emp_details', 'payrolls.user_id', '=', 'emp_details.user_id') // Join with emp_details table
        ->join('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id') // Join with organisation_designations table
        ->select(
            'payrolls.*',
            'emp_details.employee_no',
            'emp_details.employee_name',
            'emp_details.joining_date',
            'organisation_designations.name as designation_name', // Fetch designation name
            'emp_details.provident_fund',
            'emp_details.esic_no',
            'emp_details.universal_account_number'
        )
        ->where('payrolls.id', $payroll_id)
        ->first();

    if (!$payroll) {
        return redirect()->back()->with('error', 'Payslip not found.');
    }

    //  Fetch bank details with bank name mapping
$bankDetails = DB::table('emp_bank_details')
    ->leftJoin('banks', 'emp_bank_details.sal_bank_name', '=', 'banks.id') // map bank id to bank name
    ->where('emp_bank_details.user_id', $payroll->user_id)
    ->select(
        'emp_bank_details.passport_number',
        'banks.name as bank_name',          // mapped bank name
        'emp_bank_details.sal_branch_name',
        'emp_bank_details.sal_account_number'
    )
    ->first();

    // Fetch payroll deductions and earnings components for the given payroll ID
    $components = DB::table('payroll_deductions')
        ->join('org_salary_components', 'payroll_deductions.salary_components_id', '=', 'org_salary_components.id')
        ->select(
            'payroll_deductions.amount',
            'org_salary_components.name as component_name', // Component name
            'org_salary_components.type as component_type'  // Component type (e.g., Earning/Deduction)
        )
        ->where('payroll_deductions.payroll_id', $payroll_id)
        ->get();

             // ✅ Parse salary month to find start and end
    $salaryMonth = \Carbon\Carbon::parse($payroll->salary_month);
    $monthStart = $salaryMonth->copy()->startOfMonth()->format('Y-m-d');
    $monthEnd   = $salaryMonth->copy()->endOfMonth()->format('Y-m-d');

    // ✅ Fetch approved leave summary for the payslip month
    $leaveSummary = DB::table('leave_applies as la')
        ->join('leave_types as lt', 'la.leave_type_id', '=', 'lt.id')
        ->select(
            'lt.name as leave_type_name',
            DB::raw("
                SUM(
                    CASE
                        WHEN la.half_day IN ('First Half','Second Half') THEN 0.5
                        ELSE GREATEST(
                            0,
                            DATEDIFF(
                                LEAST(la.end_date, '$monthEnd'),
                                GREATEST(la.start_date, '$monthStart')
                            ) + 1
                        )
                    END
                ) as total_days
            ")
        )
        ->where('la.user_id', $payroll->user_id)
        ->where('la.leave_approve_status', 'Approved')
        // only include leaves overlapping the payslip month
        ->whereRaw('la.start_date <= ? AND la.end_date >= ?', [$monthEnd, $monthStart])
        ->groupBy('lt.name')
        ->get();

    // Prepare data for the view
    $data = [
        'salaryMonth' => $payroll->salary_month,
        'employee' => (object)[
            'id' => $payroll->user_id,
            'employee_no' => $payroll->employee_no,
            'employee_name' => $payroll->employee_name,
            'joining_date' => $payroll->joining_date,
            'designation' => $payroll->designation_name,
            'provident_fund' => $payroll->provident_fund,
            'esic_no' => $payroll->esic_no,
            'universal_account_number' => $payroll->universal_account_number,
        ],
        'components' => $components,
        'totalEarnings' => $payroll->total_earnings,
        'totalDeductions' => $payroll->total_dedcutions,
        'netAmount' => $payroll->net_amount,
        'bankDetails' => $bankDetails, 
        'leaveSummary' => $leaveSummary,
    ];



    // Generate PDF from view
    $pdf = Pdf::loadView('user_view.payslip_layout', $data);

    $fileName = "Payslip_{$payroll->salary_month}.pdf";

    return $pdf->download($fileName);
}

public function loadPayslip($payroll_id)
{
     // Fetch payroll data for the given payroll ID
     $payroll = DB::table('payrolls')
     ->join('emp_details', 'payrolls.user_id', '=', 'emp_details.user_id') // Join with emp_details table
     ->join('organisation_designations', 'emp_details.designation', '=', 'organisation_designations.id') // Join with organisation_designations table
     ->select(
         'payrolls.*',
         'emp_details.employee_no',
         'emp_details.employee_name',
         'emp_details.joining_date',
         'organisation_designations.name as designation_name', // Fetch designation name
         'emp_details.provident_fund',
         'emp_details.esic_no',
         'emp_details.universal_account_number'
     )
     ->where('payrolls.id', $payroll_id)
     ->first();

 if (!$payroll) {
     return redirect()->back()->with('error', 'Payslip not found.');
 }

//  Fetch bank details with bank name mapping
$bankDetails = DB::table('emp_bank_details')
    ->leftJoin('banks', 'emp_bank_details.sal_bank_name', '=', 'banks.id') // map bank id to bank name
    ->where('emp_bank_details.user_id', $payroll->user_id)
    ->select(
        'emp_bank_details.passport_number',
        'banks.name as bank_name',          // mapped bank name
        'emp_bank_details.sal_branch_name',
        'emp_bank_details.sal_account_number'
    )
    ->first();

    

 // Fetch payroll deductions and earnings components for the given payroll ID
 $components = DB::table('payroll_deductions')
     ->join('org_salary_components', 'payroll_deductions.salary_components_id', '=', 'org_salary_components.id')
     ->select(
         'payroll_deductions.amount',
         'org_salary_components.name as component_name', // Component name
         'org_salary_components.type as component_type'  // Component type (e.g., Earning/Deduction)
     )
     ->where('payroll_deductions.payroll_id', $payroll_id)
     ->get();


         // ✅ Parse salary month to find start and end
    $salaryMonth = \Carbon\Carbon::parse($payroll->salary_month);
    $monthStart = $salaryMonth->copy()->startOfMonth()->format('Y-m-d');
    $monthEnd   = $salaryMonth->copy()->endOfMonth()->format('Y-m-d');

    // ✅ Fetch approved leave summary for the payslip month
    $leaveSummary = DB::table('leave_applies as la')
        ->join('leave_types as lt', 'la.leave_type_id', '=', 'lt.id')
        ->select(
            'lt.name as leave_type_name',
            DB::raw("
                SUM(
                    CASE
                        WHEN la.half_day IN ('First Half','Second Half') THEN 0.5
                        ELSE GREATEST(
                            0,
                            DATEDIFF(
                                LEAST(la.end_date, '$monthEnd'),
                                GREATEST(la.start_date, '$monthStart')
                            ) + 1
                        )
                    END
                ) as total_days
            ")
        )
        ->where('la.user_id', $payroll->user_id)
        ->where('la.leave_approve_status', 'Approved')
        // only include leaves overlapping the payslip month
        ->whereRaw('la.start_date <= ? AND la.end_date >= ?', [$monthEnd, $monthStart])
        ->groupBy('lt.name')
        ->get();
     

 // Prepare data for the view
 $data = [
     'salaryMonth' => $payroll->salary_month,
     'employee' => (object)[
         'id' => $payroll->user_id,
         'employee_no' => $payroll->employee_no,
         'employee_name' => $payroll->employee_name,
         'joining_date' => $payroll->joining_date,
         'designation' => $payroll->designation_name, // Use designation name
         'provident_fund' => $payroll->provident_fund,
         'esic_no' => $payroll->esic_no,
         'universal_account_number' => $payroll->universal_account_number,
     ],
     'components' => $components,
     'totalEarnings' => $payroll->total_earnings,
     'totalDeductions' => $payroll->total_dedcutions,
     'netAmount' => $payroll->net_amount,
     'bankDetails' => $bankDetails, 
     'leaveSummary' => $leaveSummary,
 ];

 // Return the payslip view
 return view('user_view.payslip_layout', $data);
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
         ->join('organisation_reimbursement_types', 'reimbursement_form_entries.organisation_reimbursement_types_id', '=', 'organisation_reimbursement_types.id')
         ->leftJoin('organisation_reimbursement_type_restrictions', 'organisation_reimbursement_types.id', '=', 'organisation_reimbursement_type_restrictions.reimbursement_type_id') // Use LEFT JOIN here
         ->select(
             'reimbursement_trackings.id as tracking_id',
             'reimbursement_trackings.token_number',
             'emp_details.employee_no',
             'emp_details.employee_name',
             'reimbursement_trackings.start_date',
             'reimbursement_trackings.end_date',
             'reimbursement_trackings.description',
             'reimbursement_trackings.status',
             'organisation_reimbursement_types.name as type_name',
             DB::raw('COALESCE(organisation_reimbursement_type_restrictions.max_amount, "N/A") as max_amount'), // Handle NULL for max_amount
             'reimbursement_form_entries.organisation_reimbursement_types_id',
             DB::raw('SUM(reimbursement_form_entries.amount) as total_amount'),
             DB::raw('COUNT(reimbursement_form_entries.id) as no_of_entries'),
             'reimbursement_form_entries.id as entry_id', // Include the entry ID
             'reimbursement_form_entries.date as entry_date',
             'reimbursement_form_entries.amount as entry_amount',
             'reimbursement_form_entries.upload_bill',
             'reimbursement_form_entries.description_by_applicant',
             'reimbursement_form_entries.status as entry_status'
         )
         ->where('reimbursement_trackings.id', '=', $reimbursement_traking_id)
         ->where('reimbursement_trackings.user_id', '=', $user_id)
         ->groupBy(
             'reimbursement_trackings.id',
             'reimbursement_trackings.token_number',
             'emp_details.employee_no',
             'emp_details.employee_name',
             'reimbursement_trackings.start_date',
             'reimbursement_trackings.end_date',
             'reimbursement_trackings.description',
             'reimbursement_trackings.status',
             'reimbursement_form_entries.id', // Add entry ID to groupBy
             'reimbursement_form_entries.date',
             'reimbursement_form_entries.amount',
             'reimbursement_form_entries.upload_bill',
             'reimbursement_form_entries.description_by_applicant',
             'reimbursement_form_entries.status',
             'organisation_reimbursement_type_restrictions.max_amount'
         )
         ->get();
//  dd($reimbursementList);
     $reim_type = DB::table('reimbursement_form_entries')
         ->join('organisation_reimbursement_types', 'reimbursement_form_entries.organisation_reimbursement_types_id', '=', 'organisation_reimbursement_types.id')
         ->leftJoin('organisation_reimbursement_type_restrictions', 'organisation_reimbursement_types.id', '=', 'organisation_reimbursement_type_restrictions.reimbursement_type_id') // Use LEFT JOIN here
         ->where('reimbursement_form_entries.reimbursement_trackings_id', '=', $reimbursement_traking_id)
         ->select(
             'organisation_reimbursement_types.name as type_name',
             DB::raw('COALESCE(organisation_reimbursement_type_restrictions.max_amount, "N/A") as max_amount') // Handle NULL for max_amount
         )
         ->get(); // Fetch all matching records
 
     return view('user_view.users_claim', compact('reimbursementList', 'reimbursement_traking_id', 'reim_type'));
 }

public function loadMangerClaims($manager_id, $reimbursement_traking_id)
{
    // Fetch claims approved by employees under the reporting manager and specific reimbursement tracking ID
    $managerClaims = DB::table('reimbursement_trackings')
    ->join('emp_details as employees', 'reimbursement_trackings.user_id', '=', 'employees.user_id')
    ->join('reimbursement_form_entries', 'reimbursement_trackings.id', '=', 'reimbursement_form_entries.reimbursement_trackings_id')
    ->join('organisation_reimbursement_types', 'reimbursement_form_entries.organisation_reimbursement_types_id', '=', 'organisation_reimbursement_types.id')
    ->leftJoin('organisation_reimbursement_type_restrictions', 'organisation_reimbursement_types.id', '=', 'organisation_reimbursement_type_restrictions.reimbursement_type_id') // Use LEFT JOIN here
    ->select(
        'reimbursement_form_entries.id as entry_id',
        'reimbursement_form_entries.date as entry_date',
        'reimbursement_form_entries.amount as entry_amount',
        'reimbursement_form_entries.upload_bill',
        'reimbursement_form_entries.description_by_applicant',
        'reimbursement_form_entries.description_by_manager',
        'reimbursement_trackings.id as tracking_id',
        'reimbursement_trackings.token_number',
        DB::raw('COALESCE(organisation_reimbursement_type_restrictions.max_amount, "N/A") as max_amount'), // Handle NULL for max_amount
        'reimbursement_form_entries.organisation_reimbursement_types_id',
        'organisation_reimbursement_types.name as type_name', // Include type name
        'employees.employee_no',
        'employees.employee_name',
        DB::raw('SUM(reimbursement_form_entries.amount) as total_amount'),
        'reimbursement_trackings.status',
        'reimbursement_trackings.description',
        'reimbursement_trackings.created_at as claim_date'
    )
    ->where('employees.reporting_manager', '=', $manager_id) // Filter by reporting manager
    ->where('reimbursement_trackings.id', '=', $reimbursement_traking_id) // Filter by reimbursement tracking ID
    ->where('reimbursement_trackings.status', '=', 'APPROVED BY MANAGER') // Only show approved claims
    ->groupBy(
        'reimbursement_form_entries.id',
        'reimbursement_form_entries.date',
        'reimbursement_form_entries.amount',
        'reimbursement_form_entries.upload_bill',
        'reimbursement_form_entries.description_by_applicant',
        'reimbursement_form_entries.description_by_manager',
        'reimbursement_trackings.id',
        'reimbursement_trackings.token_number',
        'employees.employee_no',
        'employees.employee_name',
        'reimbursement_trackings.status',
        'reimbursement_trackings.description',
        'reimbursement_trackings.created_at',
        'organisation_reimbursement_type_restrictions.max_amount',
        'organisation_reimbursement_types.name' // Add type_name to groupBy
    )
    ->get();

    //    dd($managerClaims);
        $reim_type = DB::table('reimbursement_form_entries')
    ->join('organisation_reimbursement_types', 'reimbursement_form_entries.organisation_reimbursement_types_id', '=', 'organisation_reimbursement_types.id')
    ->leftJoin('organisation_reimbursement_type_restrictions', 'organisation_reimbursement_types.id', '=', 'organisation_reimbursement_type_restrictions.reimbursement_type_id') // Use LEFT JOIN here
    ->where('reimbursement_form_entries.reimbursement_trackings_id', '=', $reimbursement_traking_id)
    ->select(
        'organisation_reimbursement_types.name as type_name',
        'organisation_reimbursement_type_restrictions.max_amount as max_amount'
    )
    ->get(); // Fetch all matching records
// dd($reim_type);
    return view('user_view.managers_claim', compact('managerClaims', 'reimbursement_traking_id', 'reim_type'));
}

 public function loadreviewclaimform($reimbursement_traking_id = null)
{
    $loginUserInfo = Auth::user();

    if (!$reimbursement_traking_id) {
        return redirect()->route('PayRollDashboard')->with('error', 'Reimbursement Tracking ID is required.');
    }

    $reimbursementClaims = DB::table('reimbursement_trackings')
        ->join('reimbursement_form_entries', 'reimbursement_trackings.id', '=', 'reimbursement_form_entries.reimbursement_trackings_id')
        ->join('organisation_reimbursement_types', 'reimbursement_form_entries.organisation_reimbursement_types_id', '=', 'organisation_reimbursement_types.id')
        ->select(
            'reimbursement_trackings.token_number',
            'reimbursement_form_entries.date as entry_date',
            'reimbursement_form_entries.amount as entry_amount',
            'reimbursement_form_entries.upload_bill',
            'reimbursement_form_entries.description_by_applicant',
            'reimbursement_trackings.status as status',
            'organisation_reimbursement_types.name as type_name'
        )
        ->where('reimbursement_trackings.id', '=', $reimbursement_traking_id)
        ->where('reimbursement_trackings.user_id', '=', $loginUserInfo->id)
        ->get();

    $reim_type = DB::table('organisation_reimbursement_types')
        ->where('organisation_id', '=', $loginUserInfo->organisation_id)
        ->where('status', '=', 'Active')
        ->get();

         // Fetch the token number for the tracking ID
    $tokenNumber = DB::table('reimbursement_trackings')
    ->where('id', '=', $reimbursement_traking_id)
    ->value('token_number');

    return view('user_view.review_claim_from', compact('reimbursementClaims', 'reimbursement_traking_id', 'reim_type', 'tokenNumber'));
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
        //  'start_date' => 'required|date',
        //  'end_date' => 'required|date',
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
    // 'start_date'   => $data['start_date'],
    // 'end_date'     => $data['end_date'],
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

 public function loadSalaryCycleForm(){

    $org_data = Auth::guard('superadmin')->user();

    $cycle_datas = DB::table('salary_cycles')
    ->where('organisation_id',$org_data->id)
    ->get();

    // dd($cycle_datas);

    return view('superadmin_view.create_salary_cycle',compact('cycle_datas'));

 }

//  public function loadSalaryConfigurationForm(){

//     return view('superadmin_view.create_salary_configuration');

//  }

public function insertSalaryCycle(Request $request){

    $data = $request->validate([
        'name' => 'required',
        'applicable_from' => 'required',
        'applicable_to' => 'required',
        'month_start_date' => 'required',
        'month_end_date' => 'required',
        'status' => 'required'
    ]);

    $org_data = Auth::guard('superadmin')->user();

    $status = DB::table('salary_cycles')->insert([
        'organisation_id' => $org_data->id,
        'name' => $data['name'],
        'start_date' => $data['applicable_from'] ,
        'end_date' => $data['applicable_to'],
        'month_start' => $data['month_start_date'],
        'month_end' => $data['month_end_date'],
        'status' => $data['status'],
        'created_at' => NOW(),
        'updated_at' => NOW(),

    ]);

    if($status){

        return redirect()->route('create_salary_cycle')->with('success','Record Inserted');

    }
    return redirect()->route('create_salary_cycle')->with('error','Record Not Inserted');

}
 


public function updateSalaryCycle(Request $request, $id)
{
    // Retrieve the request data directly
    $data = $request->all();

    // Check if the salary cycle exists
    $salaryCycle = DB::table('salary_cycles')->where('id', $id)->first();

    if (!$salaryCycle) {
        return redirect()->route('create_salary_cycle')->with('error', 'Salary Cycle not found.');
    }

    // Update the salary cycle
    $status = DB::table('salary_cycles')
        ->where('id', $id)
        ->update([
            'name' => $data['name'] ?? $salaryCycle->name,
            'start_date' => $data['applicable_from'] ?? $salaryCycle->start_date,
            'end_date' => $data['applicable_to'] ?? $salaryCycle->end_date,
            'month_start' => $data['month_start_date'] ?? $salaryCycle->month_start,
            'month_end' => $data['month_end_date'] ?? $salaryCycle->month_end,
            'status' => $data['status'] ?? $salaryCycle->status,
            'updated_at' => now(),
        ]);

    // Debugging: Check the update status
    // dd($status);

    if ($status) {
        return redirect()->route('create_salary_cycle')->with('success', 'Salary Cycle updated successfully.');
    } else {
        return redirect()->route('create_salary_cycle')->with('error', 'Failed to update Salary Cycle.');
    }
}



public function loadEditClaimForm($reimbursement_traking_id = null)
{
    $loginUserInfo = Auth::user();

    if (!$reimbursement_traking_id) {
        return redirect()->route('PayRollDashboard')->with('error', 'Reimbursement Tracking ID is required.');
    }

    $reimbursementClaims = DB::table('reimbursement_trackings')
        ->join('reimbursement_form_entries', 'reimbursement_trackings.id', '=', 'reimbursement_form_entries.reimbursement_trackings_id')
        ->join('organisation_reimbursement_types', 'reimbursement_form_entries.organisation_reimbursement_types_id', '=', 'organisation_reimbursement_types.id')
        ->select(
            'reimbursement_form_entries.id',
            'reimbursement_form_entries.date as entry_date',
            'reimbursement_form_entries.amount as entry_amount',
            'reimbursement_form_entries.upload_bill',
            'reimbursement_form_entries.description_by_applicant',
            'reimbursement_form_entries.description_by_manager',
            'reimbursement_form_entries.status', // Include the status column
            'reimbursement_form_entries.description_by_finance',
            'reimbursement_form_entries.organisation_reimbursement_types_id',
            'organisation_reimbursement_types.name as type_name',
            'reimbursement_trackings.description',
            'organisation_reimbursement_type_restrictions.max_amount'
        )
        ->leftJoin('organisation_reimbursement_type_restrictions', 'organisation_reimbursement_types.id', '=', 'organisation_reimbursement_type_restrictions.reimbursement_type_id')
        ->where('reimbursement_trackings.id', '=', $reimbursement_traking_id)
        ->where('reimbursement_trackings.user_id', '=', $loginUserInfo->id)
        ->get();

        // Add an 'editable' property based on the status
        $reimbursementClaims = $reimbursementClaims->map(function ($claim) {
            $claim->editable = $claim->status === 'REVERT'; // Editable only if status is 'REVERT'
            return $claim;
        });

// dd($reimbursementClaims);
    $reim_type = DB::table('organisation_reimbursement_types')
        ->where('organisation_id', '=', $loginUserInfo->organisation_id)
        ->where('status', '=', 'Active')
        ->get();

    return view('user_view.edit_claim_form', compact('reimbursementClaims', 'reimbursement_traking_id', 'reim_type'));
}


public function cancelReimbursement($reimbursement_traking_id)
{
    $loginUserInfo = Auth::user();

    // Update the status to "Cancel"
    DB::table('reimbursement_trackings')
        ->where('id', $reimbursement_traking_id)
        ->where('user_id', $loginUserInfo->id)
        ->update([
        'status' => 'CANCELLED',
            'updated_at' => now(),
        ]);

    return redirect()->route('PayRollDashboard')->with('success', 'Reimbursement claim has been canceled.');
}

public function updateClaimForm(Request $request, $reimbursement_traking_id)
{
    $loginUserInfo = Auth::user();

    // Update reimbursement tracking description
    DB::table('reimbursement_trackings')
        ->where('id', $reimbursement_traking_id)
        ->where('user_id', $loginUserInfo->id)
        ->update([
            'description' => $request->clam_comment,
            'status' => 'PENDING', // Automatically set status to 'PENDING'
            'updated_at' => now(),
        ]);

    // Loop through claims and update reimbursement entries
    foreach ($request->entry_ids as $i => $entryId) {
        $filePath = null;

        // Upload bill file if present
        if ($request->hasFile("bills.$i")) {
            $filePath = $request->file("bills.$i")->store('bills', 'public');
        }

        $entryUpdated =  DB::table('reimbursement_form_entries')
            ->where('id', $entryId) // Use the entry ID to target the specific row
            ->where('reimbursement_trackings_id', $reimbursement_traking_id) // Ensure it matches the tracking ID
            ->update([
                'date' => $request->bill_date[$i] ?? null,
                'organisation_reimbursement_types_id' => $request->type[$i],
                'amount' => $request->entered_amount[$i],
                'upload_bill' => $filePath ?? DB::raw('upload_bill'), // Keep existing file if no new file is uploaded
                'description_by_applicant' => $request->comments[$i] ?? null,
                'updated_at' => now(),
            ]);
    }
  
    // Check if all entries were updated successfully
    if ($entryUpdated) {
        return redirect()->route('PayRollDashboard')->with('success', 'Reimbursement claim updated successfully.');
    } else {
        return redirect()->route('PayRollDashboard')->with('error', 'Some entries could not be updated.');
    }
    // return redirect()->route('PayRollDashboard')->with('success', 'Reimbursement claim updated successfully.');
}


public function updateReimbursementStatus(Request $request, $reimbursement_traking_id)
{
    // Validate the request
    $data = $request->validate([
        'status' => 'required|string',
        'remarks' => 'array', // Ensure remarks is an array
        'remarks.*' => 'nullable|string', // Each remark can be nullable
        'task_name' => 'nullable|string|max:200', // Validate the task_name field
        'checkboxes' => 'array', // Ensure checkboxes is an array
        'checkboxes.*' => 'nullable|boolean', // Each checkbox value can be true/false
    ]);

    $status = $data['status'];
    $remarks = $data['remarks'];
    $taskName = $data['task_name']; // Get the task_name input
    $checkboxes = $data['checkboxes']; // Get the checkbox states
    

    // Update the status in reimbursement_trackings
    DB::table('reimbursement_trackings')
        ->where('id', $reimbursement_traking_id)
        ->update([
            'status' => $status,
            'updated_at' => now(),
        ]);

 // Update the status and description_by_manager in reimbursement_form_entries
 foreach ($remarks as $entryId => $remark) {
    $entryStatus = isset($checkboxes[$entryId]) && $checkboxes[$entryId] ? 'PENDING' : 'REVERT';

    DB::table('reimbursement_form_entries')
        ->where('id', $entryId) // Ensure it matches the specific entry ID
        ->where('reimbursement_trackings_id', $reimbursement_traking_id) // Ensure it matches the tracking ID
        ->update([
            'description_by_manager' => $remark,
            'status' => $entryStatus, // Update the status based on the checkbox
            'updated_at' => now(),
        ]);
}
    



    // Update the comments column in assign_reimbursement_tokens
    DB::table('assign_reimbursement_tokens')
    ->where('reimbursement_tracking_id', $reimbursement_traking_id)
    ->update([
        'comments' => $taskName, // Save the task_name in the comments column
        'updated_at' => now(),
    ]);

    return redirect()->route('user.homepage')->with('success', 'Reimbursement status updated successfully.');
}


public function updateFinanceReimbursementStatus(Request $request, $reimbursement_traking_id)
{
    // Validate the request
    $data = $request->validate([
        'status' => 'required|string',
        'remarks' => 'array', // Ensure remarks is an array
        'remarks.*' => 'nullable|string', // Each remark can be nullable
        'task_name' => 'nullable|string|max:200', // nullable the task_name field
        'checkboxes' => 'array', // Ensure checkboxes is an array
        'checkboxes.*' => 'nullable|boolean', // Each checkbox value can be true/false
    ]);

    $status = $data['status'];
    $remarks = $data['remarks'];
    $taskName = $data['task_name']; // Get the task_name input
    $checkboxes = $data['checkboxes']; // Get the checkbox states

    // Update the status in reimbursement_trackings
    DB::table('reimbursement_trackings')
        ->where('id', $reimbursement_traking_id)
        ->update([
            'status' => $status,
            'updated_at' => now(),
        ]);

    // Update the description_by_finance in reimbursement_form_entries
    // foreach ($remarks as $entryId => $remark) {
    //     DB::table('reimbursement_form_entries')
    //         ->where('id', $entryId)
    //         ->where('reimbursement_trackings_id', $reimbursement_traking_id) // Ensure it matches the tracking ID
    //         ->update([
    //             'description_by_finance' => $remark, // Update description_by_finance
    //             'updated_at' => now(),
    //         ]);
    // }

    foreach ($request->remarks as $entryId => $remark) {
        $entryStatus = isset($checkboxes[$entryId]) && $checkboxes[$entryId] ? 'APPROVED ' : 'REVERT ';
    
        DB::table('reimbursement_form_entries')
            ->where('id', $entryId) // Ensure it matches the specific entry ID
            ->where('reimbursement_trackings_id', $reimbursement_traking_id) // Ensure it matches the tracking ID
            ->update([
                'description_by_finance' => $remark,
                'status' => $entryStatus, // Update the status based on the checkbox
                'updated_at' => now(),
            ]);
    }

    // foreach ($checkboxes as $entryId => $isChecked) {
    //     $entryStatus = $isChecked ? 'APPROVED' : 'REVERT';
    
    //     DB::table('reimbursement_form_entries')
    //         ->where('id', $entryId)
    //         ->where('reimbursement_trackings_id', $reimbursement_traking_id) // Ensure it matches the tracking ID
    //         ->update([
    //             'status' => $entryStatus,
    //             'updated_at' => now(),
    //         ]);
    // }
// dd($entryStatus);
    // Update the comments column in assign_reimbursement_tokens
    DB::table('assign_reimbursement_tokens')
        ->where('reimbursement_tracking_id', $reimbursement_traking_id)
        ->update([
            'comments' => $taskName, // Save the task_name in the comments column
            'updated_at' => now(),
        ]);
// dd($request->all());
    return redirect()->route('user.homepage')->with('success', 'Reimbursement status updated successfully.');
}

public function loadCompForm(){

    $org_data = Auth::guard('superadmin')->user();
    $template_datas = DB::table('org_salary_components')
    ->where('organisation_id', '=', $org_data->id)
    ->where('status', '=', 'Active')
    ->get();
// dd($template_datas);
    return view('superadmin_view.create_comp',compact('template_datas'));

}

public function insertComponents(Request $request){
    $data = $request->validate([
        'name' => 'required',
        'component_type' => 'required',
        'status' => 'required',
    ]);

    $org_data = Auth::guard('superadmin')->user();

    $insertStatus = DB::table('org_salary_components')->insert([
        'organisation_id' => $org_data->id,
        'name' => $data['name'],
        'type' => $data['component_type'],
        'status' => $data['status'],
        'created_at' => NOW(),
        'updated_at' => NOW(),
    ]);

    if($insertStatus){

        return redirect()->route('create_components')->with('success','Component Created Successfully!!');

    }

    return redirect()->route('create_components')->with('error','Component Not Created Successfully!!');

}

public function updateComponents(Request $request, $id) {
    // Validate the incoming request data
    $data = $request->validate([
        'name' => 'required',
        'type' => 'required',
        'status' => 'required',
    ]);

    // Get the authenticated superadmin's organization ID
    $org_data = Auth::guard('superadmin')->user();

    // Perform the update
    $updateStatus = DB::table('org_salary_components')
        ->where('organisation_id', $org_data->id)
        ->where('id', $id)
        ->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'status' => $data['status'],
            'updated_at' => NOW(),
        ]);

    // Return with appropriate success or error message
    if ($updateStatus) {
        return redirect()->route('create_components')->with('success', 'Component Updated Successfully!!');
    }

    return redirect()->route('create_components')->with('error', 'Component Not Updated Successfully!!');
}



}

