<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\organisation_designation;
use App\Models\feature;
use App\Models\module;
use App\Models\organisation_buy_module;
use App\Models\permission;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class permissionController extends Controller
{
    public function index($org_id, $desig_id, $b_id){
        $id = Auth::guard('superadmin')->user()->id;

    //     $results = DB::table('organisation_designations')
    // ->join('organisation_departments', 'organisation_designations.department_id', '=', 'organisation_departments.id')
    // ->join('branches', 'organisation_designations.branch_id', '=', 'branches.id')
    // ->select('organisation_departments.name as department_name', 'organisation_designations.name as designation_name','organisation_designations.id as designation_id','branches.id as branch_id','branches.name as branch_name')
    // ->where('organisation_departments.organisation_id', '=', $id) // Adding a WHERE condition to filter by department name
    // ->get();

    $results = DB::table('organisation_buy_modules')
    ->join('modules', 'organisation_buy_modules.module_id', '=', 'modules.id') // Assuming it's module_id in the organisation_buy_module table that relates to module.id
    ->select('modules.name as module_name')
    ->where('organisation_buy_modules.organisation_id', '=', $id) // Filter by the organisation_id passed
    ->get();

    $features = DB::table('features')
    ->join('modules', 'features.module_id', '=', 'modules.id')
    ->select('features.id as feature_id', 'features.name', 'modules.name as module_name')
    ->get();


        return view('superadmin_view.create_permission',compact('results','features','org_id', 'desig_id', 'b_id'));
    }

    public function insertPermission(Request $request,$org_id,$desig_id,$b_id){

        // echo "Org id".$org_id."<br>";
        // echo "Desig id".$desig_id."<br>";;
        // echo "branch id".$b_id."<br>";;
       

            // Retrieve the selected checkbox values
    $selectedFeatures = $request->input('features', []); // Default to an empty array if no checkboxes are selected

    // dd($selectedFeatures);

    // Optionally, you can check if there are selected features
    if (!empty($selectedFeatures)) {
        // Process the selected features, e.g., save to the database or perform some logic
        foreach ($selectedFeatures as $featureId) {

          $permission_insert = permission::create([
                'organisation_designations_id' => $desig_id,
                'feature_id' => $featureId,
                'branch_id' => $b_id,
                'organisation_id' => $org_id,
            ]);

          
        }
    } else {
        // No features were selected
        return redirect()->back()->with('message', 'No features selected.');
    }

    // Redirect or return a response
    return redirect()->route('create_designation_form')->with('message', 'Features processed successfully.');
    

    }
}
