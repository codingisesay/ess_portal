<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\HrPolicyCategory;

class hrPolicyViewController extends Controller
{
    // Show HR policies to the user
    public function showHrPolicy()
    {
        $categories = HrPolicyCategory::all();
        $organisationId = session('organisation_id');
        $policies = DB::table('hr_policies')
            ->join('hr_policy_categories', 'hr_policies.policy_categorie_id', '=', 'hr_policy_categories.id')
            ->where('hr_policy_categories.organisation_id', $organisationId)
            ->select('hr_policies.*', 'hr_policy_categories.name as category_name')
            ->get();

        return view('user_view.hr_policy', compact('categories', 'policies'));
    }

    // Show the form to create a new HR policy
    public function createHrPolicy()
    {
        $categories = HrPolicyCategory::all();
        return view('superadmin_view.create_hr_policy', compact('categories'));
    }

    // Save a new HR policy
    public function saveHrPolicy(Request $request)
    {
        $request->validate([
            'policy_title' => 'required|string|max:50',
            'category_id' => 'required|exists:hr_policy_categories,id',
            'policy_content' => 'required|string|max:255',
            'document' => 'nullable|file',
            'icon' => 'nullable|file',
            'content_image' => 'nullable|file',
        ]);

        $documentPath = $request->file('document') ? $request->file('document')->store('documents', 'public') : null;
        $iconPath = $request->file('icon') ? $request->file('icon')->store('icons', 'public') : null;
        $contentImagePath = $request->file('content_image') ? $request->file('content_image')->store('images', 'public') : null;

        DB::table('hr_policies')->insert([
            'policy_categorie_id' => $request->category_id,
            'policy_title' => $request->policy_title,
            'policy_content' => $request->policy_content,
            'docName' => $request->file('document') ? $request->file('document')->getClientOriginalName() : null,
            'docLink' => $documentPath,
            'iconName' => $request->file('icon') ? $request->file('icon')->getClientOriginalName() : null,
            'iconLink' => $iconPath,
            'imgnName' => $request->file('content_image') ? $request->file('content_image')->getClientOriginalName() : null,
            'imgLink' => $contentImagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('create_hr_policy')->with('success', 'HR Policy saved successfully.');
    }

    // Show the form to create a new policy category
    public function createPolicyCategory()
    {
        return view('superadmin_view.create_policy_category');
    }

    // Save a new policy category
    public function savePolicyCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:50',
        ]);

        // Get the organisation ID of the logged-in superadmin
        $organisationId = Auth::guard('superadmin')->user()->id;

        HrPolicyCategory::create([
            'name' => $request->category_name,
            'organisation_id' => $organisationId,
        ]);

        return redirect()->route('create_policy_category')->with('success', 'Policy Category saved successfully.');
    }

    // List all policy categories
    public function listPolicyCategories()
    {
        $categories = HrPolicyCategory::all();
        return view('superadmin_view.list_policy_categories', compact('categories'));
    }

    // Update a policy category
    public function updatePolicyCategory(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:50',
        ]);

        $category = HrPolicyCategory::findOrFail($id);
        $category->update([
            'name' => $request->category_name,
        ]);

        return redirect()->route('list_policy_categories')->with('success', 'Policy Category updated successfully.');
    }

    // Get policies by category
    public function getPoliciesByCategory($categoryId)
    {
        $category = HrPolicyCategory::findOrFail($categoryId);
        $policies = DB::table('hr_policies')
            ->where('policy_categorie_id', $categoryId)
            ->get();

        return view('user_view.hr_policies_by_category', compact('category', 'policies'));
    }
}
