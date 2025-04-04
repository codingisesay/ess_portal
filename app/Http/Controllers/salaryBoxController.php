<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        ->select('org_tax_regime_years.name as org_tax_regime_years_name',
        'org_tax_slabs.tax_type as tax_type',
        'org_tax_slabs.min_income as min_income',
        'org_tax_slabs.max_income as max_income',
        'org_tax_slabs.tax as tax_per',
        'org_tax_slabs.fixed_amount as fixed_amount',
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

        if($status){

            return redirect()->route('taxes')->with('success','Tax Cycyle Created Successfully!!');

        }

        return redirect()->route('taxes')->with('error','Tax Cycyle Created Successfully!!');

    }


}
