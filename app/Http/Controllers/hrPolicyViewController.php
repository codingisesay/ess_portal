<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\hrPolicyCategory;

class hrPolicyViewController extends Controller
{
    // Show the form to create a new policy category
    public function createPolicyCategory()
    {
        $id = Auth::guard('superadmin')->user()->id;
        $datas = DB::table('hr_policy_categories')->where('organisation_id',$id)->get();
        // dd($datas);
        return view('superadmin_view.create_policy_category',compact('datas'));
    }

    public function savePolicyCategory(Request $request){

        $request->validate([
            'category_name' => 'required',
            'status' => 'required',
        ]);
        $id = Auth::guard('superadmin')->user()->id;

       $status = DB::table('hr_policy_categories')->insert([
            'name' => $request->category_name,
            'status' => $request->status,
            'organisation_id' => $id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if($status){

            return redirect()->route('create_policy_category')->with('success', 'Policy Category saved successfully.');

        }else{

            return redirect()->route('create_policy_category')->with('success', 'Policy Category saved successfully.');

        }

    }

    public function createHrPolicy(){
        $id = Auth::guard('superadmin')->user()->id;
        $categories = DB::table('hr_policy_categories')->where('organisation_id',$id)->get();
        $datas = DB::table('hr_policies')->where('organisation_id',$id)->get();

        return view('superadmin_view.create_hr_policy',compact('categories','datas'));
    }

    // Save a new HR policy
    public function saveHrPolicy(Request $request)
    {
        $request->validate([
            'policy_title' => 'required',
            'category_id' => 'required',
            'policy_content' => 'required',
            'document' => 'nullable|file',
            'icon' => 'nullable|file',
            'content_image' => 'nullable|file',
            'status' => 'required',
        ]);

        $documentPath = $request->file('document') ? $request->file('document')->store('documents', 'public') : null;
        $iconPath = $request->file('icon') ? $request->file('icon')->store('icons', 'public') : null;
        $contentImagePath = $request->file('content_image') ? $request->file('content_image')->store('image', 'public') : null;
        
        $id = Auth::guard('superadmin')->user()->id;
// dd($data);
        $status = DB::table('hr_policies')->insert([
            'policy_categorie_id' => $request->category_id,
            'organisation_id' => $id,
            'policy_title' => $request->policy_title,
            'policy_content' => $request->policy_content,
            'docName' => $request->file('document') ? $request->file('document')->getClientOriginalName() : null,
            'docLink' => $documentPath,
            'iconName' => $request->file('icon') ? $request->file('icon')->getClientOriginalName() : null,
            'iconLink' => $iconPath,
            'imgName' => $request->file('content_image') ? $request->file('content_image')->getClientOriginalName() : null,
            'imgLink' => $contentImagePath,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if($status){

            return redirect()->route('create_hr_policy')->with('success', 'HR Policy saved successfully.');

        }else{

            return redirect()->route('create_hr_policy')->with('error', 'HR Policy Not saved successfully.');

        }

        // return redirect()->route('create_hr_policy')->with('success', 'HR Policy saved successfully.');
    }

   

   
}
