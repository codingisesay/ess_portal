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
        $datas = DB::table('hr_policy_categories')->where('organisation_id', $id)->get();
        return view('superadmin_view.create_policy_category', compact('datas'));
    }

    public function savePolicyCategory(Request $request)
    {
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

        if ($status) {
            return redirect()->route('create_policy_category')->with('success', 'Policy Category saved successfully.');
        } else {
            return redirect()->route('create_policy_category')->with('error', 'Policy Category not saved successfully.');
        }
    }

    public function updatePolicyCategory(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $policyCategory = DB::table('hr_policy_categories')->where('id', $id)->first();

        if (!$policyCategory) {
            return redirect()->route('create_policy_category')->with('error', 'Policy Category not found.');
        }

        $status = DB::table('hr_policy_categories')
            ->where('id', $id)
            ->update([
                'name' => $request->category_name,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        if ($status) {
            return redirect()->route('create_policy_category')->with('success', 'Policy Category updated successfully.');
        } else {
            return redirect()->route('create_policy_category')->with('error', 'Failed to update Policy Category.');
        }
    }

    public function createHrPolicy()
    {
        $id = Auth::guard('superadmin')->user()->id;
        $categories = DB::table('hr_policy_categories')->where('organisation_id', $id)->get();
        $datas = DB::table('hr_policies')->where('organisation_id', $id)->get();

        return view('superadmin_view.create_hr_policy', compact('categories', 'datas'));
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
        $contentImagePath = $request->file('content_image') ? $request->file('content_image')->store('images', 'public') : null;

        $id = Auth::guard('superadmin')->user()->id;

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

        if ($status) {
            return redirect()->route('create_hr_policy')->with('success', 'HR Policy saved successfully.');
        } else {
            return redirect()->route('create_hr_policy')->with('error', 'HR Policy not saved successfully.');
        }
    }

    public function updateHrPolicy(Request $request, $id)
    {
        $request->validate([
            'policy_title' => 'required|string|max:255',
            'category_id' => 'required|exists:hr_policy_categories,id',
            'status' => 'required|in:Active,Inactive',
        ]);

        $policy = DB::table('hr_policies')->where('id', $id)->first();

        if (!$policy) {
            return redirect()->route('create_hr_policy')->with('error', 'HR Policy not found.');
        }

        $status = DB::table('hr_policies')
            ->where('id', $id)
            ->update([
                'policy_title' => $request->policy_title,
                'policy_categorie_id' => $request->category_id,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        if ($status) {
            return redirect()->route('create_hr_policy')->with('success', 'HR Policy updated successfully.');
        } else {
            return redirect()->route('create_hr_policy')->with('error', 'Failed to update HR Policy.');
        }
    }

    public function showHrPolicy()
    {
        $title = "HR Policy";
        $loginUserInfo = Auth::user();
        $organisationId = $loginUserInfo->organisation_id;

        $policies = DB::table('hr_policies')
            ->join('hr_policy_categories', 'hr_policies.policy_categorie_id', '=', 'hr_policy_categories.id')
            ->where('hr_policies.organisation_id', $organisationId)
            ->where('hr_policies.status', 'Active') // Only bring active policies
            ->where('hr_policy_categories.status', 'Active') // Only bring active categories
            ->select('hr_policies.*', 'hr_policy_categories.name as category_name')
            ->get();

        return view('user_view.hr_policy', compact('policies', 'title'));
    }

    public function getPoliciesByCategory($id)
    {
        $loginUserInfo = Auth::user();
        $organisationId = $loginUserInfo->organisation_id;

        $policies = DB::table('hr_policies')
            ->where('policy_categorie_id', $id)
            ->where('organisation_id', $organisationId)
            ->get();

        // dd($policies); // Debugging statement to check fetched data

        return view('user_view.hr_policy_category', compact('policies'));
    }
}
