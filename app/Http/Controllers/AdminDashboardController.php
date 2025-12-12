<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\View\View;
 
class AdminDashboardController extends Controller
{
    // Show admin dashboard
    public function adminDashboard(): View
    {
        return view('admin_view.dashboard');
    }
// Method to insert new organisation details
    public function clientmasterinsert(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:50',
        'client_name' => 'nullable|string|max:225',
        'email' => 'required|email|max:50|unique:organisations,email',
        'password' => 'required|string|min:6',

        'contact_person' => 'nullable|string|max:225',
        'mobile' => 'nullable|string|max:15',

        // Address
        'building_no' => 'nullable|string|max:10',
        'premises_name' => 'nullable|string|max:100',
        'landmark' => 'nullable|string|max:150',
        'road_street' => 'nullable|string|max:150',
        'pincode' => 'nullable|string|max:15',
        'district' => 'nullable|string|max:50',
        'state' => 'nullable|string|max:50',
        'country' => 'nullable|string|max:50',

        'GST_number' => 'nullable|string|max:15',
        'industry_type' => 'nullable|string|max:225',
        'number_of_emplooyees' => 'nullable|integer',
        'software_package_plan' => 'nullable|string|max:225',
        'storage_limit' => 'nullable|string|max:225',
        'number_of_user_allowed' => 'nullable|integer',
        'TAN' => 'nullable|string|max:10',
        'PAN' => 'nullable|string|max:10',
        'expire_date' => 'nullable|date',

        // Certificates
        'MSME_udyam_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        'GST_registration_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',

        'organisation_status' => 'nullable|in:Active,Incative',
    ]);

    // Hash password
    $data['password'] = bcrypt($data['password']);

    // Handle file uploads
    if ($request->hasFile('MSME_udyam_certificate')) {
        $data['MSME_udyam_certificate'] = file_get_contents($request->file('MSME_udyam_certificate'));
    }

    if ($request->hasFile('GST_registration_certificate')) {
        $data['GST_registration_certificate'] = file_get_contents($request->file('GST_registration_certificate'));
    }

    \DB::table('organisations')->insert($data);

    return back()->with('success', 'Organisation created successfully!');
}

// Method to update organisation details
public function clientmasterupdate(Request $request, $id)
{
    $organisation = \DB::table('organisations')->where('id', $id)->first();

    if (!$organisation) {
        return back()->with('error', 'Organisation not found');
    }

    $data = $request->validate([
        'name' => 'required|string|max:50',
        'client_name' => 'nullable|string|max:225',
        'email' => 'required|email|max:50|unique:organisations,email,' . $id,

        // Password optional on update
        'password' => 'nullable|string|min:6',

        'contact_person' => 'nullable|string|max:225',
        'mobile' => 'nullable|string|max:15',

        // Address
        'building_no' => 'nullable|string|max:10',
        'premises_name' => 'nullable|string|max:100',
        'landmark' => 'nullable|string|max:150',
        'road_street' => 'nullable|string|max:150',
        'pincode' => 'nullable|string|max:15',
        'district' => 'nullable|string|max:50',
        'state' => 'nullable|string|max:50',
        'country' => 'nullable|string|max:50',

        'GST_number' => 'nullable|string|max:15',
        'industry_type' => 'nullable|string|max:225',
        'number_of_emplooyees' => 'nullable|integer',
        'software_package_plan' => 'nullable|string|max:225',
        'storage_limit' => 'nullable|string|max:225',
        'number_of_user_allowed' => 'nullable|integer',
        'TAN' => 'nullable|string|max:10',
        'PAN' => 'nullable|string|max:10',
        'expire_date' => 'nullable|date',

        // Certificates
        'MSME_udyam_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        'GST_registration_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',

        'organisation_status' => 'nullable|in:Active,Incative',
    ]);

    if (!empty($data['password'])) {
        $data['password'] = bcrypt($data['password']);
    } else {
        unset($data['password']); // don't update password
    }

    // File uploads
    if ($request->hasFile('MSME_udyam_certificate')) {
        $data['MSME_udyam_certificate'] = file_get_contents($request->file('MSME_udyam_certificate'));
    }

    if ($request->hasFile('GST_registration_certificate')) {
        $data['GST_registration_certificate'] = file_get_contents($request->file('GST_registration_certificate'));
    }

    \DB::table('organisations')->where('id', $id)->update($data);

    return back()->with('success', 'Organisation updated successfully!');
}

// Method to get list of organisations users
public function getOrganisations()
{
    $organisations = \DB::table('organisations')->orderBy('id', 'ASC')->get();

    return view('organisation_list', compact('organisations'));
}



}
 